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
        'position' => 50,
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
        'option_group' => 'webkima_elements_options_group',
        'option_name' => 'text_example',
        'callback' => [$this->callbacks, 'webkimaElementsOptionsGroup'],
      ],
      [
        'option_group' => 'webkima_elements_options_group',
        'option_name' => 'first_name',
      ],
    ];

    $this->settings->setSettings($args);
  }

  public function setSections()
  {
    $args = [
      [
        'id' => 'webkima_elements_admin_index',
        'title' => 'Settings',
        'callback' => [$this->callbacks, 'webkimaElementsAdminSection'],
        'page' => 'webkima_elements',
      ],
    ];

    $this->settings->setSections($args);
  }

  public function setFields()
  {
    $args = [
      [
        'id' => 'text_example',
        'title' => 'Text Example',
        'callback' => [$this->callbacks, 'webkimaElementsTextExample'],
        'page' => 'webkima_elements',
        'section' => 'webkima_elements_admin_index',
        'args' => [
          'label_for' => 'text_example',
          'class' => 'example-class',
        ],
      ],
      [
        'id' => 'first_name',
        'title' => 'First Name',
        'callback' => [$this->callbacks, 'webkimaElementsFirstName'],
        'page' => 'webkima_elements',
        'section' => 'webkima_elements_admin_index',
        'args' => [
          'label_for' => 'first_name',
          'class' => 'example-class',
        ],
      ],
    ];

    $this->settings->setFields($args);
  }
}
