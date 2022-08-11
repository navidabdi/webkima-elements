<?php

/**
 * @package  WebkimaElements
 */

namespace WebkimaElements\Elementor;
use WebkimaElements\Base\BaseController;
use Elementor;
// use WebkimaElements\Elementor\TemplatesSource;

class TemplatesManager extends BaseController
{
  /**
   * A reference to an instance of this class.
   *
   */
  private static $instance = null;

  /**
   * Template option name
   */
  protected $option = "webkima_elements_categories";

  /**
   * Constructor for the class
   */
  public function register()
  {
    /**
     * Returns instance of TemplatesManager
     *
     * @return object
     */

    return TemplatesManager::get_instance()->init();
  }

  public function init()
  {
    // Register webkima-elements-templates source
    add_action("elementor/init", [$this, "registerTemplatesSource"]);

    if (defined("Elementor\Api::LIBRARY_OPTION_KEY")) {
      // Add Webkima Elements Templates to Elementor templates list
      add_filter("option_" . Elementor\Api::LIBRARY_OPTION_KEY, [
        $this,
        "prependCategories",
      ]);
    }

    // Process template request
    if (
      defined("ELEMENTOR_VERSION") &&
      version_compare(ELEMENTOR_VERSION, "2.2.8", ">")
    ) {
      add_action(
        "elementor/ajax/register_actions",
        [$this, "registerAjaxActions"],
        20
      );
    } else {
      add_action(
        "wp_ajax_elementor_get_template_data",
        [$this, "forceWebkimaElementsTemplatesSource"],
        0
      );
    }
  }

  /**
   * Register
   */
  public function registerTemplatesSource()
  {
    require plugin_dir_path(__FILE__) . "TemplatesSource.php";

    $elementor = Elementor\Plugin::instance();
    $elementor->templates_manager->register_source("TemplatesSource");
  }

  /**
   * Return transient key
   */
  public function transientKey()
  {
    return $this->option . "_" . WEBKIMA_ELEMENTS_VER;
  }

  /**
   * Retrieves categories list
   */
  public function getCategories()
  {
    $categories = get_transient($this->transientKey());

    if (!$categories) {
      $categories = $this->remoteGetCategories();
      set_transient($this->transientKey(), $categories, WEEK_IN_SECONDS);
    }

    return $categories;
  }

  /**
   * Get categories
   */
  public function remoteGetCategories()
  {
    $url = WEBKIMA_ELEMENTS_URL . "json/categories.json";
    $response = wp_remote_get($url, ["timeout" => 60]);
    $body = wp_remote_retrieve_body($response);
    $body = json_decode($body, true);

    return !empty($body["data"]) ? $body["data"] : [];
  }

  /**
   * Add templates to Elementor templates list
   */
  public function prependCategories($library_data)
  {
    $categories = ["page", "login", "register", "loop", "comment"];

    if (!empty($categories)) {
      if (
        defined("ELEMENTOR_VERSION") &&
        version_compare(ELEMENTOR_VERSION, "2.3.9", ">")
      ) {
        $library_data["types_data"]["block"]["categories"] = array_merge(
          $categories,
          $library_data["types_data"]["block"]["categories"]
        );
      } else {
        $library_data["categories"] = array_merge(
          $categories,
          $library_data["categories"]
        );
      }

      return $library_data;
    } else {
      return $library_data;
    }
  }

  /**
   * Register AJAX actions
   */
  public function registerAjaxActions($ajax)
  {
    if (!isset($_REQUEST["actions"])) {
      return;
    }

    $actions = json_decode(stripslashes($_REQUEST["actions"]), true);
    $data = false;

    foreach ($actions as $id => $action_data) {
      if (!isset($action_data["get_template_data"])) {
        $data = $action_data;
      }
    }

    if (!$data) {
      return;
    }

    if (!isset($data["data"])) {
      return;
    }

    $data = $data["data"];

    if (empty($data["template_id"])) {
      return;
    }

    if (false === strpos($data["template_id"], "we_")) {
      return;
    }

    $ajax->register_ajax_action("get_template_data", [
      $this,
      "getWebkimaElementsTemplateData",
    ]);
  }

  /**
   * Get template data.
   */
  public function getWebkimaElementsTemplateData($args)
  {
    $source = Elementor\Plugin::instance()->templates_manager->get_source(
      "WebkimaAcademy"
    );

    $data = $source->get_data($args);

    return $data;
  }

  /**
   * Return template data insted of elementor template.
   */
  public function forceWebkimaElementsTemplatesSource()
  {
    if (empty($_REQUEST["template_id"])) {
      return;
    }

    if (false === strpos($_REQUEST["template_id"], "we_")) {
      return;
    }

    $_REQUEST["source"] = "WebkimaAcademy";
  }

  /**
   * Returns the instance.
   */
  public static function get_instance()
  {
    // If the single instance hasn't been set, set it now.
    if (null == self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }
}
