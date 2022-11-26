<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Enqueue
 */

namespace WebkimaElements;

class DynamicAssets {

  public static array $styles = [];

  public static function printStyles(): array {
    return self::$styles;
  }
}
