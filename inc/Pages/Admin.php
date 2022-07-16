<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Pages;

use WebkimaElements\Api\SettingsApi;

class Admin
{
  public $settings;

  public $pages = [];

  public function __construct()
  {
    $this->settings = new SettingsApi();

    $this->pages = [
      [
        'page_title' => __('Webkima Elements', 'webkima-elements'),
        'menu_title' => __('Webkima Elements', 'webkima-elements'),
        'capability' => 'manage_options',
        'menu_slug' => 'webkima_elements',
        'callback' => function () {
          echo '<h1>' . __('Webkima Elements', 'webkima-elements') . '</h1>';
        },
        'icon_url' => WEBKIMA_ELEMENTS_URL . 'assets/icons/webkima-logo.svg',
        'position' => 50,
      ],
    ];
  }

  public function register()
  {
    $this->settings->addPages($this->pages)->register();
  }
}
