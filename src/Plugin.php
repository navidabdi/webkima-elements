<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Plugin
 */

namespace WebkimaElements;

use WebkimaElements\Enqueue;
use WebkimaElements\Base;

class Plugin {

  const PERFIX = 'webkima-elements';

  const L10N = self::PERFIX;

  /**
   * Registers on plugin loaded.
   *
   * @return void
   * @since  1.7.0
   */
  public static function onPluginLoaded(): void {
    self::loadTextDomain();
    if (!Base::hasSatisfiedDependencies()) {
      add_action('admin_notices', __CLASS__ . '::renderDependenciesNotice');
    }
  }

  /**
   * Notify about plugin dependency
   *
   * @return void
   * @since      1.7.0
   */
  public static function renderDependenciesNotice(): void {
    $user_id = get_current_user_id();
    foreach (Base::getDependencyErrors() as $key => $message) {
      if (!get_user_meta($user_id, 'webkima_elements_notice_dismissed_' . $key)) {
        printf(
          '<div class="error"><p>%1$s</p><a href="?webkima-elements-dismissed-%2$s">%3$s</a></div>',
          $message,
          $key,
          __('بستن', 'webkima-elements')
        );
      }
    }
  }

  public static function adminNoticeDismissed(): void {
    $user_id = get_current_user_id();
    foreach (Base::getDependencyErrors() as $key => $message) {
      if (isset($_GET['webkima-elements-dismissed-' . $key])) {
        add_user_meta($user_id, 'webkima_elements_notice_dismissed_' . $key, 'true', true);
      }
    }
  }

  /**
   * Registers pre init hooks.
   *
   * @return void
   * @since  1.0.0
   */
  public static function pre_init(): void {

  }

  /**
   * Registers init hooks.
   *
   * @return void
   * @since  1.0.0
   */
  public static function init(): void {
    self::adminNoticeDismissed();
    Enqueue::init();
    RegisterElementorWidgets::init();
    DynamicAssets::init();
  }

  /**
   * Registers and loads text domains.
   *
   * @return void
   * @since  1.0.0
   */
  public static function loadTextDomain(): void {
    load_plugin_textdomain('webkima-elements', false, 'webkima-elements/languages/');
  }

}