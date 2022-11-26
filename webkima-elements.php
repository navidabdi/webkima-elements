<?php
/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 */

/**
 * Plugin Name: Webkima Elements
 * Plugin URI: https://webkima.com/
 * Description: A very light plugin for Personalization and installation of Persian fonts on the free and Pro Elementor plugin
 * Version: 1.3.0
 * Author: Webkima Academy
 * Author URI: https://webkima.com/
 * Text Domain: webkima-elements
 * Domain Path: /languages
 * License: GPLv2 or later
 * Elementor tested up to: 3.7.7
 * Elementor Pro tested up to: 3.7.7
 */

namespace WebkimaElements;

use WebkimaElements\Base;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit;
}

define('WEBKIMA_ELEMENTS_PATH', plugin_dir_path( __FILE__ ));
define('WEBKIMA_ELEMENTS_URL', plugin_dir_url( __FILE__ ));
define('WEBKIMA_ELEMENTS_ASSETS_URL', WEBKIMA_ELEMENTS_URL . 'assets/');
define("WEBKIMA_ELEMENTS_VER", "1.3.0");

/**
 * Loads PSR-4-style plugin classes.
 *
 * @since  1.0.0
 * @return void
 */
function classloader($class) {
    static $ns_offset;
    if (strpos($class, __NAMESPACE__ . '\\') === 0) {
        if ($ns_offset === NULL) {
            $ns_offset = strlen(__NAMESPACE__) + 1;
        }
        include __DIR__ . '/src/' . strtr(substr($class, $ns_offset), '\\', '/') . '.php';
    }
}

spl_autoload_register(__NAMESPACE__ . '\classloader');

Base::register();

register_activation_hook(__FILE__, __NAMESPACE__ . '\Base::activate');
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\Base::deactivate');
register_uninstall_hook(__FILE__, __NAMESPACE__ . '\Base::uninstall');

add_action('plugins_loaded', __NAMESPACE__ . '\Plugin::load_textdomain');
add_action('init', __NAMESPACE__ . '\Plugin::pre_init', 0);
add_action('init', __NAMESPACE__ . '\Plugin::init', 20);


//require_once dirname(__FILE__) . "/inc/Elementor/TemplatesManager.php";
