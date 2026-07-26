<?php
/**
 * WooCommerce Checkout Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Checkout extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-woo-checkout';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Woo Checkout', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-cart';
    }

    public function get_style_depends() {
        return ['lcake-kit-woo-checkout-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => esc_html__('This widget displays the native WooCommerce checkout page content ([woocommerce_checkout] shortcode). Use it on your Checkout page only.', 'lc-addons-kit-for-elementor'),
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!LCAKE_Kit_Utils::is_woo_active()) {
            LCAKE_Kit_Utils::woo_inactive_notice();
            return;
        }
        ?>
        <div class="lcake-woo-checkout">
            <?php echo do_shortcode('[woocommerce_checkout]'); ?>
        </div>
        <?php
    }
}
