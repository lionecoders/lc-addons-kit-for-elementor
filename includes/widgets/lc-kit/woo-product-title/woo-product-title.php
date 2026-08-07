<?php
/**
 * WooCommerce Product Title Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Product_Title extends \Elementor\Widget_Base {

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
        return 'lcake-kit-woo-product-title';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Woo Product Title', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-product-title';
    }

    public function get_style_depends() {
        return ['lcake-kit-woo-product-title-css'];
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
            'html_tag',
            [
                'label' => esc_html__('HTML Tag', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h1',
                'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'div' => 'div'],
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
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => ['{{WRAPPER}} .lcake-woo-product-title' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lcake-woo-product-title',
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

        $valid_tags = ['h1', 'h2', 'h3', 'div'];
        $tag = in_array($settings['html_tag'], $valid_tags, true) ? $settings['html_tag'] : 'h1';
        ?>
        <<?php echo $tag; ?> class="lcake-woo-product-title"><?php echo esc_html($product->get_name()); ?></<?php echo $tag; ?>>
        <?php
    }
}
