<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class RegisterElementorWidgets
 */

namespace WebkimaElements;

use WebkimaElements\DynamicAssets;

class RegisterElementorWidgets {

	protected static string $widgets_path = WEBKIMA_ELEMENTS_PATH . 'src/Elementor/Widgets/';

	public static function init(): void {

		if (Base::isOptionActivated('we_el_widgets')) {
			add_action('elementor/widgets/register', __CLASS__ . '::registerElementorWidgets');
			add_action('elementor/elements/categories_registered', __CLASS__ . '::addElementorWidgetCategory');
		}

	}

	public static function getWidgetIDs(): array {
		return [
			'we_el_widget_mobile_menu' => 'WebkimaELMobileMenu',
			'we_el_widget_post_carousel' => 'WebkimaELPostCarousel',
			'we_el_widget_metro_list' => 'WebkimaELMetroList'
		];
	}

	public static function registerElementorWidgets($widgets_manager): void {
		foreach (self::getWidgetIDs() as $key => $widget_class_name) {
			if (Base::isOptionActivated($key)) {
				require_once self::$widgets_path . $widget_class_name .'.php';
				$widgets_manager->register(new $widget_class_name);
			}
		}

	}

	public static function addElementorWidgetCategory($elements_manager): void {
		$elements_manager->add_category('webkima-elements', [
			'title' => esc_html__('Webkima Elements', 'webkima-elements'),
			'icon'  => 'fa fa-plug',
		]);
	}

}
