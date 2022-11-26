<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Enqueue
 */

namespace WebkimaElements;

class DynamicAssets {

  public static $styles = [];

  public static $root = ABSPATH;

  public static function printStyles() {
    return self::$styles;
  }
}
