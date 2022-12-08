<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Enqueue
 */

namespace WebkimaElements;

use WebkimaElements\CssMinifier;
use WebkimaElements\Base;

class DynamicAssets {

	public static array $styles = [];

	public static array $java_scripts = [];

	public static function init(): void {
		add_action('csf_webkima_elements_save_after', __CLASS__ . '::generateStylesAdnJavaScripts');
//		self::generateStylesAdnJavaScripts();
	}

	public static function generateStylesAdnJavaScripts(): void {
		self::generateStyleBaseOption();
		self::generateJsBaseOption();
	}

	public static function generateStyleBaseOption(): void {
		$options_to_add_css_files = [];

		if (Base::isOptionActivated('we_font_frontend')) {
			$options_to_add_css_files['we-select-font'] = self::getFontStylePath();
		}

		if (Base::isOptionActivated('we_el_widgets')) {
			$options_to_add_css_files += [
				'we_el_widget_mobile_menu' => WEBKIMA_ELEMENTS_WIDGET_CSS_PATH . 'mobile-menu.min.css',
				'we_el_widget_post_carousel' => WEBKIMA_ELEMENTS_WIDGET_CSS_PATH . 'post-carousel.min.css',
			];
		}

		$options_to_add_css_files += [
			'we_goup_btn' => WEBKIMA_ELEMENTS_PATH . 'assets/src/css/gotoup.scss',
		];

		foreach ($options_to_add_css_files as $key => $css_file_path) {
			if (Base::isOptionActivated($key)) {
				if (self::isFileExistReadable($css_file_path)) {
					self::$styles[] = $css_file_path;
				}
			}
		}

		self::printStyles();
	}

	public static function generateJsBaseOption(): void {
		$options_to_add_js_files = [];

		if (Base::isOptionActivated('we_el_widgets')) {
			$options_to_add_js_files += [
				'we_el_widget_mobile_menu' => WEBKIMA_ELEMENTS_WIDGET_JS_PATH . 'mobile-menu.min.js',
				'we_el_widget_post_carousel' => WEBKIMA_ELEMENTS_WIDGET_JS_PATH . 'post-carousel.min.js',
			];
		}

		$options_to_add_js_files += [
			'we_goup_btn' => WEBKIMA_ELEMENTS_WIDGET_JS_PATH . 'gotoup.min.js',
		];

		foreach ($options_to_add_js_files as $key => $js_file_path) {
			if (Base::isOptionActivated($key)) {
				if (self::isFileExistReadable($js_file_path)) {
					self::$java_scripts[] = $js_file_path;
				}
			}
		}

		self::printJavaScripts();
	}

	public static function printStyles(): void {
		$main_css_file = fopen( WEBKIMA_ELEMENTS_PATH . 'assets/css/main.css', "w" )
		or die( "Unable to open main.css file!" );
		foreach (self::$styles as $style) {
			fwrite( $main_css_file, file_get_contents($style) );
		}
		fclose( $main_css_file );
	}

	public static function printJavaScripts(): void {
		$main_js_file = fopen( WEBKIMA_ELEMENTS_PATH . 'assets/js/main.bundle.js', "w" )
		or die( "Unable to open main.css file!" );
		foreach (self::$java_scripts as $java_script) {
			fwrite( $main_js_file, file_get_contents($java_script) );
		}
		fclose( $main_js_file );
	}

	public static function generateStyle($css_file_name, $style): void {
		$css_file = fopen( WEBKIMA_ELEMENTS_PATH . 'assets/src/css/' . $css_file_name, "w" )
		or die( "Unable to open file!" );

		fwrite( $css_file, $style );
		fclose( $css_file );
	}

	public static function getFontStylePath(): string {
		$font_style_path = WEBKIMA_ELEMENTS_PATH . 'assets/css/iranyekan-font.css';
		if ( get_option('webkima_elements')['we-select-font'] == 'vazir' ) {
			$font_style_path = WEBKIMA_ELEMENTS_PATH . 'assets/css/vazir-font.css';
		}
		return $font_style_path;
	}

	public static function isFileExistReadable($file_path): bool {
		return file_exists($file_path) && is_readable($file_path);
	}
}
