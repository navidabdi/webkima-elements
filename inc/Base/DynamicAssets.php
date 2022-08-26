<?php

/**
 * @package  WebkimaElements
 *
 */

namespace WebkimaElements\Base;

class DynamicAssets
{
  public static $styles = [];

  public static function print_styles()
  {
    return self::$styles;
  }
}
