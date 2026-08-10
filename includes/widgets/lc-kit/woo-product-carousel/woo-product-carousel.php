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
		return 'eicon-products';
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
			'title_hover_underline',
			array(
				'label'     => esc_html__( 'Title Hover Underline', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'      => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
					'underline' => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-woo-carousel-title a:hover' => 'text-decoration: {{VALUE}} !important;',
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
		?>
		<div class="lcake-woo-carousel-wrapper">
			<div class="lcake-woo-carousel swiper" data-config="<?php echo esc_attr( wp_json_encode( $config ) ); ?>">
				<div class="swiper-wrapper">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						global $product;
						if ( ! $product instanceof \WC_Product ) {
							$product = wc_get_product( get_the_ID() );
						}
						if ( ! $product ) {
							continue;
						}
						?>
						<div class="swiper-slide">
							<div class="lcake-woo-carousel-card">
								<a href="<?php the_permalink(); ?>" class="lcake-woo-carousel-thumb">
									<?php echo $product->get_image( 'medium', array( 'class' => 'lcake-woo-carousel-image' ) ); ?>
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
				<div class="swiper-pagination"></div>
			</div>
			<div class="lcake-woo-carousel-nav lcake-woo-carousel-prev">&#10094;</div>
			<div class="lcake-woo-carousel-nav lcake-woo-carousel-next">&#10095;</div>
		</div>
		<?php
		wp_reset_postdata();
	}
}
