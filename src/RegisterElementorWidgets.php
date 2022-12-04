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

		if ( Base::isOptionActivated( 'we_el_widgets' ) ) {
			add_action( 'elementor/widgets/register', __CLASS__ . '::registerElementorWidgets' );
			add_action( 'elementor/elements/categories_registered', __CLASS__ . '::addElementorWidgetCategory' );
			static::dynamicStyles();
		}

	}

	public static function registerElementorWidgets( $widgets_manager ): void {
		if ( Base::isOptionActivated( 'we_el_widget_mobile_menu' ) ) {
			require_once static::$widgets_path . 'WebkimaELMobileMenu.php';
			$widgets_manager->register( new \Webkima_EL_Mobile_Menu() );
		}
	}

	public static function addElementorWidgetCategory( $elements_manager ): void {
		$elements_manager->add_category( 'webkima-elements', [
			'title' => esc_html__( 'Webkima Elements', 'webkima-elements' ),
			'icon'  => 'fa fa-plug',
		] );
	}

	public static function dynamicStyles(): void {
		if ( Base::isOptionActivated( 'we_el_widget_mobile_menu' ) ) {
//			DynamicAssets::$styles[] = WEBKIMA_ELEMENTS_WIDGET_CSS_PATH . 'mobile-menu.css';
		}
		if ( Base::isOptionActivated( 'we_el_widget_another_one' ) ) {
//			DynamicAssets::$styles[] = WEBKIMA_ELEMENTS_WIDGET_CSS_PATH . 'another-widget.css';
		}
	}

}
