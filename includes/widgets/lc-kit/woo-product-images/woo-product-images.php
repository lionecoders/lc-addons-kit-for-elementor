<?php
/**
 * WooCommerce Product Images Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Product_Images extends \Elementor\Widget_Base {

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
        return 'lcake-kit-woo-product-images';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Woo Product Images', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-product-images';
    }

    public function get_style_depends() {
        return ['lcake-kit-woo-product-images-css'];
    }

    public function get_script_depends() {
        return ['lcake-kit-woo-product-images-js'];
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

        // --- Style Tab ---
        $this->start_controls_section(
            'section_style_main_image',
            [
                'label' => esc_html__('Main Image', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'main_image_spacing',
            [
                'label' => esc_html__('Thumbnail Spacing', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-images-main' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'main_image_border',
                'selector' => '{{WRAPPER}} .lcake-woo-images-main',
            ]
        );

        $this->add_control(
            'main_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-images-main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                    '{{WRAPPER}} .lcake-woo-images-main-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'main_image_shadow',
                'selector' => '{{WRAPPER}} .lcake-woo-images-main',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_thumbnails',
            [
                'label' => esc_html__('Thumbnails', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'thumb_spacing',
            [
                'label' => esc_html__('Gap Between Thumbnails', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-images-thumbs' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'thumb_border',
                'selector' => '{{WRAPPER}} .lcake-woo-images-thumb',
            ]
        );

        $this->add_control(
            'thumb_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-images-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                    '{{WRAPPER}} .lcake-woo-images-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'thumb_active_border_color',
            [
                'label' => esc_html__('Active Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-images-thumb.is-active' => 'border-color: {{VALUE}} !important;',
                ],
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

        $image_ids = array_filter(array_merge([$product->get_image_id()], $product->get_gallery_image_ids()));

        if (empty($image_ids)) {
            return;
        }
        ?>
        <div class="lcake-woo-images">
            <div class="lcake-woo-images-main">
                <?php foreach ($image_ids as $index => $image_id) : ?>
                    <img src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'large')); ?>"
                         class="lcake-woo-images-main-image<?php echo 0 === $index ? ' is-active' : ''; ?>"
                         alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', true)); ?>">
                <?php endforeach; ?>
            </div>
            <?php if (count($image_ids) > 1) : ?>
                <div class="lcake-woo-images-thumbs">
                    <?php foreach ($image_ids as $index => $image_id) : ?>
                        <button type="button" class="lcake-woo-images-thumb<?php echo 0 === $index ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr($index); ?>">
                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
