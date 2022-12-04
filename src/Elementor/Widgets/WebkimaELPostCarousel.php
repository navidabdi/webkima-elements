<?php

if ( !defined("ABSPATH")) {
	exit(); // Exit if accessed directly
}

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

		$this->add_control(
			'post_sort',
			[
				'label'   => __('فیلتر مقالات', 'webkima-elements'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'latest',
				'options' => [
					'latest' => __('جدیدترین مقالات', 'webkima-elements'),
					'random' => __('مقالات تصادفی', 'webkima-elements'),
					'viewed' => __('مقالات با بیشترین بازدید', 'webkima-elements'),
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

		$this->add_control("hr2", [
			"type" => \Elementor\Controls_Manager::DIVIDER,
		]);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$post_sort = $settings['post_sort'];

		switch ($post_sort) {
			case 'latest':
				$args = [
					'posts_per_page' => $settings['ptotalcount'],
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'order'          => 'DESC'
				];
				break;
			case 'viewed':
				$args = [
					'posts_per_page' => $settings['ptotalcount'],
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'meta_key'       => 'post_views_count',
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC'
				];
				break;
			case 'random':
				$args = [
					'posts_per_page' => $settings['ptotalcount'],
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'orderby'        => 'rand'
				];
				break;
			default:
				$args = [
					'posts_per_page' => $settings['ptotalcount'],
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'order'          => 'DESC'
				];
		}
		$posts_query = new \WP_Query($args);

		?>
      <div class="webkima-el-carousel">
          <div class="webkima-el-carousel__nav">

              <span id="moveRight" class="webkima-el-carousel__arrow">
      <svg class="webkima-el-carousel__icon" width="24" height="24" viewBox="0 0 24 24">
  <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
</svg>
    </span>
              <span id="moveLeft" class="webkima-el-carousel__arrow">
        <svg class="webkima-el-carousel__icon" width="24" height="24" viewBox="0 0 24 24">
    <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
</svg>
    </span>
          </div>
				<?php if ($posts_query->have_posts()): ?>
					<?php while ($posts_query->have_posts()): $posts_query->the_post(); ?>
                <div class="webkima-el-carousel-item webkima-el-carousel-item--1">
                    <div class="webkima-el-carousel-item__image">
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                    </div>
                    <div class="webkima-el-carousel-item__info">
                        <div class="webkima-el-carousel-item__container">
                            <h2 class="webkima-el-carousel-item__title"><?php the_title(); ?></h2>
                            <p class="webkima-el-carousel-item__description"><?php echo get_the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>" class="webkima-el-carousel-item__btn">مطالعه مقاله</a>
                        </div>
                    </div>
                </div>
					<?php endwhile; ?>
				<?php endif; ?>

      </div>
      <script>
        (function () {
          const carouselItems = document.querySelectorAll('.webkima-el-carousel-item'),
            moveRight = document.querySelector('#moveRight'),
            moveLeft = document.querySelector('#moveLeft');

          carouselItems[0].classList.add('active');
          let total = carouselItems.length;
          let current = 0;

          moveRight.addEventListener('click', function () {
            let next = current;
            current = current + 1;
            setSlide(next, current);
          });
          moveLeft.addEventListener('click', function () {
            let prev = current;
            current = current - 1;
            setSlide(prev, current);
          });

          function setSlide(prev, next) {
            let slide = current;
            if (next > total - 1) {
              slide = 0;
              current = 0;
            }
            if (next < 0) {
              slide = total - 1;
              current = total - 1;
            }
            carouselItems[prev].classList.remove('active');
            carouselItems[slide].classList.add('active');
          }
        })();
      </script>
		<?php
	}

}