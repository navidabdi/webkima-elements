<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Base;
use WebkimaElements\Base\BaseController;
use WebkimaElements\Elementor\Webkima_EL_Mobile_Menu;

class RegisterElementorWidgets extends BaseController
{
  protected $widgets_path;

  public function register()
  {
    $this->widgets_path = WEBKIMA_ELEMENTS_PATH . "inc/Elementor/Widgets/";

    add_action("elementor/widgets/register", [
      $this,
      "register_elementor_widgets",
    ]);

    add_action("elementor/elements/categories_registered", [
      $this,
      "add_elementor_widget_category",
    ]);
    $this->dynamic_styles();
  }

  public function register_elementor_widgets($widgets_manager)
  {
    require_once $this->widgets_path . "mobile-menu/WebkimaELMobileMenu.php";
    $widgets_manager->register(new \Webkima_EL_Mobile_Menu());
  }

  public function add_elementor_widget_category($elements_manager)
  {
    $elements_manager->add_category("webkima-elements", [
      "title" => esc_html__("Webkima Elements", "webkima-elements"),
      "icon" => "fa fa-plug",
    ]);
  }

  public function dynamic_styles()
  {
    require_once $this->widgets_path . "mobile-menu/style.php";
  }
}
