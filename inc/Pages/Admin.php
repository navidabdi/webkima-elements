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
        'page_title' => 'Webkima Elements',
        'menu_title' => 'Webkima Elements',
        'capability' => 'manage_options',
        'menu_slug' => 'webkima_elements',
        'callback' => function () {
          echo '<h1>' . __('Webkima Elements', 'webkima-elements') . '</h1>';
        },
        'icon_url' => WEBKIMA_ELEMENTS_URL . 'assets/icons/webkima-logo.svg',
        'position' => 50,
      ],
    ];

    $this->subpages = [
      [
        'parent_slug' => 'webkima_elements',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT',
        'capability' => 'manage_options',
        'menu_slug' => 'webkima_cpt',
        'callback' => function () {
          echo '<h1>CPT Manager</h1>';
        },
      ],
    ];
  }

  public function register()
  {
    $this->settings->addPages($this->pages)->register();
  }
}
