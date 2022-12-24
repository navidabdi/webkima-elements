<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Base
 */

namespace WebkimaElements;

use WebkimaElements\Widgets\Gotoup;
use WebkimaElements\Enqueue;
use WebkimaElements\DynamicAssets;

class Base {
    
  public static function register(): void {
    require_once WEBKIMA_ELEMENTS_PATH . 'lib/options.php';
    add_action('admin_menu', __CLASS__ . '::webkimaElementsPanel');

    require_once WEBKIMA_ELEMENTS_PATH . 'src/Elementor/TemplatesManager.php';

    if (!empty(get_option('webkima_elements')['we_goup_btn'])) {
      Gotoup::register();
    }
  }

  public static function isOptionActivated(string $key): bool {
    $option = get_option('webkima_elements');

    return $option[ $key ] ?? false;
  }

  /**
   * Registers activation hook callback.
   *
   * @return void
   * @since  1.0.0
   */
  public static function activate(): void {
    DynamicAssets::generateStylesAdnJavaScripts();
  }

  /**
   * Registers deactivation hook callback.
   *
   * @return void
   * @since  1.0.0
   */
  public static function deactivate(): void {

  }

  /**
   * Registers uninstall hook callback.
   *
   * @return void
   * @since  1.0.0
   */
  public static function uninstall(): void {

  }

  public static function webkimaElementsPanel(): void {
    add_menu_page(
      __('Webkima Elements', 'webkima-elements'),
      __('Webkima Elements', 'webkima-elements'),
      'manage_options',
      'webkima-elements',
      __CLASS__ . '::webkimaElementsPanelCallback',
      WEBKIMA_ELEMENTS_URL . '/assets/icons/webkima-logo.svg',
      58
    );
  }

  /**
   * Returns true if all dependencies for the plugin are loaded
   *
   * @return bool
   * @since      1.7.0
   */
  public static function hasSatisfiedDependencies(): bool {
    $dependency_errors = self::getDependencyErrors();

    return 0 === count($dependency_errors);
  }

  /**
   * Get an array of dependency error messages
   *
   * @return array all dependency error message.
   * @since      1.7.0
   */
  public static function getDependencyErrors(): array {
    $errors                    = [];
    $wordpress_version         = get_bloginfo('version');
    $minimum_wordpress_version = self::getMinWp();
    $minimum_php_version       = self::getMinPHP();

    $wordpress_minimum_met = version_compare($wordpress_version, $minimum_wordpress_version, '>=');
    $php_minimum_met       = version_compare(phpversion(), $minimum_php_version, '>=');

    if (!$wordpress_minimum_met) {
      $errors['wordpress_minimum_met'] = sprintf(
      /* translators: 1. link of WordPress 2. version of WordPress. */
        __(
          'برای استفاده از افزونه وبکیما المنت باید <a href="%1$s">وردپرس</a> %2$s به بالا را نصب داشته باشید.',
          'webkima-elements'
        ),
        'https://wordpress.org/',
        $minimum_wordpress_version
      );
    }

    if (!$php_minimum_met) {
      $errors['php_minimum_met'] = sprintf(
      /* translators: 1. version of php */
        __(
          'برای استفاده از افزونه وبکیما المنت باید <strong>نسخه PHP %s</strong> به بالا را نصب داشته باشید.',
          'webkima-elements'
        ),
        $minimum_php_version
      );
    }

    return $errors;
  }

  /**
   * Get require WordPress version
   *
   * @return string min require WordPress version
   * @since      1.7.0
   */
  public static function getMinWp(): string {
    $file_info = get_file_data(WEBKIMA_ELEMENTS_MAIN_FILE_PATH, [
      'min_wp' => 'Requires at least',
    ]);

    return $file_info['min_wp'];
  }

  /**
   * Get require WooCommerce version
   *
   * @return string min require WooCommerce version
   * @since      1.0.0
   */
  public static function getMinWc(): string {
    $file_info = get_file_data(WEBKIMA_ELEMENTS_MAIN_FILE_PATH, [
      'min_wc' => 'WC requires at least',
    ]);

    return $file_info['min_wc'];
  }

  /**
   * Get required min php version
   *
   * @return string min require php version
   * @since      1.7.0
   */
  public static function getMinPHP(): string {
    $file_info = get_file_data(WEBKIMA_ELEMENTS_MAIN_FILE_PATH, [
      'min_php' => 'Requires PHP',
    ]);

    return $file_info['min_php'];
  }

  /**
   * Get plugin version
   *
   * @return string current version of plugin
   * @since      1.7.0
   */
  public static function getPluginVersion(): string {
    $plugin_data = get_file_data(WEBKIMA_ELEMENTS_MAIN_FILE_PATH, [
      'Version' => 'Version',
    ]);

    return $plugin_data['Version'];
  }


  public static function webkimaElementsPanelCallback(): void {
    ?>
      <div class='wrap about-wrap' style='font-family:iranyekan'>
      <h1><?php echo __('Welcome to Webkima Elements :)', 'webkima-elements'); ?></h1>
      <div class='about-text'><?php echo __(
          'More feature with better performance',
          'webkima-elements'
        ); ?></div>
      <a class='webkima-logo' href='https://webkima.com/' target='_blank'
         style='background-image:url(<?php echo plugins_url(
           'webkima-elements/assets/icons/logo.png'
         ); ?>) !important;background-position: center center;'></a>

      <h2 class='nav-tab-wrapper'>
          <a class='nav-tab nav-tab-active' href='#'><?php echo __('Settings', 'webkima-elements'); ?></a>
      </h2>
    <?php
  }

}
