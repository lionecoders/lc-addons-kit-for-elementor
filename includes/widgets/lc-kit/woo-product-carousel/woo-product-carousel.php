<?php
/**
 * WooCommerce Product Carousel Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woo Product Carousel Widget.
 *
 * Elementor widget that displays a Woo Product Carousel.
 */
class LCAKE_Kit_Woo_Product_Carousel extends \Elementor\Widget_Base {

	public function get_required_dependencies() {
		return array(
			array(
				'type'  => 'plugin',
				'class' => 'WooCommerce',
				'name'  => 'WooCommerce',
			),
		);
	}

	public function get_name() {
		return 'lcake-kit-woo-product-carousel';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Woo Product Carousel', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-products lcake-mveous-badge';
	}

	public function get_style_depends() {
		return array( 'lcake-swiper-css', 'lcake-kit-woo-product-carousel-css' );
	}

	public function get_script_depends() {
		return array( 'lcake-swiper-js', 'lcake-kit-woo-product-carousel-js' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Query', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'products_count',
			array(
				'label'   => esc_html__( 'Products Count', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
			)
		);

		$this->add_responsive_control(
			'slides_per_view',
			array(
				'label'          => esc_html__( 'Slides Per View', 'lc-addons-kit-for-elementor' ),
				'type'           => \Elementor\Controls_Manager::NUMBER,
				'default'        => 4,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'min'            => 1,
				'max'            => 6,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'   => esc_html__( 'Autoplay', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'   => esc_html__( 'Loop', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'navigation',
			array(
				'label'   => esc_html__( 'Navigation', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'both',
				'options' => array(
					'both'   => esc_html__( 'Arrows and Dots', 'lc-addons-kit-for-elementor' ),
					'arrows' => esc_html__( 'Arrows', 'lc-addons-kit-for-elementor' ),
					'dots'   => esc_html__( 'Dots', 'lc-addons-kit-for-elementor' ),
					'none'   => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'icon_prev',
			array(
				'label'            => esc_html__( 'Previous Icon', 'lc-addons-kit-for-elementor' ),
				'type'             => \Elementor\Controls_Manager::ICONS,
				'default'          => array(
					'value'   => 'fas fa-angle-left',
					'library' => 'fa-solid',
				),
				'condition'        => array(
					'navigation' => array( 'both', 'arrows' ),
				),
			)
		);

		$this->add_control(
			'icon_next',
			array(
				'label'            => esc_html__( 'Next Icon', 'lc-addons-kit-for-elementor' ),
				'type'             => \Elementor\Controls_Manager::ICONS,
				'default'          => array(
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				),
				'condition'        => array(
					'navigation' => array( 'both', 'arrows' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Price Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-carousel-price' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-carousel-title' => 'color: {{VALUE}};', '{{WRAPPER}} .lcake-woo-carousel-title a' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-woo-carousel-title, {{WRAPPER}} .lcake-woo-carousel-title a',
			)
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'section_navigation_style',
			array(
				'label'     => esc_html__( 'Navigation', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'navigation!' => 'none',
				),
			)
		);

		$this->add_control(
			'heading_arrows',
			array(
				'label'     => esc_html__( 'Arrows', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'condition' => array(
					'navigation' => array( 'both', 'arrows' ),
				),
			)
		);

		$this->add_control(
			'arrow_color',
			array(
				'label'     => esc_html__( 'Arrow Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .lcake-woo-carousel-nav' => 'color: {{VALUE}}; fill: {{VALUE}};' ),
				'condition' => array(
					'navigation' => array( 'both', 'arrows' ),
				),
			)
		);

		$this->add_control(
			'arrow_bg_color',
			array(
				'label'     => esc_html__( 'Arrow Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .lcake-woo-carousel-nav' => 'background-color: {{VALUE}};' ),
				'condition' => array(
					'navigation' => array( 'both', 'arrows' ),
				),
			)
		);

		$this->add_responsive_control(
			'arrow_size',
			array(
				'label'      => esc_html__( 'Arrow Size', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-carousel-nav' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-woo-carousel-nav svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'navigation' => array( 'both', 'arrows' ),
				),
			)
		);

		$this->add_control(
			'heading_dots',
			array(
				'label'     => esc_html__( 'Dots', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'navigation' => array( 'both', 'dots' ),
				),
			)
		);

		$this->add_control(
			'dot_color',
			array(
				'label'     => esc_html__( 'Dot Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};' ),
				'condition' => array(
					'navigation' => array( 'both', 'dots' ),
				),
			)
		);

		$this->add_control(
			'dot_active_color',
			array(
				'label'     => esc_html__( 'Dot Active Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};' ),
				'condition' => array(
					'navigation' => array( 'both', 'dots' ),
				),
			)
		);

		$this->add_responsive_control(
			'dot_size',
			array(
				'label'      => esc_html__( 'Dot Size', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min' => 4,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'navigation' => array( 'both', 'dots' ),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! LCAKE_Kit_Utils::is_woo_active() ) {
			LCAKE_Kit_Utils::woo_inactive_notice();
			return;
		}

		$settings = $this->get_settings_for_display();

		$query = new \WP_Query(
			array(
				'post_type'           => 'product',
				'posts_per_page'      => (int) $settings['products_count'],
				'ignore_sticky_posts' => true,
			)
		);

		if ( ! $query->have_posts() ) {
			return;
		}

		$config = array(
			'slidesPerView'       => (int) ( $settings['slides_per_view'] ?? 4 ),
			'slidesPerViewTablet' => (int) ( $settings['slides_per_view_tablet'] ?? 2 ),
			'slidesPerViewMobile' => (int) ( $settings['slides_per_view_mobile'] ?? 1 ),
			'autoplay'            => 'yes' === $settings['autoplay'],
			'loop'                => 'yes' === $settings['loop'],
		);

		$show_arrows = in_array( $settings['navigation'], array( 'both', 'arrows' ) );
		$show_dots   = in_array( $settings['navigation'], array( 'both', 'dots' ) );
		?>
		<div class="lcake-woo-carousel-wrapper">
			<div class="lcake-woo-carousel swiper" data-config="<?php echo esc_attr( wp_json_encode( $config ) ); ?>">
				<div class="swiper-wrapper">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						global $product; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
						if ( ! $product instanceof \WC_Product ) {
							$product = wc_get_product( get_the_ID() ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
						}
						if ( ! $product ) {
							continue;
						}
						?>
						<div class="swiper-slide">
							<div class="lcake-woo-carousel-card">
								<a href="<?php the_permalink(); ?>" class="lcake-woo-carousel-thumb">
									<?php echo wp_kses_post( $product->get_image( 'medium', array( 'class' => 'lcake-woo-carousel-image' ) ) ); ?>
								</a>
								<div class="lcake-woo-carousel-content">
									<h3 class="lcake-woo-carousel-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<div class="lcake-woo-carousel-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<?php if ( $show_dots ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>
			</div>
			<?php if ( $show_arrows ) : ?>
				<div class="lcake-woo-carousel-nav lcake-woo-carousel-prev">
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon_prev'], array( 'aria-hidden' => 'true' ) ); ?>
				</div>
				<div class="lcake-woo-carousel-nav lcake-woo-carousel-next">
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon_next'], array( 'aria-hidden' => 'true' ) ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
		wp_reset_postdata();
	}
}
