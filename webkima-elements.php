<?php

/*
* @package WebkimaElements
*/

/**
 * Plugin Name: وبکیما المنت
 * Plugin URI: https://webkima.com/
 * Description: بسته فارسی ساز افزونه المنتور پرو به همراه اضافه شدن 13 فونت فارسی، تقویم شمسی برای المنتور، قالب های آماده فارسی در کتابخانه المنتور و آیکون های ایرانی
 * Version: 1.0
 * Author: آکادمی وبکیما
 * Author URI: https://webkima.com/
 * Text Domain: webkima-element
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
