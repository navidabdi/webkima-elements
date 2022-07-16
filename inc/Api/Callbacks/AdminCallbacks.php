<?php
/**
 * @package  WebkimaElements
 */
namespace WebkimaElements\Api\Callbacks;

use WebkimaElements\Base\BaseController;

class AdminCallbacks extends BaseController
{
  public function adminDashboard()
  {
    return require_once "$this->plugin_path/templates/admin.php";
  }
}
