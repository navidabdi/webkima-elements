<?php

/**
 * Plugin Name: Webkima Elements
 * Plugin URI: https://webkima.com/
 * Description: A very light plugin for Persianization and installation of Persian fonts on the free and Pro Elementor plugin
 * Version: 1.0.0
 * Author: Webkima Academy
 * Author URI: https://webkima.com/
 * Text Domain: webkima-elements
 * Domain Path: /languages
 * License: GPLv2 or later
 * Elementor tested up to: 3.6.5
 * Elementor Pro tested up to: 3.7.0
 */

if (!defined('ABSPATH')) {
  die('You Can Not Access This File Directly!'); // Die if accessed directly
}

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}

// Define CONSTANTS
define('WEBKIMA_ELEMENTS_URL', plugin_dir_url(__FILE__));
define('WEBKIMA_ELEMENTS_PATH', plugin_dir_path(__FILE__));
define('WEBKIMA_ELEMENTS_NAME', plugin_basename(__FILE__));
define('WEBKIMA_ELEMENTS_TEXT_DOMAIN', 'webkima-elements');

// Load translation

function webkimaElementsI18n()
{
  load_plugin_textdomain(WEBKIMA_ELEMENTS_TEXT_DOMAIN);
}
add_action('init', 'webkimaElementsI18n');

// Localization
add_action('init', 'localizationWebkimaElements');
function localizationWebkimaElements()
{
  $path = dirname(plugin_basename(__FILE__)) . '/languages/';
  $loaded = load_plugin_textdomain(WEBKIMA_ELEMENTS_TEXT_DOMAIN, false, $path);

  if (isset($_GET['page']) && $_GET['page'] == basename(__FILE__) && !$loaded) {
    echo '<div class="error">Sample Localization: ' .
      __(
        'Could not load the localization file: ' . $path,
        WEBKIMA_ELEMENTS_TEXT_DOMAIN
      ) .
      '</div>';
    return;
  }
}

use WebkimaElements\Base\Activate;
use WebkimaElements\Base\Deactivate;

/*
 * The code that runs during plugin activation
 */
function activate_webkima_elements()
{
  Activate::activate();
}
register_activation_hook(__FILE__, 'activate_webkima_elements');

/*
 * The code that runs during plugin deactivation
 */
function deactivate_webkima_elements()
{
  Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_webkima_elements');

/*
 * The code that runs during plugin Services
 */
if (class_exists('WebkimaElements\\Init')) {
  WebkimaElements\Init::register_services();
}
