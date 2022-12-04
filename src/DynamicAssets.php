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

	public static function init(): void {
		add_action('csf_webkima_elements_save_after', __CLASS__ . '::generateStyleBaseOption');
	}

	public static function generateStyleBaseOption(): void {
		$options_to_add_css_files = [];

		if (Base::isOptionActivated('we_font_frontend')) {
			$options_to_add_css_files['we-select-font'] = self::getFontStylePath();
		}

		if (Base::isOptionActivated('we_el_widgets')) {
			$options_to_add_css_files += [
				'we_el_widget_mobile_menu' => WEBKIMA_ELEMENTS_WIDGET_CSS_PATH . 'mobile-menu.css',
				'we_el_widget_another_one' => WEBKIMA_ELEMENTS_WIDGET_CSS_PATH . 'another-widget.css',
			];
		}

		$options_to_add_css_files += [
			'we_goup_btn' => WEBKIMA_ELEMENTS_PATH . 'assets/widgets/css/gotoup.css',
		];

		foreach ($options_to_add_css_files as $key => $css_file_path) {
			if (Base::isOptionActivated($key)) {
				DynamicAssets::$styles[] = $css_file_path;
			}
		}

		DynamicAssets::printStyles();
	}

	public static function printStyles(): void {
		$cssMinifier = new CssMinifier( static::$styles );
		$minifiedCSS = $cssMinifier->minify();

		$main_css_file = fopen( WEBKIMA_ELEMENTS_PATH . 'assets/css/main.css', "w" )
		or die( "Unable to open main.css file!" );

		fwrite( $main_css_file, $minifiedCSS );
		fclose( $main_css_file );
	}

	public static function generateStyle($css_file_name, $style): void {
		$css_file = fopen( WEBKIMA_ELEMENTS_PATH . 'assets/widgets/css/' . $css_file_name, "w" )
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
}
