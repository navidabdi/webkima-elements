<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Base;
use WebkimaElements\Base\BaseController;

class Enqueue extends BaseController
{
  public function register()
  {
    if ($this->activated("we_font_backend")) {
      add_action("admin_enqueue_scripts", [$this, "enqueueIranYekanFont"]);
    }

    if ($this->activated("we_font_frontend")) {
      add_action("wp_enqueue_scripts", [$this, "enqueueIranYekanFont"]);
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

  public function enqueueIranYekanFont()
  {
    wp_enqueue_style(
      "webkima-elements-iranyekan-font",
      $this->plugin_url . "assets/css/iranyekan-font.css"
    );
  }

  public function enqueueVazirFont()
  {
    wp_enqueue_style(
      "webkima-elements-vazir-font",
      $this->plugin_url . "assets/css/vazir-font.css"
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
}
