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
  }
}
