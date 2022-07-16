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
      'fonts_manager' => 'Activate Fonts',
      'elements_manager' => 'Activate Elements',
    ];
  }
}
