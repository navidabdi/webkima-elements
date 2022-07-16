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
    if ($this->activated('font_backend')) {
      add_action('admin_enqueue_scripts', [$this, 'enqueueIranYekanFont']);
    }
    if ($this->activated('font_frontend')) {
      add_action('wp_enqueue_scripts', [$this, 'enqueueIranYekanFont']);
    }
    add_action('admin_enqueue_scripts', [$this, 'enqueueAdminCssAndJs']);
  }

  public function enqueueAdminCssAndJs()
  {
    wp_enqueue_style(
      'webkima-elements-admin-css',
      $this->plugin_url . 'assets/css/admin-css.css'
    );
    wp_enqueue_script(
      'webkima-elements-admin-js',
      $this->plugin_url . 'assets/js/admin-js.js'
    );
  }

  public function enqueueIranYekanFont()
  {
    wp_enqueue_style(
      'webkima-elements-iranyekan-font',
      $this->plugin_url . 'assets/css/iranyekan-font.css'
    );
  }

  public function enqueueVazirFont()
  {
    wp_enqueue_style(
      'webkima-elements-vazir-font',
      $this->plugin_url . 'assets/css/vazir-font.css'
    );
  }
}
