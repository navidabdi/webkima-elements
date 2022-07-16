<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Pages;

use WebkimaElements\Api\SettingsApi;
use WebkimaElements\Base\BaseController;
use WebkimaElements\Api\Callbacks\AdminCallbacks;
use WebkimaElements\Api\Callbacks\ManagerCallbacks;

class Admin extends BaseController
{
  public $settings;

  public $callbacks;
  public $callbacks_mngr;

  public $pages = [];

  public $subpages = [];

  public function register()
  {
    $this->settings = new SettingsApi();

    $this->callbacks = new AdminCallbacks();
    $this->callbacks_mngr = new ManagerCallbacks();

    $this->setPages();

    $this->setSubpages();

    $this->setSettings();
    $this->setSections();
    $this->setFields();

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
        'position' => 58,
      ],
    ];
  }

  public function setSubpages()
  {
    $this->subpages = [];
  }

  public function setSettings()
  {
    $args = [
      [
        'option_group' => 'webkima_elements_settings',
        'option_name' => 'webkima_elements',
        'callback' => [$this->callbacks_mngr, 'checkboxSanitize'],
      ],
    ];

    $this->settings->setSettings($args);
  }

  public function setSections()
  {
    $args = [
      [
        'id' => 'webkima_elements_admin_index',
        'title' => __('Settings', 'webkima-elements'),
        'callback' => [$this->callbacks_mngr, 'adminSectionManager'],
        'page' => 'webkima_elements',
      ],
    ];

    $this->settings->setSections($args);
  }

  public function setFields()
  {
    $args = [];

    foreach ($this->managers as $key => $value) {
      $args[] = [
        'id' => $key,
        'title' => $value,
        'callback' => [$this->callbacks_mngr, 'checkboxField'],
        'page' => 'webkima_elements',
        'section' => 'webkima_elements_admin_index',
        'args' => [
          'option_name' => 'webkima_elements',
          'label_for' => $key,
          'class' => 'ui-toggle',
        ],
      ];
    }

    $this->settings->setFields($args);
  }
}
