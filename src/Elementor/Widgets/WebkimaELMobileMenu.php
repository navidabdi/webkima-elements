<?php

if (!defined("ABSPATH")) {
  exit(); // Exit if accessed directly
}

class WebkimaELMobileMenu extends \Elementor\Widget_Base
{
  protected int $nav_menu_index = 1;

  public function get_name(): string {
    return "Webkima_Elements_Mobile_Menu";
  }

  public function get_title(): string {
    return esc_html__("Mobile Menu", "webkima-elements");
  }

  public function get_icon(): string {
    return "eicon-menu-bar";
  }

  public function get_categories(): array {
    return ["webkima-elements"];
  }

  public function get_keywords(): array {
    return ["Mobile", "Menu"];
  }

  private function get_available_menus(): array {
    $menus = wp_get_nav_menus();
    $options = [];
    foreach ($menus as $menu) {
      $options[$menu->slug] = $menu->name;
    }
    return $options;
  }

  protected function get_nav_menu_index(): int {
    return $this->nav_menu_index++;
  }

  protected function register_controls() {
    // Content Tab Start
    $this->start_controls_section("section_layout", [
      "label" => esc_html__("Layout", "elementor"),
    ]);

    $menus = $this->get_available_menus();

    if (!empty($menus)) {
      $this->add_control("menu", [
        "label" => esc_html__("Menu", "elementor"),
        "type" => \Elementor\Controls_Manager::SELECT,
        "options" => $menus,
        "default" => array_keys($menus)[0],
        "save_default" => true,
        "separator" => "after",
        "description" => sprintf(
          esc_html__(
            'Go to the %1$sMenus screen%2$s to manage your menus.',
            "webkima-elements"
          ),
          sprintf('<a href="%s" target="_blank">', admin_url("nav-menus.php")),
          "</a>"
        ),
      ]);
    } else {
      $this->add_control("menu", [
        "type" => \Elementor\Controls_Manager::RAW_HTML,
        "raw" =>
          "<strong>" .
          esc_html__("There are no menus in your site.", "webkima-elements") .
          "</strong><br>" .
          sprintf(
            /* translators: 1: Link open tag, 2: Link closing tag. */
            esc_html__(
              'Go to the %1$sMenus screen%2$s to create one.',
              "webkima-elements"
            ),
            sprintf(
              '<a href="%s" target="_blank">',
              admin_url("nav-menus.php?action=edit&menu=0")
            ),
            "</a>"
          ),
        "separator" => "after",
        "content_classes" => "elementor-panel-alert elementor-panel-alert-info",
      ]);
    }

    $this->add_control("icon", [
      "label" => esc_html__("Icon", "elementor"),
      "type" => \Elementor\Controls_Manager::ICONS,
      "default" => [
        "value" => "fas fa-bars",
        "library" => "fa-solid",
      ],
    ]);

    $this->add_control("icon_color", [
      "label" => esc_html__("Icon Color", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::COLOR,
      "selectors" => [
        "{{WRAPPER}} #webkimael_mobile_menu_icon" => "color: {{VALUE}};",
      ],
    ]);

    $this->add_control("icon_size", [
      "label" => esc_html__("Icon Size", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::SLIDER,
      "size_units" => ["px"],
      "range" => [
        "px" => [
          "min" => 0,
          "max" => 100,
          "step" => 1,
        ],
      ],
      "default" => [
        "unit" => "px",
        "size" => 25,
      ],
      "selectors" => [
        "{{WRAPPER}} #webkimael_mobile_menu_icon" =>
          "font-size: {{SIZE}}{{UNIT}};",
      ],
    ]);

    $this->end_controls_section();
    // Content Tab End

    // Style Tab Start
    $this->start_controls_section("section_title_style", [
      "label" => esc_html__("Side Menu", "webkima-elements"),
      "tab" => \Elementor\Controls_Manager::TAB_STYLE,
    ]);

    $this->add_control("show_left_right", [
      "label" => esc_html__("Show Left or Right", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::SWITCHER,
      "label_on" => esc_html__("Left", "your-plugin"),
      "label_off" => esc_html__("Right", "your-plugin"),
      "return_value" => "Left",
      "default" => "0",
    ]);

    $this->add_control("aside_width", [
      "label" => esc_html__("Width", "elementor"),
      "type" => \Elementor\Controls_Manager::SLIDER,
      "size_units" => ["px", "%"],
      "range" => [
        "px" => [
          "min" => 250,
          "max" => 500,
          "step" => 1,
        ],
        "%" => [
          "min" => 0,
          "max" => 90,
        ],
      ],
      "default" => [
        "unit" => "px",
        "size" => 300,
      ],
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside" =>
          "min-width: {{SIZE}}{{UNIT}};",
      ],
    ]);

    $this->add_group_control(\Elementor\Group_Control_Background::get_type(), [
      "name" => "aside_background",
      "label" => esc_html__("Background Overlay", "elementor"),
      "types" => ["classic", "gradient"],
      "selector" => "{{WRAPPER}} .webkimael_mobile_menu_aside",
    ]);

    $this->end_controls_section();

    $this->start_controls_section("overly_section", [
      "label" => esc_html__("Background Overlay", "elementor"),
      "tab" => \Elementor\Controls_Manager::TAB_STYLE,
    ]);
    $this->add_group_control(\Elementor\Group_Control_Background::get_type(), [
      "name" => "dark_part_background",
      "label" => esc_html__("Background Overlay", "elementor"),
      "types" => ["classic", "gradient"],
      "selector" => "{{WRAPPER}} #webkimael_mobile_menu_dark_part",
    ]);

    $this->end_controls_section();

    /**
     * First Layar Menu Settings
     */
    $this->start_controls_section("first_layar_menu", [
      "label" => esc_html__("First Layar Menu", "elementor"),
      "tab" => \Elementor\Controls_Manager::TAB_STYLE,
    ]);

    $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
      "name" => "first_layar_typography",
      "label" => esc_html__("Firt Layar Typography", "elementor"),
      "selector" => "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > a",
    ]);

    $this->add_control("first_layar_text_color", [
      "label" => esc_html__("Link Color", "elementor"),
      "type" => \Elementor\Controls_Manager::COLOR,
      "default" => "var(--e-global-color-text)",
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > a" =>
          "color: {{VALUE}}",
      ],
    ]);

