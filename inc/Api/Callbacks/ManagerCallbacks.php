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
    $output = [];

    foreach ($this->managers as $key => $value) {
      $output[$key] = isset($input[$key]) ? true : false;
    }

    return $output;
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
    $option_name = $args['option_name'];
    $checkbox = get_option($option_name);
    $checked = isset($checkbox[$name])
      ? ($checkbox[$name]
        ? true
        : false)
      : false;

    echo '<div class="' .
      $classes .
      '"><input type="checkbox" id="' .
      $name .
      '" name="' .
      $option_name .
      '[' .
      $name .
      ']" value="1" class="" ' .
      ($checked ? 'checked' : '') .
      '><label for="' .
      $name .
      '"><div></div></label></div>';
  }
}
