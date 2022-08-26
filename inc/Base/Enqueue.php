<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Base;
use WebkimaElements\Base\BaseController;
use WebkimaElements\Base\DynamicAssets;

class Enqueue extends BaseController
{
  public $chosen_font = "iranyekan";
  public function register()
  {
    // Main dynamic styles
    add_action("wp_enqueue_scripts", [$this, "enqueue_main_style"]);

    // Chose Font Option
    if (isset(get_option("webkima_elements")["we-select-font"])) {
      $this->chosen_font = get_option("webkima_elements")["we-select-font"];
    }

    // Add backend Font
    if ($this->activated("we_font_backend")) {
      add_action("admin_enqueue_scripts", [$this, "enqueue_backend_font"]);
    }

    // Add frontend Font
    if ($this->activated("we_font_frontend")) {
      $this->forntend_font($this->chosen_font);
    }

    if ($this->activated("we_font_elementor_editor")) {
      add_action("elementor/editor/before_enqueue_scripts", [
        $this,
        "enqueue_elementor_editor",
      ]);
      add_action("elementor/app/init", [$this, "enqueue_elementor_editor"]);
      add_action("elementor/preview/enqueue_styles", [
        $this,
        "enqueue_elementor_editor",
      ]);
    }

    add_action("elementor/editor/before_enqueue_scripts", [
      $this,
      "enqueueWebkimaElementsTemplates",
    ]);
  }

  public function enqueue_main_style()
  {
    wp_enqueue_style("webkima-main", $this->plugin_url . "assets/css/main.php");
  }

  public function enqueue_backend_font()
  {
    wp_enqueue_style(
      "webkima-elements-chosen-font",
      $this->plugin_url .
        "assets/css/" .
        $this->backend_font($this->chosen_font)
    );
  }

  public function enqueue_elementor_editor()
  {
    wp_enqueue_style(
      "webkima-elements-elementor-editor",
      $this->plugin_url . "assets/css/elementor-editor.css"
    );
  }

  // Enqueue Template Editor
  public function enqueueWebkimaElementsTemplates()
  {
    wp_enqueue_script(
      "webkima-elements-template-js",
      $this->plugin_url . "assets/js/editor.js"
    );
  }
  // Chose Font
  public function backend_font($option)
  {
    $font_css_file = null;
    switch ($option) {
      case "iranyekan":
        $font_css_file = "iranyekan-font.css";
        break;
      case "vazir":
        $font_css_file = "vazir-font.css";
        break;
      default:
        $font_css_file = "iranyekan-font.css";
    }
    return $font_css_file;
  }

  public function forntend_font($option)
  {
    switch ($option) {
      case "iranyekan":
        DynamicAssets::$styles["font"] =
          '@font-face{font-family:iranyekan;font-style:light;font-weight:300;src:url("../fonts/IranYekan/iranyekanweblightfanum.woff") format("woff")}@font-face{font-family:iranyekan;font-style:normal;font-weight:400;src:url("../fonts/IranYekan/iranyekanwebregularfanum.woff") format("woff")}@font-face{font-family:iranyekan;font-style:bold;font-weight:700;src:url("../fonts/IranYekan/iranyekanwebboldfanum.woff") format("woff")}.ab-item,.components-menu-group__label,.components-notice__content,.elementor-edit-link-title,.elementor-icon-list-text,.elementor-testimonial__name,.elementor-testimonial__text,.elementor-testimonial__title,a,body,button,h1,h2,h3,h4,h5,h6,input,label,option,p,select,span.ab-label,span.display-name,textarea{font-family:iranyekan,sans-serif!important}';
        break;
      case "vazir":
        DynamicAssets::$styles["font"] =
          '@font-face{font-family:vazir;font-style:light;font-weight:300;src:url("../fonts/Vazir/Vazir-Light-FD.woff2") format("woff")}@font-face{font-family:vazir;font-style:normal;font-weight:400;src:url("../fonts/Vazir/Vazir-Regular-FD.woff2") format("woff")}@font-face{font-family:vazir;font-style:bold;font-weight:700;src:url("../fonts/Vazir/Vazir-Bold-FD.woff2") format("woff")}.ab-item,.components-menu-group__label,.components-notice__content,.elementor-edit-link-title,.elementor-icon-list-text,.elementor-testimonial__name,.elementor-testimonial__text,.elementor-testimonial__title,a,body,button,h1,h2,h3,h4,h5,h6,input,label,option,p,select,span.ab-label,span.display-name,textarea{font-family:vazir,sans-serif!important}';
        break;
      default:
        DynamicAssets::$styles["font"] =
          '@font-face{font-family:iranyekan;font-style:light;font-weight:300;src:url("../fonts/IranYekan/iranyekanweblightfanum.woff") format("woff")}@font-face{font-family:iranyekan;font-style:normal;font-weight:400;src:url("../fonts/IranYekan/iranyekanwebregularfanum.woff") format("woff")}@font-face{font-family:iranyekan;font-style:bold;font-weight:700;src:url("../fonts/IranYekan/iranyekanwebboldfanum.woff") format("woff")}.ab-item,.components-menu-group__label,.components-notice__content,.elementor-edit-link-title,.elementor-icon-list-text,.elementor-testimonial__name,.elementor-testimonial__text,.elementor-testimonial__title,a,body,button,h1,h2,h3,h4,h5,h6,input,label,option,p,select,span.ab-label,span.display-name,textarea{font-family:iranyekan,sans-serif!important}';
    }
    return DynamicAssets::$styles["font"];
  }
}
