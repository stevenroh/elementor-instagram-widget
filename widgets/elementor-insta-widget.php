<?php

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Icons_Manager;

/**
 * Elementor instagram image carousel widget.
 *
 * Elementor widget that displays Instagram post images in a rotating carousel or
 * slider.
  */
class Widget_Insta_Carousel extends \Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script( 'insta-carousel', plugins_url( ) . '/rohs-insta-widget/js/insta-carousel.js', [ 'elementor-frontend' ], '1.0.0', true );
 	}

	/**
	 * Get widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'insta-carousel';
	}

	public function get_script_depends() {
		return [ 'insta-carousel' ];
  }

	/**
	 * Get widget title.
	 *
	 * Retrieve image carousel widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Instagram Carousel', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve image carousel widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-instagram-gallery';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'image', 'photo', 'visual', 'carousel', 'slider' ];
	}

	/**
	 * Register image carousel widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_image_carousel',
			[
				'label' => esc_html__( 'Image Carousel', 'rohs_insta_widget' ),
			]
		);

		$slides_to_show = range( 1, 10 );
		$slides_to_show = array_combine( $slides_to_show, $slides_to_show );

		$this->add_control(
			'feed_url',
			[
				'label' => esc_html__( 'JSON Feed URL', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'https://',
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'slides_to_show',
			[
				'label' => esc_html__( 'Slides to Show', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'elementor' ),
				] + $slides_to_show,
				'frontend_available' => true,
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}}' => '--e-image-carousel-slides-to-show: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'label' => esc_html__( 'Slides to Scroll', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'elementor' ),
				'options' => [
					'' => esc_html__( 'Default', 'elementor' ),
				] + $slides_to_show,
				'condition' => [
					'slides_to_show!' => '1',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'show_caption',
			[
				'label' => esc_html__( 'Show caption', 'rohs_insta_widget' ),
				'type' => Controls_Manager::SWITCHER,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => esc_html__( 'Navigation', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both' => esc_html__( 'Arrows and Dots', 'elementor' ),
					'arrows' => esc_html__( 'Arrows', 'elementor' ),
					'dots' => esc_html__( 'Dots', 'elementor' ),
					'none' => esc_html__( 'None', 'elementor' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'navigation_previous_icon',
			[
				'label' => esc_html__( 'Previous Arrow Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin' => 'inline',
				'label_block' => false,
				'skin_settings' => [
					'inline' => [
						'none' => [
							'label' => 'Default',
							'icon' => 'eicon-chevron-left',
						],
						'icon' => [
							'icon' => 'eicon-star',
						],
					],
				],
				'recommended' => [
					'fa-regular' => [
						'arrow-alt-circle-left',
						'caret-square-left',
					],
					'fa-solid' => [
						'angle-double-left',
						'angle-left',
						'arrow-alt-circle-left',
						'arrow-circle-left',
						'arrow-left',
						'caret-left',
						'caret-square-left',
						'chevron-circle-left',
						'chevron-left',
						'long-arrow-alt-left',
					],
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'navigation',
							'operator' => '=',
							'value' => 'both',
						],
						[
							'name' => 'navigation',
							'operator' => '=',
							'value' => 'arrows',
						],
					],
				],
			]
		);

		$this->add_control(
			'navigation_next_icon',
			[
				'label' => esc_html__( 'Next Arrow Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin' => 'inline',
				'label_block' => false,
				'skin_settings' => [
					'inline' => [
						'none' => [
							'label' => 'Default',
							'icon' => 'eicon-chevron-right',
						],
						'icon' => [
							'icon' => 'eicon-star',
						],
					],
				],
				'recommended' => [
					'fa-regular' => [
						'arrow-alt-circle-right',
						'caret-square-right',
					],
					'fa-solid' => [
						'angle-double-right',
						'angle-right',
						'arrow-alt-circle-right',
						'arrow-circle-right',
						'arrow-right',
						'caret-right',
						'caret-square-right',
						'chevron-circle-right',
						'chevron-right',
						'long-arrow-alt-right',
					],
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'navigation',
							'operator' => '=',
							'value' => 'both',
						],
						[
							'name' => 'navigation',
							'operator' => '=',
							'value' => 'arrows',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'elementor' ),
			]
		);

		$this->add_control(
			'lazyload',
			[
				'label' => esc_html__( 'Lazyload', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'elementor' ),
					'no' => esc_html__( 'No', 'elementor' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'elementor' ),
					'no' => esc_html__( 'No', 'elementor' ),
				],
				'condition' => [
					'autoplay' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_interaction',
			[
				'label' => esc_html__( 'Pause on Interaction', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'elementor' ),
					'no' => esc_html__( 'No', 'elementor' ),
				],
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		// Loop requires a re-render so no 'render_type = none'
		$this->add_control(
			'infinite',
			[
				'label' => esc_html__( 'Infinite Loop', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'elementor' ),
					'no' => esc_html__( 'No', 'elementor' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => esc_html__( 'Effect', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'elementor' ),
					'fade' => esc_html__( 'Fade', 'elementor' ),
				],
				'condition' => [
					'slides_to_show' => '1',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Animation Speed', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'direction',
			[
				'label' => esc_html__( 'Direction', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ltr',
				'options' => [
					'ltr' => esc_html__( 'Left', 'elementor' ),
					'rtl' => esc_html__( 'Right', 'elementor' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => esc_html__( 'Navigation', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => esc_html__( 'Arrows', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => esc_html__( 'Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => esc_html__( 'Inside', 'elementor' ),
					'outside' => esc_html__( 'Outside', 'elementor' ),
				],
				'prefix_class' => 'elementor-arrows-position-',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => esc_html__( 'Size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => esc_html__( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev svg, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => esc_html__( 'Pagination', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => esc_html__( 'Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'outside',
				'options' => [
					'outside' => esc_html__( 'Outside', 'elementor' ),
					'inside' => esc_html__( 'Inside', 'elementor' ),
				],
				'prefix_class' => 'elementor-pagination-position-',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => esc_html__( 'Size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_inactive_color',
			[
				'label' => esc_html__( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					// The opacity property will override the default inactive dot color which is opacity 0.2.
					'{{WRAPPER}} .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)' => 'background: {{VALUE}}; opacity: 1',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => esc_html__( 'Active Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'gallery_vertical_align',
			[
				'label' => esc_html__( 'Vertical Align', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'condition' => [
					'slides_to_show!' => '1',
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-wrapper' => 'display: flex; align-items: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => esc_html__( 'Spacing', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'elementor' ),
					'custom' => esc_html__( 'Custom', 'elementor' ),
				],
				'default' => '',
				'condition' => [
					'slides_to_show!' => '1',
				],
			]
		);

		$this->add_control(
			'image_spacing_custom',
			[
				'label' => esc_html__( 'Image Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 20,
				],
				'show_label' => false,
				'condition' => [
					'image_spacing' => 'custom',
					'slides_to_show!' => '1',
				],
				'frontend_available' => true,
				'render_type' => 'none',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .swiper-slide-image',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .swiper-slide-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_caption',
			[
				'label' => esc_html__( 'Caption', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption_type!' => '',
				],
			]
		);

		$this->add_control(
			'caption_align',
			[
				'label' => esc_html__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .elementor-image-carousel-caption' => 'text-align: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Render image carousel widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$lazyload = 'yes' === $settings['lazyload'];
		$show_caption = 'yes' === $settings['show_caption'];
		$url = $settings['feed_url'];
		$content = file_get_contents($url);
		$feed_content = json_decode($content);

		$images = $feed_content->data;

		$slides = [];
		foreach ( $images as $image ) {
			$image_caption =  $image->text;
			$image_url = $image->image;
	
			if ( $lazyload ) {
				$image_html = '<img class="swiper-slide-image swiper-lazy" data-src="' . $image_url . '" />';
			} else {
				$image_html = '<img class="swiper-slide-image" src="' . $image_url . '" />';
			}

			$slide_html = '<div class="swiper-slide"><figure class="swiper-slide-inner">' . $image_html;

			if ( $lazyload ) {
				$slide_html .= '<div class="swiper-lazy-preloader"></div>';
			}

			if ( $show_caption && ! empty( $image_caption ) ) {
				$slide_html .= '<figcaption class="elementor-image-carousel-caption">' . wp_kses_post( $image_caption ) . '</figcaption>';
			}

			$slide_html .= '</figure>';
			$slide_html .= '</div>';

			$slides[] = $slide_html;
		}

		if ( empty( $slides ) ) {
			return;
		}

		$this->add_render_attribute( [
			'carousel' => [
				'class' => 'elementor-image-carousel swiper-wrapper',
			],
			'carousel-wrapper' => [
				'class' => 'elementor-image-carousel-wrapper swiper-container',
				'dir' => $settings['direction'],
			],
		] );

		$show_dots = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		$slides_count = count( $images );

		?>
		<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
				<?php // PHPCS - $slides contains the slides content, all the relevent content is escaped above. ?>
				<?php echo implode( '', $slides ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<?php if ( 1 < $slides_count ) : ?>
				<?php if ( $show_dots ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>
				<?php if ( $show_arrows ) : ?>
					<div class="elementor-swiper-button elementor-swiper-button-prev">
						<?php $this->render_swiper_button( 'previous' ); ?>
						<span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'elementor' ); ?></span>
					</div>
					<div class="elementor-swiper-button elementor-swiper-button-next">
						<?php $this->render_swiper_button( 'next' ); ?>
						<span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'elementor' ); ?></span>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
	}

	private function render_swiper_button( $type ) {
		$direction = 'next' === $type ? 'right' : 'left';
		$icon_settings = $this->get_settings_for_display( 'navigation_' . $type . '_icon' );

		if ( empty( $icon_settings['value'] ) ) {
			$icon_settings = [
				'library' => 'eicons',
				'value' => 'eicon-chevron-' . $direction,
			];
		}

		Icons_Manager::render_icon( $icon_settings, [ 'aria-hidden' => 'true' ] );
	}
}
