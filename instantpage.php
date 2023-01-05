<?php
/**
 * @package         System - Unofficial instant.page
 * @version         1.0.4
 * @copyright       Copyright (C) 2020 Mateusz Hajder. All rights reserved.
 * @license         http://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3 or later
 */

defined('_JEXEC') or die('Restricted access');

if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

jimport('joomla.plugin.plugin');

/**
 * Plugin class
 *
 * @since 1.0.0
 */
class plgSystemInstantPage extends JPlugin
{
    /**
     * @var bool
     * @since 1.0.0
     */
    protected $autoloadLanguage = true;

    /**
     * @throws Exception
     * @since 1.0.0
     */
    public function onAfterRender()
    {
        $version_hashes_cdn = array(
            '5.1.1' => 'sha384-MWfCL6g1OTGsbSwfuMHc8+8J2u71/LA8dzlIN3ycajckxuZZmF+DNjdm7O6H3PSq',
            '5.1.0' => 'sha384-by67kQnR+pyfy8yWP4kPO12fHKRLHZPfEsiSXR8u2IKcTdxD805MGUXBzVPnkLHw',
            '5.0.1' => 'sha384-0DvoZ9kNcB36fWcQApIMIGQoTzoBDYTQ85e8nmsfFOGz4RHAdUhADqJt4k3K2uLS',
            '5.0.0' => 'sha384-3Ye7Fh2Nd1zIjpuW5wbErksDUfqshUg7hMLM/b68dnbmCbQaMWI+cjHa8F8dXwEQ',
            '3.0.0' => 'sha384-OeDn4XE77tdHo8pGtE1apMPmAipjoxUQ++eeJa6EtJCfHlvijigWiJpD7VDPWXV1',
            '2.0.1' => 'sha384-4Duao6N1ACKAViTLji8I/8e8H5Po/i/04h4rS5f9fQD6bXBBZhqv5am3/Bf/xalr',
            '2.0.0' => 'sha384-D7B5eODAUd397+f4zNFAVlnDNDtO1ppV8rPnfygILQXhqu3cUndgHvlcJR2Bhig8',
            '1.3.1' => 'sha384-rtpNW06xJckBndFDJIJW076PpDuKl3bzoJJCriXfUpocS6YNHpjlqBPrfQqmTR2D',
            '1.3.0' => 'sha384-N9ZcQPkU0g0UAvhg9ScfoyHDzEhvZiz83S6uH2JHy0dFW151TXWy9Ceqo2Nt9wdH',
            '1.2.2' => 'sha384-2xV8M5griQmzyiY3CDqh1dn4z3llDVqZDqzjzcY+jCBCk/a5fXJmuZ/40JJAPeoU',
            '1.2.1' => 'sha384-/IkE5iZAM/RxPto8B0nvKlMzIyCWtYocF01PbGGp1qElJuxv9J4whdWBRtzZltWn',
            '1.2.0' => 'sha384-0xWpXpkOUkAVETH+RMYJlSFIDNGlnPHgmqv2rP3uZS1BM48EMcxAZGW09n4pTGV4',
            '1.1.1' => 'sha384-6EHq9RqnwggURiIyLEP4ihl1kVm6BB6mrBfLXybMmVfTro08M58cH/IUvd//AO/W',
            '1.1.0' => 'sha384-EwBObn5QAxP8f09iemwAJljc+sU+eUXeL9vSBw1eNmVarwhKk2F9vBEpaN9rsrtp',
            '1.0.0' => 'sha384-6w2SekMzCkuMQ9sEbq0cLviD/yR2HfA/+ekmKiBnFlsoSvb/VmQFSi/umVShadQI',
        );

        $version_hashes_js = array(
            '5.1.1' => 'sha384-vOYzodq3RtQ/mAKrLKXzuBjGM3foPaWww7ExPRiB9jIHCCPilqj9RFsHcy5+gemR',
            '5.1.0' => 'sha384-UjWHPpa2gj1V2r6gD3NgNK6zgI1naHmJUr6Iy9vh2X/gCmxeuJqRqtYvYF7SonRl',
            '5.0.1' => 'sha384-KX61lqdJoMCZGHtDaqOkk8AcY0kAAURmOLy6niJ5ZThKUzD0s0UN6BdAt5FcmWyu',
            '5.0.0' => 'sha384-cJcNBwoXqnKWM4LzHsgS38iKjXzKwtjN5qD7UG4hVZaHbL9U9H/rO0QnyIfzZOgP',
            '3.0.0' => 'sha384-kRe2Ef4hUL7umEOxccHOfdswcn+CqzDTqsU0IWoiatvAKoHuIajV1wN6GYwjlPHC',
            '2.0.1' => 'sha384-T0LMrRq4DhEj7z5BFARG7VSZH8gE9R+HbgpfLET4COdB+y40LEFIaQ8mD9lAAsQz',
            '2.0.0' => 'sha384-tbxWf3s1ijOADHp8Gg5pXjaZIshCX/oLlJs4lLWXmxjCw6IdwnyEaI+18thIeFvq',
            '1.3.1' => 'sha384-5AGxRZLowWyAJubcRMzADCRDKnNU3r+5HN/j7x/f5nMGBm8YJiDXct8NVNkoZQB0',
            '1.3.0' => 'sha384-JGof1xqoUrW0SEBfIbAQW97qzrlow81BSGsmm2vPX976lAxCNYfMLowvfxiSkQRQ',
            '1.2.2' => 'sha384-B7owwD9uhVEzUfAfI6qNlI6+r8wqvDxPWB5tdmviKb9xzpz/4lWFJO/K6QtVO/gm',
            '1.2.1' => 'sha384-2mKJylCpUrSfs1RN/tzjdM5fSE1AlVX+DH4FD50uWdzga1wZYFsIF+vwwLKtYsrt',
            '1.2.0' => 'sha384-fjvcqq+UHyspv0uYmzfc+1l3kBJqxbNY7v2pMNyS1K42B19/5qhq4KOAtn/k4Ffy',
            '1.1.1' => 'sha384-u799KyHXeX68n/ihGfXbYGF2CApZPB/UzBzX6q+YMsy48hBg/boc2afckSrjofhf',
            '1.1.0' => 'sha384-LvGNZfqKJUUvtP3ohv8vVL8/H4a4nmb0xMmObItMNZcuKmZXoIXwrtiHGNLrZnJL',
            '1.0.0' => 'sha384-mYiXeIbF7vvhK8zlv+CJiTUW1Mbqyxw4aUd4cb7vjWtOnDtQF2e2g3Msm8cUZmLA',
        );

        $app = JFactory::getApplication();
        $plg_path = \JURI::root(true) . '/plugins/system/instantpage';
        $version = $this->params->get('version', '');
        $official_cdn = $this->params->get('official_cdn', '');
        $defer = $this->params->get('defer', '');
        if ($defer == 1) {
            $defer = ' defer';
        } else {
            $defer = '';
        }
        $other_attributes = $this->params->get('other_attributes', '');

        // only insert the script in the frontend
        if ($app->isClient('site')) {

            // retrieve all the response as an html string
            $content = $app->getBody();

            if ($official_cdn == '1') {
                $version_hash = $version_hashes_cdn[$version];
                $tag = '<script src="//instant.page/' . $version . '" type="module" integrity="' . $version_hash . '"' . $defer . '></script>';
            } else {
                $version_hash = $version_hashes_js[$version];
                $tag = '<script src="' . $plg_path . '/js/instantpage-' . $version . '.js' . '" type="module" integrity="' . $version_hash . '"' . $defer . '></script>';
            }

            if (!empty($other_attributes)) {
                if (preg_match('/(<body.*?)(class *= *"|\')(.*)("|\')(.*>)/', $content)) {
                    $content = preg_replace(
                        '/(<body.*?)(class *= *"|\')(.*)("|\')(.*>)/',
                        '$1$2$3$4 ' . $other_attributes . '$5',
                        $content);
                } elseif (preg_match('/(<body.*?)(>)/', $content)) {
                    $content = preg_replace(
                        '/(<body.*?)(>)/',
                        '$1 ' . $other_attributes . '">',
                        $content);
                }
            }

            $content = str_replace('</body>', $tag . '</body>', $content);

            // override the original response
            $app->setBody($content);
        }
    }
}
