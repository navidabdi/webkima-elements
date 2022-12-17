<?php

if ( !defined("ABSPATH")) {
	exit(); // Exit if accessed directly
}

use WebkimaElements\Helper;

class WebkimaELPostCarousel extends \Elementor\Widget_Base {

	public function get_name(): string {
		return "Webkima_Elements_Post_Carousel";
	}

	public function get_title(): string {
		return esc_html__("اسلایدر مقالات", "webkima-elements");
	}

	public function get_icon(): string {
		return "eicon-post-slider";
	}

	public function get_categories(): array {
		return ["webkima-elements"];
	}

	public function get_keywords(): array {
		return ["slider", "carousel"];
	}

	protected function register_controls() {
		$post_cat   = [];
		$categories = get_terms("category");
		if ( !empty($categories) && !is_wp_error($categories)) {
			foreach ($categories as $category) {
				$post_cat[ $category->term_id ] = $category->name;
			}
		}

		$post_taga = [];
		$tags      = get_terms("post_tag");
		if ( !empty($tags) && !is_wp_error($tags)) {
			foreach ($tags as $tag) {
				$post_taga[ $tag->term_id ] = $tag->name;
			}
		}

		$this->start_controls_section("section_layout", [
			'label' => __('اسلایدر مقالات', 'webkima-elements'),
		]);

		$this->add_group_control(
			Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'    => 'thumbnail',
				'label'   => esc_html__('Image Resolution', 'elementor-pro'),
				'default' => 'large',
			]
		);

		$this->add_control(
			'post_sort',
			[
				'label'   => __('فیلتر مقالات', 'webkima-elements'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'latest',
				'options' => [
					'latest'   => __('جدیدترین مقالات', 'webkima-elements'),
					'oldest'   => __('قدیمی‌ترین مقالات', 'webkima-elements'),
					'random'   => __('مقالات تصادفی', 'webkima-elements'),
					'modified' => __('مقالات آپدیت شده', 'webkima-elements'),
				],
			]
		);

		$this->add_control(
			'ptotalcount',
			[
				'label'   => __('تعداد مقالات', 'webkima-elements'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 10,
				'step'    => 1,
				'default' => 4,
			]
		);
		$this->end_controls_section();
		// Content Tab End

		// Style Tab Start
		$this->start_controls_section("section_title_style", [
			"label" => esc_html__("استایل دهی کلی", "webkima-elements"),
			"tab"   => \Elementor\Controls_Manager::TAB_STYLE,
		]);

		$this->add_control("post_carousel_height", [
			"label"      => esc_html__("Height", "elementor"),
			"type"       => \Elementor\Controls_Manager::SLIDER,
			"size_units" => ["px"],
			"range"      => [
				"px" => [
					"min"  => 350,
					"max"  => 600,
					"step" => 1,
				],
			],
			"default"    => [
				"unit" => "px",
				"size" => 450,
			],
			"selectors"  => [
				"{{WRAPPER}} .webkima-el-carousel" =>
					"min-height: {{SIZE}}{{UNIT}};",
			],
		]);

		$this->add_group_control(\Elementor\Group_Control_Background::get_type(), [
			"name"     => "post_carousel_background",
			"label"    => esc_html__("Background Overlay", "elementor"),
			"types"    => ["classic", "gradient"],
			"selector" => "{{WRAPPER}} .webkima-el-carousel-item",
		]);
		$this->end_controls_section();

		$this->start_controls_section("content_section", [
			"label" => esc_html__("استایل محتوا", "elementor"),
			"tab"   => \Elementor\Controls_Manager::TAB_STYLE,
		]);

		$this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
			"name"           => "post_carousel_title_typography",
			"label"          => esc_html__("تایپوگرافی عنوان", "webkima-elements"),
			"selector"       =>
				"{{WRAPPER}} .webkima-el-carousel .webkima-el-carousel-item__title",
			'fields_options' => [
				// first mimic the click on Typography edit icon
				'typography'  => ['default' => 'yes'],
				// then redefine the Elementor defaults
				'font_size'   => ['default' => ['unit' => 'px', 'size' => 28]],
				'font_weight' => ['default' => 700],
				'line_height' => ['default' => ['unit' => 'em', 'size' => 1.7]],
			],
		]);

		$this->add_control("post_carousel_title_color", [
			"label"     => esc_html__("رنگ عنوان", "elementor"),
			"type"      => \Elementor\Controls_Manager::COLOR,
			"default"   => "var(--e-global-color-text)",
			"selectors" => [
				"{{WRAPPER}} .webkima-el-carousel .webkima-el-carousel-item__title" => "color: {{VALUE}}",
			],
		]);

