<?php
/**
 * WooCommerce Add To Cart Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Add_To_Cart extends \Elementor\Widget_Base {

    public function get_required_dependencies() {
        return [
            [
                'type' => 'plugin',
                'class' => 'WooCommerce',
                'name' => 'WooCommerce',
            ],
        ];
    }

    public function get_name() {
        return 'lcake-kit-woo-add-to-cart';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Woo Add To Cart', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-product-add-to-cart';
    }

    public function get_style_depends() {
        return ['lcake-kit-woo-add-to-cart-css'];
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
            'button_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .lcake-woo-add-to-cart .button' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-woo-add-to-cart .button' => 'background-color: {{VALUE}};'],
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
        $product = LCAKE_Kit_Utils::get_woo_product((int) $settings['product_id']);

        if (!$product) {
            return;
        }
        ?>
        <div class="lcake-woo-add-to-cart">
            <?php echo do_shortcode('[add_to_cart id="' . $product->get_id() . '" show_price="false"]'); ?>
        </div>
        <?php
    }
}
