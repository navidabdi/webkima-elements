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

  public function webkimaElementsTextExample()
  {
    $value = esc_attr(get_option('text_example'));
    echo '<input type="text" class="regular-text" name="text_example" value="' .
      $value .
      '" placeholder="Write Something Here!">';
  }

  public function webkimaElementsFirstName()
  {
    $value = esc_attr(get_option('first_name'));
    echo '<input type="text" class="regular-text" name="first_name" value="' .
      $value .
      '" placeholder="Write your First Name">';
  }
}
