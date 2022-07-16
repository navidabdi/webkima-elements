<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Base;

class Activate
{
  public static function activate()
  {
    flush_rewrite_rules();
    if (get_option('webkima_elements')) {
      return;
    }

    $default = [];

    update_option('webkima_elements', $default);
  }
}
