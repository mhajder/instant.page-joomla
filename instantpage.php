<?php
/**
 * @package         System - Unofficial instant.page
 * @version         1.0.1
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
        $version_hashes = array(
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

        $app = JFactory::getApplication();
        $plg_path = \JURI::root(true) . '/plugins/system/instantpage';
        $version = $this->params->get('version', '');
        $official_cdn = $this->params->get('official_cdn', '');
        $defer = $this->params->get('defer', '');
        if ($defer == 1) {
            $defer = ' deffer';
        } else {
            $defer = '';
        }
        $other_attributes = $this->params->get('other_attributes', '');

        $version_hash = $version_hashes[$version];

        // only insert the script in the frontend
        if ($app->isClient('site')) {

            // retrieve all the response as an html string
            $content = $app->getBody();

            if ($official_cdn == '1') {
                $tag = '<script src="//instant.page/' . $version . '" type="module" integrity="' . $version_hash . '"' . $defer . '></script>';
            } else {
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
