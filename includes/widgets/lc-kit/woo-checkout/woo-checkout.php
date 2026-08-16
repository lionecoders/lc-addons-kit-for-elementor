<?php
/**
 * WooCommerce Checkout Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woo Checkout Widget.
 *
 * Elementor widget that displays a Woo Checkout.
 */
class LCAKE_Kit_Woo_Checkout extends \Elementor\Widget_Base {

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
		return 'lcake-kit-woo-checkout';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Woo Checkout', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-checkout lcake-mveous-badge';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-woo-checkout-css' );
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
                    <strong style="display: block; margin-bottom: 4px;"><span class="dashicons dashicons-info" style="font-size: 16px; vertical-align: text-bottom; margin-right: 4px;"></span>Woo Checkout Page</strong>
                    This widget displays the native WooCommerce checkout page content dynamically using the <code>[woocommerce_checkout]</code> shortcode. Use it on your Checkout page.
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

		$is_editor   = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$added_dummy = false;

		if ( $is_editor && function_exists( 'WC' ) && WC()->cart ) {
			// Force enqueueing scripts/styles needed for checkout in editor
			wp_enqueue_script( 'wc-checkout' );
			wp_enqueue_style( 'select2' );
			wp_enqueue_script( 'select2' );

			if ( WC()->cart->is_empty() ) {
				$products = get_posts(
					array(
						'post_type'      => 'product',
						'posts_per_page' => 1,
						'post_status'    => 'publish',
					)
				);
				if ( ! empty( $products ) ) {
					WC()->cart->add_to_cart( $products[0]->ID, 1 );
					$added_dummy = true;
					// Recalculate totals so the checkout doesn't think it's empty
					WC()->cart->calculate_totals();
				}
			}
		}
		?>
		<div class="lcake-woo-checkout">
			<?php echo do_shortcode( '[woocommerce_checkout]' ); ?>
		</div>
		<?php

		if ( $added_dummy && function_exists( 'WC' ) && WC()->cart ) {
			WC()->cart->empty_cart();
		}
	}
}
