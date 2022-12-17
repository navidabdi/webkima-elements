<?php

if (!defined("ABSPATH")) {
	exit(); // Exit if accessed directly
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

class WebkimaELMetroList extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'Webkima_Elements_Metro_List';
	}

	public function get_title(): string {
		return esc_html__('لیست مترو', 'webkima-elements');
	}

	public function get_icon(): string {
		return "eicon-checkbox";
	}

	public function get_categories(): array {
		return ['webkima-elements'];
	}

	public function get_keywords(): array {
		return ['list', 'metro', 'ul'];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('محتوای لیست', 'webkima-elements'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		/* Start repeater */

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label'       => esc_html__('Text', 'elementor'),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است', 'webkima-elements'),
				'default'     => esc_html__('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است', 'webkima-elements'),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		/* End repeater */

		$this->add_control(
			'list_items',
			[
				'label'       => esc_html__('لیست مترو', 'webkima-elements'),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),           /* Use our repeater */
				'default'     => [
					[
						'text' => esc_html__('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است', 'webkima-elements'),
					],
					[
						'text' => esc_html__('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است', 'webkima-elements'),
					],
					[
						'text' => esc_html__('لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است', 'webkima-elements'),
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'metro_section',
			[
				'label' => esc_html__('نوع مترو', 'webkima-elements'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'metro_type',
			[
				'label'   => esc_html__('نوع مترو', 'webkima-elements'),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'ordered' => [
						'title' => esc_html__('Ordered List', 'webkima-elements'),
						'icon'  => 'eicon-editor-list-ol',
					],
					'icon'    => [
						'title' => esc_html__('Custom List', 'webkima-elements'),
						'icon'  => 'eicon-edit',
					],
				],
				'default' => 'ordered',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'metro_icon',
			[
				'label'                  => esc_html__('Icon', 'elementor'),
				'type'                   => \Elementor\Controls_Manager::ICONS,
				'skin'                   => 'inline',
				'label_block'            => false,
				'separator'              => 'before',
				'exclude_inline_options' => ['svg'],
				'frontend_available'     => true,
				'default'                => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'fa4compatibility'       => 'icon',
				'condition'              => [
					'metro_type[value]' => 'icon',
				],
//				'selectors'              => [
//					'{{WRAPPER}} .webkima-el-metro > li::before' => 'content: "{{VALUE}}";',
//				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_content_section',
			[
				'label' => esc_html__('List Style', 'webkima-elements'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__('Color', 'webkima-elements'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .webkima-el-metro' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'icon_typography',
				'selector' => '{{WRAPPER}} .webkima-el-metro',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__('Alignment', 'elementor'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'right'   => [
						'title' => esc_html__('Right', 'elementor'),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__('Justified', 'elementor'),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ul.webkima-el-metro > li' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control('list_line_height', [
			'label'      => esc_html__('فاصله بین خطوط', 'webkima-elements'),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range'      => [
				'px' => [
					'min'  => 20,
					'max'  => 60,
					'step' => 1,
				],
			],
			'default'    => [
				'unit' => "px",
				'size' => 25,
			],
			'selectors'  => [
				'{{WRAPPER}} .webkima-el-metro:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_marker_section',
			[
				'label' => esc_html__('استایل متروها', 'webkima-elements'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'metro_color',
			[
				'label'     => esc_html__('Color', 'elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .webkima-el-metro > li::before, .webkima-el-metro > li > i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'metro_background',
			[
				'label'     => esc_html__('Background', 'elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--e-global-color-primary)',
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .webkima-el-metro > li::before, .webkima-el-metro > li > i' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'marker_spacing',
			[
				'label'      => esc_html__('فاصله بین مترو', 'webkima-elements'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range'      => [
					'px'  => [
						'min' => 30,
						'max' => 80,
					],
					'em'  => [
						'min' => 2,
						'max' => 8,
					],
					'rem' => [
						'min' => 2,
						'max' => 8,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 38,
				],
				'selectors'  => [
					'{{WRAPPER}} .webkima-el-metro-list li.webkima-el-metro' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

      <ul class="webkima-el-metro-list webkima-el-metro <?= $settings['metro_type']; ?>">
				<?php
				foreach ($settings['list_items'] as $index => $item) {

					?>
            <li class="webkima-el-metro">
               <?php if ($settings['metro_type'] === 'icon'):
                \Elementor\Icons_Manager::render_icon($settings["metro_icon"], ["aria-hidden" => "true"]);
                endif; ?>
							<?php echo $settings['list_items'][ $index ]['text']; ?>
            </li>
					<?php
				}
				?>
      </ul>
      <style>
        ul.webkima-el-metro-list {
          list-style: none;
          position: relative;
          padding: 0;
        }

        ul.webkima-el-metro-list:before {
          content: '';
          position: absolute;
          width: 2px;
          height: 90%;
          border-right: dashed 2px blue;
          right: 16px;
          top: 50%;
          transform: translateY(-50%);
        }

        ul.webkima-el-metro-list li {
          counter-increment: step-counter;
          position: relative;
        }
        ul.webkima-el-metro-list.ordered > li:before {
          content: counter(step-counter);
        }
        ul.webkima-el-metro-list.ordered > li:before, ul.webkima-el-metro-list.icon > li > i {
          line-height: 29px;
          text-align: center;
          font-size: 1em;
          width: 26px;
          height: 26px;
          top: 0;
          right: 3px;
          position: absolute;
          border-radius: 9px;
        }

        ul.webkima-el-metro-list.icon > li > i {
          line-height: 26px;
        }
      </style>
		<?php
	}


}