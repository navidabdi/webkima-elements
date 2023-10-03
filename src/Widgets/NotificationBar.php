<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Base
 */

namespace WebkimaElements\Widgets;

use WebkimaElements\Base;

class NotificationBar {

  /**
   * Init the NotificationBar class
   *
   * @uses init
   */
  public static function init(): void {
    (new NotificationBar)->notificationBar();
  }

}
