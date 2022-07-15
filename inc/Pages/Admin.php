<?php

namespace WebkimaElements\Pages;
use WebkimaElements\Base\BaseController;

class Admin extends BaseController
{
  public static function add_admin_pages()
  {
    add_menu_page(
      'Webkima Elements',
      __('Webkima Elements', 'webkima-elements'),
      'manage_options',
      'webkima_elements',
      ['WebkimaElements\Pages\Admin', 'admin_index'],
      WEBKIMA_ELEMENTS_URL . 'assets/icons/webkima-logo.svg',
      59
    );
  }

  public static function register()
  {
    add_action('admin_menu', [
      'WebkimaElements\Pages\Admin',
      'add_admin_pages',
    ]);
  }

  public static function admin_index()
  {
    require_once $this->plugin_path . 'templates/admin.php';
  }
}
