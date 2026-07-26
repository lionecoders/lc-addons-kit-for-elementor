<?php
/**
 * WooCommerce Product Rating Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Product_Rating extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-woo-product-rating';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Woo Product Rating', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-woocommerce';
    }

    public function get_style_depends() {
        return ['lcake-kit-woo-product-rating-css'];
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

        $this->add_control(
            'show_count',
            [
                'label' => esc_html__('Show Review Count', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
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
            'star_color',
            [
                'label' => esc_html__('Star Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#facc15',
                'selectors' => ['{{WRAPPER}} .lcake-woo-product-rating .star-rating span::before' => 'color: {{VALUE}};'],
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

        $count = $product->get_review_count();
        ?>
        <div class="lcake-woo-product-rating">
            <?php echo wc_get_rating_html($product->get_average_rating()); ?>
            <?php if ('yes' === $settings['show_count']) : ?>
                <span class="lcake-woo-product-rating-count">
                    (<?php echo esc_html($count); ?> <?php echo esc_html(_n('review', 'reviews', $count, 'lc-addons-kit-for-elementor')); ?>)
                </span>
            <?php endif; ?>
        </div>
        <?php
    }
}
