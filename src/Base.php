<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Base
 */

namespace WebkimaElements;

class Base {

    public static function register() {
        require_once WEBKIMA_ELEMENTS_PATH . 'lib/options.php';
        add_action('admin_menu', __CLASS__ . '::webkimaElementsPanel');
    }

    /**
     * Registers activation hook callback.
     *
     * @since  1.0.0
     * @return void
     */
    public static function activate() {

    }

    /**
     * Registers deactivation hook callback.
     *
     * @since  1.0.0
     * @return void
     */
    public static function deactivate() {
    }

    /**
     * Registers uninstall hook callback.
     *
     * @since  1.0.0
     * @return void
     */
    public static function uninstall() {
    }

    public static function webkimaElementsPanel() {
        add_menu_page(
            __("Webkima Elements", "webkima-elements"),
            __("Webkima Elements", "webkima-elements"),
            "manage_options",
            "webkima-elements",
            __CLASS__ . '::webkimaElementsPanelCallback',
            WEBKIMA_ELEMENTS_URL . '/assets/icons/webkima-logo.svg',
            58
        );
    }

    public static function webkimaElementsPanelCallback() {
        ?>
        <div class="wrap about-wrap" style="font-family:iranyekan">
        <h1><?php echo __("Welcome to Webkima Elements :)", "webkima-elements"); ?></h1>
        <div class="about-text"><?php echo __(
                "More feature with better performance",
                "webkima-elements"
            ); ?></div>
        <a class="webkima-logo" href="https://webkima.com/" target="_blank"	style="background-image:url(<?php echo plugins_url(
            "webkima-elements/assets/icons/logo.png"
        ); ?>) !important;background-position: center center;"></a>

        <h2 class="nav-tab-wrapper">
            <a class="nav-tab nav-tab-active" href="#"><?php echo __("Settings", "webkima-elements"); ?></a>
        </h2>
        <?php
    }

}