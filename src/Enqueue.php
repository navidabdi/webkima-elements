<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Enqueue
 */

namespace WebkimaElements;

use WebkimaElements\Base;

class Enqueue {

	public static string $chosen_font = 'iranyekan';

	public static function init(): void {
		// Main dynamic styles
		add_action('wp_enqueue_scripts', __CLASS__ . '::enqueueMainStyle');
		// Main dynamic javascript
		if (!is_admin()) {
			add_action('wp_enqueue_scripts', __CLASS__ . '::enqueueMainJs');
		}


		// Chose Font Option
		if (isset(get_option('webkima_elements')['we-select-font'])) {
			static::$chosen_font = get_option('webkima_elements')['we-select-font'];
		}

		// Add backend Font
		if (Base::isOptionActivated('we_font_backend')) {
			add_action('admin_enqueue_scripts', __CLASS__ . '::enqueueBackendFont');
		}

		if (Base::isOptionActivated('we_font_elementor_editor')) {
			add_action('elementor/editor/before_enqueue_scripts', __CLASS__ . '::enqueueElementorEditor');
			add_action('elementor/app/init', __CLASS__ . '::enqueueElementorEditor');
			add_action('elementor/preview/enqueue_styles', __CLASS__ . '::enqueueElementorEditor');
		}
//		add_action('elementor/editor/before_enqueue_scripts', __CLASS__ . '::enqueueElementorMainJs', 10);
		add_action('elementor/editor/before_enqueue_scripts', __CLASS__ . '::enqueueWebkimaElementsTemplates', 11);
	}

	public static function enqueueMainStyle(): void {
		wp_enqueue_style('webkima-main', WEBKIMA_ELEMENTS_URL . 'assets/css/main.css');
	}

	public static function enqueueMainJs(): void {
		wp_enqueue_script(
			'webkima-main-js',
			WEBKIMA_ELEMENTS_URL . 'assets/js/main.bundle.js',
			[] ,
			WEBKIMA_ELEMENTS_VER,
			TRUE
		);
	}

	public static function enqueueElementorMainJs(): void {
		wp_enqueue_script(
			'webkima-main-el-js',
			WEBKIMA_ELEMENTS_URL . 'assets/js/main.bundle.js',
			[],
			WEBKIMA_ELEMENTS_VER,
			TRUE
		);
	}


	public static function enqueueBackendFont(): void {
		wp_enqueue_style(
			'webkima-elements-chosen-font', WEBKIMA_ELEMENTS_URL . 'assets/css/' . static::backendFont(static::$chosen_font)
		);
	}

	public static function enqueueElementorEditor(): void {
		wp_enqueue_style(
			'webkima-elements-elementor-editor', WEBKIMA_ELEMENTS_URL . 'assets/css/elementor-editor.css'
		);
	}

	// Enqueue Template Editor
	public static function enqueueWebkimaElementsTemplates(): void {
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

}
