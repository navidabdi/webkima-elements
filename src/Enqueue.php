<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Enqueue
 */

namespace WebkimaElements;

class Enqueue {

    public static $chosen_font = 'iranyekan';

    public static function init() {
        // Main dynamic styles
        add_action('wp_enqueue_scripts', __CLASS__ . '::enqueueMainStyle');

        // Chose Font Option
        if (isset(get_option('webkima_elements')['we-select-font'])) {
            static::$chosen_font = get_option('webkima_elements')['we-select-font'];
        }

        // Add backend Font
        if (static::activated('we_font_backend')) {
            add_action('admin_enqueue_scripts', __CLASS__ . '::enqueueBackendFont');
        }

        // Add frontend Font
        if (static::activated('we_font_frontend')) {
            static::frontendFont(static::$chosen_font);
        }

        if (static::activated('we_font_elementor_editor')) {
            add_action('elementor/editor/before_enqueue_scripts', __CLASS__ . '::enqueueElementorEditor');
            add_action('elementor/app/init', __CLASS__ . '::enqueueElementorEditor');
            add_action('elementor/preview/enqueue_styles', __CLASS__ . '::enqueueElementorEditor');
        }

        add_action('elementor/editor/before_enqueue_scripts', __CLASS__ . '::enqueueWebkimaElementsTemplates');
    }

    public static function activated(string $key): bool {
        $option = get_option('webkima_elements');
        return $option[$key] ?? false;
    }

    public static function enqueueMainStyle() {
        wp_enqueue_style('webkima-main', WEBKIMA_ELEMENTS_URL . 'assets/css/main.php');
    }

    public static function enqueueBackendFont() {
        wp_enqueue_style(
            'webkima-elements-chosen-font', WEBKIMA_ELEMENTS_URL . 'assets/css/' . static::backendFont(static::$chosen_font)
        );
    }

    public static function enqueueElementorEditor() {
        wp_enqueue_style(
            'webkima-elements-elementor-editor', WEBKIMA_ELEMENTS_URL . 'assets/css/elementor-editor.css'
        );
    }

    // Enqueue Template Editor
    public static function enqueueWebkimaElementsTemplates() {
        wp_enqueue_script(
            'webkima-elements-template-js', WEBKIMA_ELEMENTS_URL . 'assets/js/editor.js'
        );
    }

    // Chose Font
    public static function backendFont($option): string {
        $font_css_file = '';
        switch ($option) {
            case 'iranyekan':
                $font_css_file = 'iranyekan-font.css';
                break;
            case "vazir":
                $font_css_file = 'vazir-font.css';
                break;
            default:
                $font_css_file = 'iranyekan-font.css';
        }
        return $font_css_file;
    }

    public static function frontendFont($option) {
        switch ($option) {
            case 'iranyekan':
                DynamicAssets::$styles['font'] =
                    '@font-face{font-family:iranyekan;font-style:light;font-weight:300;src:url("../fonts/IranYekan/iranyekanweblightfanum.woff") format("woff")}@font-face{font-family:iranyekan;font-style:normal;font-weight:400;src:url("../fonts/IranYekan/iranyekanwebregularfanum.woff") format("woff")}@font-face{font-family:iranyekan;font-style:bold;font-weight:700;src:url("../fonts/IranYekan/iranyekanwebboldfanum.woff") format("woff")}.ab-item,.components-menu-group__label,.components-notice__content,.elementor-edit-link-title,.elementor-icon-list-text,.elementor-testimonial__name,.elementor-testimonial__text,.elementor-testimonial__title,a,body,button,h1,h2,h3,h4,h5,h6,input,label,option,p,select,span.ab-label,span.display-name,textarea{font-family:iranyekan,sans-serif!important}';
                break;
            case 'vazir':
                DynamicAssets::$styles['font'] =
                    '@font-face{font-family:vazir;font-style:light;font-weight:300;src:url("../fonts/Vazir/Vazir-Light-FD.woff2") format("woff")}@font-face{font-family:vazir;font-style:normal;font-weight:400;src:url("../fonts/Vazir/Vazir-Regular-FD.woff2") format("woff")}@font-face{font-family:vazir;font-style:bold;font-weight:700;src:url("../fonts/Vazir/Vazir-Bold-FD.woff2") format("woff")}.ab-item,.components-menu-group__label,.components-notice__content,.elementor-edit-link-title,.elementor-icon-list-text,.elementor-testimonial__name,.elementor-testimonial__text,.elementor-testimonial__title,a,body,button,h1,h2,h3,h4,h5,h6,input,label,option,p,select,span.ab-label,span.display-name,textarea{font-family:vazir,sans-serif!important}';
                break;
            default:
                DynamicAssets::$styles['font'] =
                    '@font-face{font-family:iranyekan;font-style:light;font-weight:300;src:url("../fonts/IranYekan/iranyekanweblightfanum.woff") format("woff")}@font-face{font-family:iranyekan;font-style:normal;font-weight:400;src:url("../fonts/IranYekan/iranyekanwebregularfanum.woff") format("woff")}@font-face{font-family:iranyekan;font-style:bold;font-weight:700;src:url("../fonts/IranYekan/iranyekanwebboldfanum.woff") format("woff")}.ab-item,.components-menu-group__label,.components-notice__content,.elementor-edit-link-title,.elementor-icon-list-text,.elementor-testimonial__name,.elementor-testimonial__text,.elementor-testimonial__title,a,body,button,h1,h2,h3,h4,h5,h6,input,label,option,p,select,span.ab-label,span.display-name,textarea{font-family:iranyekan,sans-serif!important}';
        }
        return DynamicAssets::$styles['font'];
    }
}
