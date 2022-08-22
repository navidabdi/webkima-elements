<?php
/**
 * @package WEBKIMA ELEMENTS
 */
defined("ABSPATH") or die();
/**
 * Settings class
 *
 * settings page --> Webkima Elements
 *
 * @since 1.2.0
 */

require_once WEBKIMA_ELEMENTS_PATH .
  "lib/codestar-framework/codestar-framework.php";

// Control core classes for avoid errors
if (class_exists("EFS")) {
  //
  // Set a unique slug-like ID
  $prefix = "webkima_elements";

  //
  // Create options
  EFS::createOptions($prefix, [
    // framework title
    "framework_title" => __("Webkima Elements", "webkima-elements"),
    "framework_class" => "",

    // menu settings
    "menu_title" => __("Webkima Elements", "webkima-elements"),
    "menu_slug" => "webkima-elements",
    "menu_type" => "submenu",
    "menu_capability" => "manage_options",
    "menu_icon" => "",
    "menu_position" => null,
    "menu_hidden" => false,
    "menu_parent" => "",

    // menu extras
    "show_bar_menu" => false,
    "show_sub_menu" => false,
    "show_in_network" => true,
    "show_in_customizer" => false,

    "show_search" => false,
    "show_reset_all" => true,
    "show_reset_section" => true,
    "show_footer" => false,
    "show_all_options" => true,
    "show_form_warning" => true,
    "sticky_header" => true,
    "save_defaults" => true,
    "ajax_save" => true,

    // admin bar menu settings
    "admin_bar_menu_icon" => "",
    "admin_bar_menu_priority" => 80,

    // footer
    "footer_text" => __("Webkima Elements", "webkima-elements"),
    "footer_after" => "",
    "footer_credit" => __("Webkima Elements", "webkima-elements"),

    // database model
    "database" => "", // options, transient, theme_mod, network
    "transient_time" => 0,

    // contextual help
    "contextual_help" => [],
    "contextual_help_sidebar" => "",

    // typography options
    "enqueue_webfont" => true,
    "async_webfont" => false,

    // others
    "output_css" => true,

    // theme and wrapper classname
    "nav" => "normal",
    "theme" => "dark",
    "class" => "",

    // external default values
    "defaults" => [],
  ]);

  //
  // Create a section
  EFS::createSection($prefix, [
    "title" => __("main settings", "webkima-elements"),
    "icon" => "fas fa-rocket",
    "fields" => [
      [
        "type" => "content",
        "content" =>
          __("plugin version", "webkima-elements") .
          ": " .
          WEBKIMA_ELEMENTS_VER,
      ],
      [
        "id" => "we-select-font",
        "type" => "select",
        "title" => __("Chose your favoriate font", "webkima-elements"),
        "subtitle" => __(
          "Chose a font to use as main font on all pages of the website.",
          "webkima-elements"
        ),
        "placeholder" => __("Chose a font", "webkima-elements"),
        "options" => [
          "iranyekan" => __("iranyekan", "webkima-elements"),
          "vazir" => __("vazir", "webkima-elements"),
        ],
        "default" => "iranyekan",
      ],

      [
        "id" => "we_font_backend",
        "type" => "switcher",
        "title" => __("Font On WordPress Dashboard", "webkima-elements"),
        "text_on" => __("active", "webkima-elements"),
        "text_off" => __("deactive", "webkima-elements"),
        "subtitle" => __(
          "Activate Font On WordPress Dashboard",
          "webkima-elements"
        ),
        "default" => true,
        "text_width" => 70,
      ],
      [
        "id" => "we_font_frontend",
        "type" => "switcher",
        "title" => __("Font On The Front-End", "webkima-elements"),
        "text_on" => __("active", "webkima-elements"),
        "text_off" => __("deactive", "webkima-elements"),
        "subtitle" => __("Activate Font On The Front-End", "webkima-elements"),
        "default" => true,
        "text_width" => 70,
      ],
      [
        "id" => "we_font_elementor_editor",
        "type" => "switcher",
        "title" => __("Font On Elementor Editor", "webkima-elements"),
        "text_on" => __("active", "webkima-elements"),
        "text_off" => __("deactive", "webkima-elements"),
        "subtitle" => __(
          "Activate Font On Elementor Editor",
          "webkima-elements"
        ),
        "default" => true,
        "text_width" => 70,
      ],
    ],
  ]);
  EFS::createSection($prefix, [
    "title" => __("دکمه بازگشت به بالا", "webkima-elements"),
    "icon" => "fas fa-chevron-circle-up",
    "fields" => [
      [
        "id" => "we_goup_btn",
        "type" => "switcher",
        "title" => __("دکمه بازگشت به بالا", "webkima-elements"),
        "text_on" => __("active", "webkima-elements"),
        "text_off" => __("deactive", "webkima-elements"),
        "subtitle" => __(
          "فعال کردن دکمه بازگشت به بالا در تمامی صفحات سایت",
          "webkima-elements"
        ),
        "default" => false,
        "text_width" => 70,
      ],
    ],
  ]);

  EFS::createSection($prefix, [
    "title" => __("About", "webkima-elements"),
    "icon" => "far fa-star",
    "fields" => [
      [
        "type" => "content",
        "content" => __(
          'This plugin is developed by Webkima Academy team.
       we wanna add a lot of cool feaure to this plugin as soon as posible.
       Notice: We try our best to keep this plugin as fast as we can.',
          "webkima-elements"
        ),
      ],
      [
        "type" => "content",
        "content" => __(
          "Developed by Nabi Abdi and Webkima Team.",
          "webkima-elements"
        ),
      ],
    ],
  ]);
}
