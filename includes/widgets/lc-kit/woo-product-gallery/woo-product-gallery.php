<?php
/**
 * WooCommerce Product Gallery Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Product_Gallery extends \Elementor\Widget_Base {

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
        return 'lcake-kit-woo-product-gallery';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Woo Product Gallery', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_style_depends() {
        return ['lcake-kit-woo-product-gallery-css'];
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

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => ['2' => '2', '3' => '3', '4' => '4'],
                'selectors' => ['{{WRAPPER}} .lcake-woo-gallery' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'],
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

        $this->add_responsive_control(
            'gallery_gap',
            [
                'label' => esc_html__('Gap', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 40]],
                'default' => ['size' => 14, 'unit' => 'px'],
                'selectors' => ['{{WRAPPER}} .lcake-woo-gallery' => 'gap: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .lcake-woo-gallery-item',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-gallery-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                    '{{WRAPPER}} .lcake-woo-gallery-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow',
                'selector' => '{{WRAPPER}} .lcake-woo-gallery-item',
            ]
        );

        // --- Normal / Hover Transitions ---
        $this->start_controls_tabs('tabs_gallery_hover', [
            'separator' => 'before',
        ]);

        $this->start_controls_tab(
            'tab_gallery_normal',
            [
                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label' => esc_html__('Opacity', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.05,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-gallery-item img' => 'opacity: {{SIZE}}; transition: all 0.3s ease-in-out;',
                    '{{WRAPPER}} .lcake-woo-gallery-item' => 'transition: all 0.3s ease-in-out;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_gallery_hover',
            [
                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'image_hover_opacity',
            [
                'label' => esc_html__('Hover Opacity', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.05,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-gallery-item:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'image_hover_scale',
            [
                'label' => esc_html__('Hover Scale (Zoom)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.8,
                        'max' => 1.5,
                        'step' => 0.02,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-gallery-item:hover img' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->add_control(
            'image_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-gallery-item:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
        <div class="lcake-woo-gallery">
            <?php foreach ($image_ids as $image_id) :
                $full_url = wp_get_attachment_image_url($image_id, 'full');
                ?>
                <a href="<?php echo esc_url($full_url); ?>" class="lcake-woo-gallery-item" data-elementor-open-lightbox="yes">
                    <?php echo wp_get_attachment_image($image_id, 'medium', false, ['class' => 'lcake-woo-gallery-image']); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
