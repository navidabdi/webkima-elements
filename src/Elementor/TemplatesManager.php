<?php

/**
 * @package  WebkimaElements
 */
if (!defined("ABSPATH")) {
  die("You Can Not Access This File Directly!"); // Die if accessed directlyf
}
class TemplatesManager
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
  public function init()
  {
    // Register webkima-elements-templates source
    add_action("elementor/init", [$this, "register_templates_source"]);

    if (defined("Elementor\Api::LIBRARY_OPTION_KEY")) {
      // Add Webkima Elements Templates to Elementor templates list
      add_filter("option_" . Elementor\Api::LIBRARY_OPTION_KEY, [
        $this,
        "prepend_categories",
      ]);
    }

    // Process template request
    if (
      defined("ELEMENTOR_VERSION") &&
      version_compare(ELEMENTOR_VERSION, "2.2.8", ">")
    ) {
      add_action(
        "elementor/ajax/register_actions",
        [$this, "register_ajax_actions"],
        20
      );
    } else {
      add_action(
        "wp_ajax_elementor_get_template_data",
        [$this, "force_webkima_elements_template_source"],
        0
      );
    }
  }

  /**
   * Register
   */
  public function register_templates_source()
  {
    require plugin_dir_path(__FILE__) . "TemplatesSource.php";

    $elementor = Elementor\Plugin::instance();
    $elementor->templates_manager->register_source("TemplatesSource");
  }

  /**
   * Return transient key
   */
  public function transient_key()
  {
    return $this->option . "_" . WEBKIMA_ELEMENTS_VER;
  }

  /**
   * Retrieves categories list
   */
  public function get_categories()
  {
    $categories = get_transient($this->transient_key());

    if (!$categories) {
      $categories = $this->remote_get_categories();
      set_transient($this->transient_key(), $categories, WEEK_IN_SECONDS);
    }

    return $categories;
  }

  /**
   * Get categories
   */
  public function remote_get_categories()
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
  public function prepend_categories($library_data)
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
  public function register_ajax_actions($ajax)
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
      "get_webkima_elements_template_data",
    ]);
  }

  /**
   * Get template data.
   */
  public function get_webkima_elements_template_data($args)
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
  public function force_webkima_elements_template_source()
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

/**
 * Returns instance of TemplatesManager
 *
 * @return object
 */
function manager_init()
{
  return TemplatesManager::get_instance();
}
manager_init()->init();
