<?php
/**
 * WooCommerce Cart Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woo Cart Page Widget.
 *
 * Elementor widget that displays a Woo Cart Page.
 */
class LCAKE_Kit_Woo_Cart extends \Elementor\Widget_Base {

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
		return 'lcake-kit-woo-cart';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Woo Cart Page', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-woo-cart';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-woo-cart-css' );
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
			'notice',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => '<div style="background-color: #e0f2fe; border-left: 4px solid #0284c7; padding: 12px 15px; border-radius: 4px; font-size: 13px; color: #0369a1; line-height: 1.5; margin: 10px 0;">
                    <strong style="display: block; margin-bottom: 4px;"><span class="dashicons dashicons-info" style="font-size: 16px; vertical-align: text-bottom; margin-right: 4px;"></span>Woo Cart Page</strong>
                    This widget displays the native WooCommerce cart page content dynamically using the <code>[woocommerce_cart]</code> shortcode.
                </div>',
				'content_classes' => 'elementor-descriptor',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! LCAKE_Kit_Utils::is_woo_active() ) {
			LCAKE_Kit_Utils::woo_inactive_notice();
			return;
		}
		?>
		<div class="lcake-woo-cart">
			<?php echo do_shortcode( '[woocommerce_cart]' ); ?>
		</div>
		<?php
	}
}
