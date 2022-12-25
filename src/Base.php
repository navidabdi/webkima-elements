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

  public static array $errors = [];

  public static int $user_id;

  public static function register(): void {
    require_once WEBKIMA_ELEMENTS_PATH . 'lib/options.php';
    add_action('admin_menu', __CLASS__ . '::webkimaElementsPanel');

    require_once WEBKIMA_ELEMENTS_PATH . 'src/Elementor/TemplatesManager.php';

    if (!empty(get_option('webkima_elements')['we_goup_btn'])) {
      Gotoup::register();
    }
  }

  public static function init(): void {
    self::$user_id = get_current_user_id();
    self::handleCacheNotice();
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
    foreach (Base::getDependencyErrors() as $key => $message) {
      if (get_user_meta(self::$user_id, 'webkima_elements_notice_' . $key) !== null) {
        delete_user_meta(self::$user_id, 'webkima_elements_notice_' . $key);
      }
    }
    if (!empty(get_user_meta(self::$user_id, 'webkima_elements_cache_notice', true))) {
      delete_user_meta(self::$user_id, 'webkima_elements_cache_notice');
    }
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
      self::$errors['php_minimum_met'] = sprintf(
      /* translators: 1. version of php */
        __(
          'برای استفاده از افزونه وبکیما المنت باید <strong>نسخه PHP %s</strong> به بالا را نصب داشته باشید.',
          'webkima-elements'
        ),
        $minimum_php_version
      );
    }

    if (!Base::isElementorInstalled()) {
      self::$errors['elementor_install'] = __(
        'اگر می‌خواهید از تمامی امکانات افزونه وبکیما المنت استفاده کنید، می‌توانید افزونه المنتور رایگان را نیز نصب کنید، البته این بستگی به شما دارد و اگر تمایل دارید بدون المنتور از وبکیما المنت استفاده کنید هیچ مشکلی وجود ندارد، تنها به امکانات بخش المنتور دسترسی نخواهید داشت.',
        'webkima-elements'
      );
    }

    return self::$errors;
  }

  /**
   * Checks if elementor plugin is installed.
   *
   * @return bool true if elementor is installed.
   * @since      1.7.0
   */
  public static function isElementorInstalled(): bool {
    return is_plugin_active('elementor/elementor.php');
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

  public static function handleCacheNotice(): void {
    if (empty(get_user_meta(self::$user_id, 'webkima_elements_cache_notice', true)) && isset($_GET['cache-notice'])) {
      add_user_meta(self::$user_id, 'webkima_elements_cache_notice', 'true', true);
    }
  }

  public static function isCacheNotice(): bool {
    return !get_user_meta(self::$user_id, 'webkima_elements_cache_notice', true);
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
      <div class="cache-notice-wrapper <?= self::isCacheNotice() ? 'show' : ''; ?>">
          <div class="cache-notice">
              <p class="error-message">نکته بسیار مهم:</p>
              <p>هر بار که تنظیمات را تغییر می‌دهید برای اینکه بتوانید تغییرات را به صورت کامل در سایت خود مشاهده کنید
                  باید موارد زیر را انجام دهید:</p>
              <ol>
                  <li>ابتدا اگر افزونه کش دارید باید کش آن را پاک کنید <a href="https://webkima.com/clear-wp-cache/"
                                                                          target="_blank">آموزش</a></li>
                  <li>اگر از سایت‌های CDN مثل کلودفلر استفاده می‌کنید باید کش آن را پاک کنید</li>
                  <li>باید کش مرورگر خود را پاک کنید. <a href="https://webkima.com/mac-clear-cash/" target="_blank">آموزش</a>
                  </li>
              </ol>
              <p class="error-message">در نهایت اگر بعد پاک کردن کش در تمامی موارد بالا باز هم مشکل داشتید حتما سایت خود
                  را با تب ناشناس مرورگر تست کنید و ببینید آیا تنظیمات اعمال شده است یا خیر.</p>
              <div class="cache-notice-buttons">
                  <a class="cache-notice-button we-close">بستن</a>
                  <a class="cache-notice-button we-dont-show"
                     href="http://localhost/el-test/wp-admin/admin.php?page=webkima-elements&cache-notice=true">دیگر این
                      پیام را
                      نمایش نده</a>
              </div>
          </div>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', () => {
          document.querySelector('.csf-save').addEventListener('click', function (e) {
            document.querySelector('.cache-notice-wrapper').classList.add('active');
          });
          document.querySelector('.cache-notice-wrapper').addEventListener('click', function (e) {
            if (e.target.classList.contains('cache-notice-wrapper') || e.target.classList.contains('cache-notice-button')) {
              this.classList.remove('active');
            }
          });
        });
      </script>
    <?php
  }

}