		$this->add_control("oneline_title", [
			"label"        => esc_html__("نمایش عنوان در یک خط", "webkima-elements"),
			"type"         => \Elementor\Controls_Manager::SWITCHER,
			"label_on"     => esc_html__("روشن", "your-plugin"),
			"label_off"    => esc_html__("خاموش", "your-plugin"),
			"return_value" => true,
			"default"      => false,
		]);

		$this->add_control("hr1", [
			"type" => \Elementor\Controls_Manager::DIVIDER,
		]);

		$this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
			"name"           => "post_carousel_description_typography",
			"label"          => esc_html__("تایپوگرافی توضیحات", "webkima-elements"),
			"selector"       =>
				"{{WRAPPER}} .webkima-el-carousel .webkima-el-carousel-item__description",
			'fields_options' => [
				// first mimic the click on Typography edit icon
				'typography'  => ['default' => 'yes'],
				// then redefine the Elementor defaults
				'font_size'   => ['default' => ['unit' => 'px', 'size' => 14]],
				'font_weight' => ['default' => 400],
				'line_height' => ['default' => ['unit' => 'em', 'size' => 1.7]],
			],
		]);

		$this->add_control("post_carousel_description_color", [
			"label"     => esc_html__("رنگ توضیحات", "elementor"),
			"type"      => \Elementor\Controls_Manager::COLOR,
			"default"   => "var(--e-global-color-text)",
			"selectors" => [
				"{{WRAPPER}} .webkima-el-carousel .webkima-el-carousel-item__description" => "color: {{VALUE}}",
			],
		]);

		$this->add_control("post_excerpt_length", [
			"label"   => esc_html__("طول توضیحات", "elementor"),
			"type"    => \Elementor\Controls_Manager::SLIDER,
			"range"   => [
				"px" => [
					"min"  => 10,
					"max"  => 50,
					"step" => 1,
				],
			],
			"default" => [
				"size" => 40,
			],
		]);

		$this->add_control("hr2", [
			"type" => \Elementor\Controls_Manager::DIVIDER,
		]);

		$this->end_controls_section();

		$this->start_controls_section("arrow_section", [
			"label" => esc_html__("استایل دکمه‌های ناوبری", "elementor"),
			"tab"   => \Elementor\Controls_Manager::TAB_STYLE,
		]);

		$this->add_control("post_carousel_arrows_bg", [
			"label"     => esc_html__("رنگ پس زمینه", "elementor"),
			"type"      => \Elementor\Controls_Manager::COLOR,
			"default"   => "#fff",
			"selectors" => [
				"{{WRAPPER}} .webkima-el-carousel .webkima-el-carousel__nav" => "background: {{VALUE}}",
			],
		]);

		$this->add_control("post_carousel_arrows_bg_hover", [
			"label"     => esc_html__("هاور پس زمینه", "elementor"),
			"type"      => \Elementor\Controls_Manager::COLOR,
			"selectors" => [
				"{{WRAPPER}} .webkima-el-carousel .webkima-el-carousel__arrow:hover" => "background: {{VALUE}}",
			],
		]);

		$this->add_control('post_carousel_arrow_horizontal_pos', [
				'label'   => __('جایگاه افقی', 'webkima-elements'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'   => __('سمت چپ', 'webkima-elements'),
					'center-hor' => __('وسط', 'webkima-elements'),
					'right'  => __('سمت راست', 'webkima-elements'),
				],
			]
		);

		$this->add_control('post_carousel_arrow_vertical_pos', [
				'label'   => __('جایگاه عمودی', 'webkima-elements'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'top'    => __('بالا', 'webkima-elements'),
					'center-ver' => __('وسط', 'webkima-elements'),
					'bottom' => __('پایین', 'webkima-elements'),
				],
			]
		);

		$this->add_control("post_carousel_left_icon", [
			"label"       => esc_html__("آیکون چپ", "elementor"),
			"type"        => \Elementor\Controls_Manager::ICONS,
			"default"     => [
				"value"   => "fas fa-arrow-left",
				"library" => "fa-solid",
			],
			'recommended' => [
				'fa-solid' => [
					'arrow-left',
					'arrow-alt-circle-left',
					'angle-left',
					'chevron-left',
					'angle-double-left',
				],
			],
		]);

		$this->add_control("post_carousel_right_icon", [
			"label"       => esc_html__("آیکون راست", "elementor"),
			"type"        => \Elementor\Controls_Manager::ICONS,
			"default"     => [
				"value"   => "fas fa-arrow-right",
				"library" => "fa-solid",
			],
			'recommended' => [
				'fa-solid' => [
					'arrow-right',
					'arrow-alt-circle-right',
					'angle-right',
					'chevron-right',
					'angle-double-right',
				],
			],
		]);

		$this->add_control("first_layar_icon_size", [
			"label"      => esc_html__("سایز آیکون", "webkima-elements"),
			"type"       => \Elementor\Controls_Manager::SLIDER,
			"size_units" => ["px", "rem"],
			"range"      => [
				"px"  => [
					"min"  => 14,
					"max"  => 35,
					"step" => 1,
				],
				"rem" => [
					"min"  => 0,
					"max"  => 2,
					"step" => 0.1,
				],
			],
			"default"    => [
				"unit" => "rem",
				"size" => 1,
			],
			"selectors"  => [
				"{{WRAPPER}} .webkima-el-carousel .webkima-el-carousel__arrow" =>
					"font-size: {{SIZE}}{{UNIT}};",
			],
		]);

		$this->add_control("post_carousel_arrows_color", [
			"label"     => esc_html__("رنگ آیکون‌ها", "elementor"),
			"type"      => \Elementor\Controls_Manager::COLOR,
			"default"   => "var(--e-global-color-text)",
			"selectors" => [
				"{{WRAPPER}} .webkima-el-carousel .webkima-el-carousel__arrow"                    => "color: {{VALUE}}",
				"{{WRAPPER}} .webkima-el-carousel .webkima-el-carousel__arrow:nth-child(1):after" => "background-color: {{VALUE}}",
			],
		]);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$post_sort = $settings['post_sort'];
		$args      = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $settings['ptotalcount'],
			'order'          => 'DESC',
		];

		switch ($post_sort) {
			case 'latest':
				$args['order'] = 'DESC';
				break;
			case 'oldest':
				$args['order'] = 'ASC';
				break;
			case 'modified':
				$args['orderby'] = 'modified';
				break;
			case 'random':
				$args['orderby'] = 'rand';
				break;
		}
		$posts_query = new \WP_Query($args);

		?>
      <div class="webkima-el-carousel">
          <div class="webkima-el-carousel__nav <?= $settings['post_carousel_arrow_horizontal_pos'] . ' ' . $settings['post_carousel_arrow_vertical_pos']; ?>">
              <span id="moveRight" class="webkima-el-carousel__arrow">
                  <?php \Elementor\Icons_Manager::render_icon($settings["post_carousel_right_icon"], ["aria-hidden" => "true"]); ?>
              </span>
              <span id="moveLeft" class="webkima-el-carousel__arrow">
                  <?php \Elementor\Icons_Manager::render_icon($settings["post_carousel_left_icon"], ["aria-hidden" => "true"]); ?>
              </span>
          </div>
				<?php if ($posts_query->have_posts()): ?>
					<?php while ($posts_query->have_posts()): $posts_query->the_post(); ?>
                <div class="webkima-el-carousel-item webkima-el-carousel-item--<?= get_the_ID(); ?>">
                    <div class="webkima-el-carousel-item__image">
											<?php echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), $settings['thumbnail_size']); ?>
                    </div>
                    <div class="webkima-el-carousel-item__info">
                        <div class="webkima-el-carousel-item__container">
                            <h2 class="webkima-el-carousel-item__title
                            <?= $settings['oneline_title'] ? 'webkima-el-oneline-title' : '' ?>"><?php the_title(); ?></h2>
                            <p class="webkima-el-carousel-item__description"><?= Helper::getTheExcerpt(get_the_excerpt(), $settings['post_excerpt_length']['size']); ?></p>
                            <a href="<?php the_permalink(); ?>" class="webkima-el-carousel-item__btn">مطالعه مقاله</a>
                        </div>
                    </div>
                </div>
					<?php endwhile; ?>
				<?php endif; ?>
<script>
  !function(){const e=document.querySelectorAll(".webkima-el-carousel-item"),t=document.querySelector("#moveRight"),c=document.querySelector("#moveLeft");e[0].classList.add("active");let i=e.length,l=0;function n(t,c){let n=l;c>i-1&&(n=0,l=0),c<0&&(n=i-1,l=i-1),e[t].classList.remove("active"),e[n].classList.add("active")}t.addEventListener("click",(function(){let e=l;l+=1,n(e,l)})),c.addEventListener("click",(function(){let e=l;l-=1,n(e,l)}))}();
</script>
      </div>
		<?php
	}

}