<?php
/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 */

/**
 * Plugin Name: Webkima Elements
 * Plugin URI: https://wordpress.org/plugins/webkima-elements/
 * Description: A very light plugin for Persianization and installation of Persian fonts on the free and Pro Elementor plugin
 * Version: 1.5.0
 * Author: Webkima Academy
 * Author URI: https://webkima.com/
 * Text Domain: webkima-elements
 * Domain Path: /languages
 * License: GPLv2 or later
 * Elementor tested up to: 3.8.1
 * Elementor Pro tested up to: 3.8.2
 */

namespace WebkimaElements;

use WebkimaElements\Base;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit;
}

define('WEBKIMA_ELEMENTS_PATH', plugin_dir_path( __FILE__ ));
define('WEBKIMA_ELEMENTS_WIDGET_CSS_PATH', WEBKIMA_ELEMENTS_PATH . 'assets/dist/css/');
define('WEBKIMA_ELEMENTS_URL', plugin_dir_url( __FILE__ ));
define('WEBKIMA_ELEMENTS_ASSETS_URL', WEBKIMA_ELEMENTS_URL . 'assets/');
define("WEBKIMA_ELEMENTS_VER", "1.5.0");

/**
 * Loads PSR-4-style plugin classes.
 *
 * @since  1.0.0
 * @return void
 */
function classloader($class): void {
    static $ns_offset;
    if (str_starts_with($class, __NAMESPACE__ . '\\')) {
        if ($ns_offset === NULL) {
            $ns_offset = strlen(__NAMESPACE__) + 1;
        }
        include __DIR__ . '/src/' . strtr(substr($class, $ns_offset), '\\', '/') . '.php';
    }
}

spl_autoload_register(__NAMESPACE__ . '\classloader');


register_activation_hook(__FILE__, __NAMESPACE__ . '\Base::activate');
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\Base::deactivate');
register_uninstall_hook(__FILE__, __NAMESPACE__ . '\Base::uninstall');

add_action("csf_init", __NAMESPACE__ . '\Plugin::loadTextDomain');
add_action('plugins_loaded', __NAMESPACE__ . '\Plugin::loadTextDomain');

Base::register();
add_action('init', __NAMESPACE__ . '\Plugin::pre_init', 0);
add_action('init', __NAMESPACE__ . '\Plugin::init', 20);