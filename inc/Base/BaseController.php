<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Base;

class BaseController
{
  public $plugin_path;
  public $plugin_url;
  public $plugin;
  public $text_domain;

  public function __construct()
  {
    $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
    $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
    $this->plugin =
      plugin_basename(dirname(__FILE__, 3)) . "/webkima-elements.php";
    $this->text_domain = "webkima-elements";

    require_once $this->plugin_path . "/inc/options.php";
    add_action("admin_menu", [$this, "webkima_elements_panel"]);
  }

  public function activated(string $key)
  {
    $option = get_option("webkima_elements");

    return isset($option[$key]) ? $option[$key] : false;
  }

  public function webkima_elements_panel()
  {
    add_menu_page(
      __("Webkima Elements", "webkima-elements"),
      __("Webkima Elements", "webkima-elements"),
      "manage_options",
      "webkima-elements",
      [$this, "webkima_elements_panel_callback"],
      $this->plugin_url . "/assets/icons/webkima-logo.svg",
      58
    );
  }
  public function webkima_elements_panel_callback()
  {
    ?>
	<div class="wrap about-wrap" style="font-family:iranyekan">
		<h1><?php echo __("Welcome to Webkima Elements :)", "webkima-elements"); ?></h1>
		<div class="about-text"><?php echo __(
    "More feature with better performance",
    "webkima-elements"
  ); ?></div>
		<a class="wp-badge" href="https://webkima.com/" target="_blank"	style="background-color:#d9edff !important;background-image:url(<?php echo plugins_url(
    "webkima-elements/assets/icons/logo.png"
  ); ?>) !important;background-position: center center;background-size: 130px auto !important;"></a>

		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active" href="#"><?php echo __(
     "Settings",
     "webkima-elements"
   ); ?></a>
		</h2>
<?php
  }
}
