<?php
/**
 * Cart Icon Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Cart Icon Widget.
 *
 * Elementor widget that displays a Cart Icon.
 */
class LC_Header_Footer_Cart_Icon extends \Elementor\Widget_Base {

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
		return 'lc-header-footer-cart-icon';
	}

	public function get_title() {
		return esc_html__( 'Cart Icon', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-cart';
	}

	public function get_categories() {
		return array( 'lc-header-footer-kit' );
	}

	public function get_style_depends() {
		return array( 'lc-header-footer-cart-icon-css' );
	}

	public function get_script_depends() {
		return array( 'lc-header-footer-cart-icon-js' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_dropdown',
			array(
				'label'   => esc_html__( 'Show Mini Cart Dropdown', 'lc-addons-kit-for-elementor' ),
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
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lc-hf-cart-icon-btn' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'badge_color',
			array(
				'label'     => esc_html__( 'Badge Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lc-hf-cart-count' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! LCAKE_Kit_Utils::is_woo_active() || ! function_exists( 'WC' ) ) {
			LCAKE_Kit_Utils::plugin_inactive_notice( 'WooCommerce' );
			return;
		}

		$settings = $this->get_settings_for_display();
		$count    = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
		?>
		<div class="lc-hf-cart-icon">
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="lc-hf-cart-icon-btn">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
					<circle cx="9" cy="21" r="1"></circle>
					<circle cx="20" cy="21" r="1"></circle>
					<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
				</svg>
				<span class="lc-hf-cart-count"><?php echo esc_html( $count ); ?></span>
			</a>

			<?php if ( 'yes' === $settings['show_dropdown'] ) : ?>
				<div class="lc-hf-cart-dropdown widget_shopping_cart_content">
					<?php woocommerce_mini_cart(); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
