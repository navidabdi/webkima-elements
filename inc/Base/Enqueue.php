<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Base;
use WebkimaElements\Base\BaseController;

class Enqueue extends BaseController
{
  public $chosen_font = "iranyekan";
  public function register()
  {
    // Chose Font Option
    if (isset(get_option("webkima_elements")["we-select-font"])) {
      $this->chosen_font = get_option("webkima_elements")["we-select-font"];
    }

    if ($this->activated("we_font_backend")) {
      add_action("admin_enqueue_scripts", [$this, "enqueueChosenFont"]);
    }

    if ($this->activated("we_font_frontend")) {
      add_action("wp_enqueue_scripts", [$this, "enqueueChosenFont"]);
    }

    if ($this->activated("we_font_elementor_editor")) {
      add_action("elementor/editor/before_enqueue_scripts", [
        $this,
        "enqueueElementorEditor",
      ]);
      add_action("elementor/app/init", [$this, "enqueueElementorEditor"]);
      add_action("elementor/preview/enqueue_styles", [
        $this,
        "enqueueElementorEditor",
      ]);
    }

    add_action("elementor/editor/before_enqueue_scripts", [
      $this,
      "enqueueWebkimaElementsTemplates",
    ]);
  }

  public function enqueueChosenFont()
  {
    wp_enqueue_style(
      "webkima-elements-chosen-font",
      $this->plugin_url . "assets/css/" . $this->choseFont($this->chosen_font)
    );
  }

  public function enqueueElementorEditor()
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
  public function choseFont($option)
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
}
