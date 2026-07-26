<?php
/**
 * WooCommerce Product Tabs Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Product_Tabs extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-woo-product-tabs';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Woo Product Tabs', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-woocommerce';
    }

    public function get_style_depends() {
        return ['lcake-kit-woo-product-tabs-css'];
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
            'product_id',
            [
                'label' => esc_html__('Product', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => LCAKE_Kit_Utils::get_woo_product_options(),
                'default' => 0,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'active_color',
            [
                'label' => esc_html__('Active Tab Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-woo-tabs ul.tabs li.active a' => 'color: {{VALUE}}; border-color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!LCAKE_Kit_Utils::is_woo_active()) {
            LCAKE_Kit_Utils::woo_inactive_notice();
            return;
        }

        $settings = $this->get_settings_for_display();
        $product_id = (int) $settings['product_id'];
        $product = LCAKE_Kit_Utils::get_woo_product($product_id);

        if (!$product) {
            return;
        }

        global $post;
        $original_post = $post;
        $original_product = isset($GLOBALS['product']) ? $GLOBALS['product'] : null;

        $post = get_post($product->get_id());
        $GLOBALS['product'] = $product;
        setup_postdata($post);
        ?>
        <div class="lcake-woo-tabs">
            <?php wc_get_template('single-product/tabs/tabs.php'); ?>
        </div>
        <?php
        $post = $original_post;
        $GLOBALS['product'] = $original_product;
        if ($original_post) {
            setup_postdata($original_post);
        } else {
            wp_reset_postdata();
        }
    }
}
