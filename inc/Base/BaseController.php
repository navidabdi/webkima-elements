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
  public $managers = [];

  public function __construct()
  {
    $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
    $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
    $this->plugin =
      plugin_basename(dirname(__FILE__, 3)) . '/webkima-elements.php';
    $this->text_domain = 'webkima-elements';

    $this->managers = [
      'font_backend' => 'Activate Font On WordPress Dashboard',
      'font_frontend' => 'Activate Font On The Front-End',
      'font_elementor_editor' => 'Activate Font On Elementor Editor',
    ];
  }

  public function activated(string $key)
  {
    $option = get_option('webkima_elements');

    return isset($option[$key]) ? $option[$key] : false;
  }
}
