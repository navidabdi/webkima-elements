<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Pages;

use WebkimaElements\Api\SettingsApi;
use WebkimaElements\Base\BaseController;
use WebkimaElements\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController
{
  public $settings;

  public $callbacks;

  public $pages = [];

  public $subpages = [];

  public function register()
  {
    $this->settings = new SettingsApi();

    $this->callbacks = new AdminCallbacks();

    $this->setPages();

    $this->setSubpages();

    $this->settings
      ->addPages($this->pages)
      ->withSubPage('Dashboard')
      ->addSubPages($this->subpages)
      ->register();
  }

  public function setPages()
  {
    $this->pages = [
      [
        'page_title' => 'Webkima Elements',
        'menu_title' => 'Webkima Elements',
        'capability' => 'manage_options',
        'menu_slug' => 'webkima_elements',
        'callback' => [$this->callbacks, 'adminDashboard'],
        'icon_url' => WEBKIMA_ELEMENTS_URL . 'assets/icons/webkima-logo.svg',
        'position' => 50,
      ],
    ];
  }

  public function setSubpages()
  {
    $this->subpages = [];
  }
}
