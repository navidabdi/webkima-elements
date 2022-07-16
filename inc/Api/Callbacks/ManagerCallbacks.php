<?php
/**
 * @package  WebkimaElements
 */
namespace WebkimaElements\Api\Callbacks;

use WebkimaElements\Base\BaseController;

class ManagerCallbacks extends BaseController
{
  public function checkboxSanitize($input)
  {
    // return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    return isset($input) ? true : false;
  }

  public function adminSectionManager()
  {
    _e(
      'Manage the Features of Webkima Elements Plugin by activating the checkboxes from the following list.',
      'webkima-elements'
    );
  }

  public function checkboxField($args)
  {
    $name = $args['label_for'];
    $classes = $args['class'];
    $checkbox = get_option($name);
    echo '<div class="' .
      $classes .
      '"><input type="checkbox" id="' .
      $name .
      '" name="' .
      $name .
      '" value="1" class="" ' .
      ($checkbox ? 'checked' : '') .
      '><label for="' .
      $name .
      '"><div></div></label></div>';
  }
}
