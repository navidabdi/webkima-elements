<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements;

final class Init
{
  /**
   *  Store all the classes inside an array
   * @return array Full list of classes
   */

  public static function get_services()
  {
    $default_services = [Base\Enqueue::class];
    $extra_services = [];
    if (!empty(get_option("webkima_elements")["we_goup_btn"])) {
      $gotoup = Widgets\Gotoup::class;
      array_push($extra_services, $gotoup);
    }
    $final_servises = array_merge($default_services, $extra_services);
    return $final_servises;
  }

  /**
   * Loop through the classes, initialize them,
   * and call the register() method if exists
   * @return
   */
  public static function register_services()
  {
    foreach (self::get_services() as $class) {
      $service = self::instantiate($class);
      if (method_exists($service, "register")) {
        $service->register();
      }
    }
  }

  /**
   * Initialize the class
   * @param class $class    class from the services array
   * @return class instance new instance of the class
   */
  private static function instantiate($class)
  {
    $service = new $class();
    return $service;
  }
}