    $this->add_control("first_layar_text_color_hover", [
      "label" => esc_html__("Link Hover Color", "elementor"),
      "type" => \Elementor\Controls_Manager::COLOR,
      "default" => "#fff",
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > a:hover" =>
          "color: {{VALUE}}",
      ],
      "separator" => "after",
    ]);

    $this->add_control("first_layar_bg_color", [
      "label" => esc_html__("Background Color", "elementor"),
      "type" => \Elementor\Controls_Manager::COLOR,
      "default" => "#fff",
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > a" =>
          "background: {{VALUE}}",
      ],
    ]);
    $this->add_control("first_layar_bg_color_hover", [
      "label" => esc_html__("Background Color Hover", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::COLOR,
      "default" => "var(--e-global-color-primary)",
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > a:hover" =>
          "background: {{VALUE}}",
      ],
    ]);

    $this->add_control("first_layar_padding_x", [
      "label" => esc_html__("Horizontal Padding", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::SLIDER,
      "size_units" => ["px", "rem", "%"],
      "range" => [
        "px" => [
          "min" => 0,
          "max" => 100,
          "step" => 1,
        ],
        "rem" => [
          "min" => 0,
          "max" => 5,
          "step" => 0.1,
        ],
        "%" => [
          "min" => 0,
          "max" => 100,
        ],
      ],
      "default" => [
        "unit" => "rem",
        "size" => 2,
      ],
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > a" =>
          "padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};",
      ],
    ]);

    $this->add_control("first_layar_padding_y", [
      "label" => esc_html__("Vertical Padding", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::SLIDER,
      "size_units" => ["px", "rem", "%"],
      "range" => [
        "px" => [
          "min" => 0,
          "max" => 100,
          "step" => 1,
        ],
        "rem" => [
          "min" => 0,
          "max" => 5,
          "step" => 0.1,
        ],
        "%" => [
          "min" => 0,
          "max" => 100,
        ],
      ],
      "default" => [
        "unit" => "rem",
        "size" => 1,
      ],
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > a" =>
          "padding-top: {{SIZE}}{{UNIT}};padding-bottom: {{SIZE}}{{UNIT}};",
      ],
    ]);

    $this->add_control("hr2", [
      "type" => \Elementor\Controls_Manager::DIVIDER,
    ]);

    $this->add_control("first_layar_icon_size", [
      "label" => esc_html__("Icon Size", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::SLIDER,
      "size_units" => ["px", "rem"],
      "range" => [
        "px" => [
          "min" => 0,
          "max" => 150,
          "step" => 1,
        ],
        "rem" => [
          "min" => 0,
          "max" => 10,
          "step" => 0.1,
        ],
      ],
      "default" => [
        "unit" => "rem",
        "size" => 1.3,
      ],
      "selectors" => [
        "{{WRAPPER}} .menu-item-has-children > a:before" =>
          "font-size: {{SIZE}}{{UNIT}};",
      ],
    ]);

    $this->add_control("first_layar_icon_line_height", [
      "label" => esc_html__("Icon Line Height", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::SLIDER,
      "size_units" => ["px", "rem"],
      "range" => [
        "px" => [
          "min" => 0,
          "max" => 150,
          "step" => 1,
        ],
        "rem" => [
          "min" => 0,
          "max" => 10,
          "step" => 0.1,
        ],
      ],
      "default" => [
        "unit" => "rem",
        "size" => 1.5,
      ],
      "selectors" => [
        "{{WRAPPER}} .menu-item-has-children > a:before" =>
          "line-height: {{SIZE}}{{UNIT}};",
      ],
    ]);

    $this->add_control("first_layar_icon_space", [
      "label" => esc_html__("Icon Space", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::SLIDER,
      "size_units" => ["px", "rem", "%"],
      "range" => [
        "px" => [
          "min" => 0,
          "max" => 150,
          "step" => 1,
        ],
        "rem" => [
          "min" => 0,
          "max" => 10,
          "step" => 0.1,
        ],
        "%" => [
          "min" => 0,
          "max" => 100,
        ],
      ],
      "default" => [
        "unit" => "rem",
        "size" => 2,
      ],
      "selectors" => [
        "{{WRAPPER}} .menu-item-has-children > a:before" =>
          "left: {{SIZE}}{{UNIT}};",
      ],
    ]);

    $this->end_controls_section();

    /**
     * Second Layar Menu Settings
     */
    $this->start_controls_section("second_layar_menu", [
      "label" => esc_html__("Second Layar Menu", "webkima-elements"),
      "tab" => \Elementor\Controls_Manager::TAB_STYLE,
    ]);

    $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
      "name" => "second_layar_typography",
      "label" => esc_html__("second Layar Typography", "webkima-elements"),
      "selector" =>
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > ul > li > a",
    ]);

    $this->add_control("second_layar_text_color", [
      "label" => esc_html__("Link Color", "elementor"),
      "type" => \Elementor\Controls_Manager::COLOR,
      "default" => "var(--e-global-color-text)",
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > ul > li > a" =>
          "color: {{VALUE}}",
      ],
    ]);

    $this->add_control("second_layar_text_color_hover", [
      "label" => esc_html__("Link Hover Color", "elementor"),
      "type" => \Elementor\Controls_Manager::COLOR,
      "default" => "#fff",
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > ul > li > a:hover" =>
          "color: {{VALUE}}",
      ],
    ]);

    $this->add_control("hr3", [
      "type" => \Elementor\Controls_Manager::DIVIDER,
    ]);

    $this->add_control("second_layar_bg_color", [
      "label" => esc_html__("Background Color", "elementor"),
      "type" => \Elementor\Controls_Manager::COLOR,
      "default" => "#fff",
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > ul > li > a" =>
          "background: {{VALUE}}",
      ],
    ]);
    $this->add_control("second_layar_bg_color_hover", [
      "label" => esc_html__("Background Color Hover", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::COLOR,
      "default" => "var(--e-global-color-primary)",
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > ul > li > a:hover" =>
          "background: {{VALUE}}",
      ],
    ]);

    $this->add_control("second_layar_padding_x", [
      "label" => esc_html__("Horizontal Padding", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::SLIDER,
      "size_units" => ["px", "rem", "%"],
      "range" => [
        "px" => [
          "min" => 0,
          "max" => 100,
          "step" => 1,
        ],
        "rem" => [
          "min" => 0,
          "max" => 5,
          "step" => 0.1,
        ],
        "%" => [
          "min" => 0,
          "max" => 100,
        ],
      ],
      "default" => [
        "unit" => "rem",
        "size" => 2,
      ],
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > ul > li > a" =>
          "padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};",
      ],
    ]);

    $this->add_control("second_layar_padding_y", [
      "label" => esc_html__("Vertical Padding", "webkima-elements"),
      "type" => \Elementor\Controls_Manager::SLIDER,
      "size_units" => ["px", "rem", "%"],
      "range" => [
        "px" => [
          "min" => 0,
          "max" => 100,
          "step" => 1,
        ],
        "rem" => [
          "min" => 0,
          "max" => 5,
          "step" => 0.1,
        ],
        "%" => [
          "min" => 0,
          "max" => 100,
        ],
      ],
      "default" => [
        "unit" => "rem",
        "size" => 1,
      ],
      "selectors" => [
        "{{WRAPPER}} .webkimael_mobile_menu_aside > ul > li > ul > li > a" =>
          "padding-top: {{SIZE}}{{UNIT}};padding-bottom: {{SIZE}}{{UNIT}};",
      ],
    ]);

    $this->end_controls_section();
    // Style Tab End
  }

  protected function render() {
    $available_menus = $this->get_available_menus();

    if (!$available_menus) {
      return;
    }
    $settings = $this->get_active_settings();

    $args = [
      "echo" => false,
      "menu" => $settings["menu"],
      "menu_class" => "webkimael-nav-menu",
      "menu_id" =>
        "menu-" . $this->get_nav_menu_index() . "-" . $this->get_id(),
      "fallback_cb" => "__return_empty_string",
      "container" => "",
    ];
    // General Menu.
    $menu_html = wp_nav_menu($args);
    ?>
    <div id="webkimael_mobile_menu_icon">
    <?php \Elementor\Icons_Manager::render_icon($settings["icon"], ["aria-hidden" => "true"]); ?>
    </div>
    <div id="webkimael_mobile_menu_main">
      <div id="webkimael_mobile_menu_dark_part"></div>
      <div class="webkimael_mobile_menu_aside">
        <?php echo $menu_html; ?>
      </div>
    </div>
    <style>
      <?php if ($settings["show_left_right"] === "Left"): ?>
        .webkimael_mobile_menu_aside {left: 0;right: auto;transform: translateX(-100%);}
      <?php endif; ?>
    </style>
		<?php
  }
}
