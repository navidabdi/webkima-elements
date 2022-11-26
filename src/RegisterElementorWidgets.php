<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class RegisterElementorWidgets
 */

namespace WebkimaElements;

class RegisterElementorWidgets {

    protected static string $widgets_path;

    public static function init(): void {
        static::$widgets_path = WEBKIMA_ELEMENTS_PATH . 'src/Elementor/Widgets/';
        add_action('elementor/widgets/register', __CLASS__ . '::registerElementorWidgets');
        add_action('elementor/elements/categories_registered', __CLASS__ . '::addElementorWidgetCategory');
        static::dynamicStyles();
    }

    public static function registerElementorWidgets($widgets_manager): void {
        require_once static::$widgets_path . 'mobile-menu/WebkimaELMobileMenu.php';
        $widgets_manager->register(new \Webkima_EL_Mobile_Menu());
    }

    public static function addElementorWidgetCategory($elements_manager): void {
        $elements_manager->add_category('webkima-elements', [
            'title' => esc_html__('Webkima Elements', 'webkima-elements'),
            'icon' => 'fa fa-plug',
        ]);
    }

    public static function dynamicStyles(): void {
        require_once static::$widgets_path . 'mobile-menu/style.php';
    }
}
