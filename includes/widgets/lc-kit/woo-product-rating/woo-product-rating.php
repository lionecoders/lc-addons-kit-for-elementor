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
        return 'lcake-kit-woo-product-rating';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Woo Product Rating', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-product-rating';
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

        $this->add_control(
            'review_word_singular',
            [
                'label' => esc_html__('Review Label (Singular)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('review', 'lc-addons-kit-for-elementor'),
                'condition' => [
                    'show_count' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'review_word_plural',
            [
                'label' => esc_html__('Review Label (Plural)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('reviews', 'lc-addons-kit-for-elementor'),
                'condition' => [
                    'show_count' => 'yes',
                ],
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
            'alignment',
            [
                'label' => esc_html__('Alignment', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-product-rating' => 'justify-content: {{VALUE}}; align-items: center;',
                ],
            ]
        );

        $this->add_control(
            'star_color',
            [
                'label' => esc_html__('Star Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#facc15',
                'selectors' => ['{{WRAPPER}} .lcake-woo-product-rating .star-rating span::before' => 'color: {{VALUE}};'],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'star_size',
            [
                'label' => esc_html__('Star Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 40,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-product-rating .star-rating' => 'font-size: {{SIZE}}px; width: calc({{SIZE}}px * 5); height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'star_spacing',
            [
                'label' => esc_html__('Star Gap', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-product-rating .star-rating span::before' => 'letter-spacing: {{SIZE}}px;',
                    '{{WRAPPER}} .lcake-woo-product-rating .star-rating' => 'width: calc(({{SIZE}}px + 15px) * 5);', // estimate width override
                ],
            ]
        );

        // --- Review Count Text Styling ---
        $this->add_control(
            'heading_count_style',
            [
                'label' => esc_html__('Review Count Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_count' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6b7280',
                'selectors' => ['{{WRAPPER}} .lcake-woo-product-rating-count' => 'color: {{VALUE}};'],
                'condition' => [
                    'show_count' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'count_typography',
                'selector' => '{{WRAPPER}} .lcake-woo-product-rating-count',
                'condition' => [
                    'show_count' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'count_gap',
            [
                'label' => esc_html__('Text Spacing', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-woo-product-rating-count' => 'margin-left: {{SIZE}}px;',
                ],
                'condition' => [
                    'show_count' => 'yes',
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

        $count = $product->get_review_count();
        ?>
        <div class="lcake-woo-product-rating" style="display: flex; align-items: center;">
            <?php echo wc_get_rating_html($product->get_average_rating()); ?>
            <?php if ('yes' === $settings['show_count']) : 
                $label_singular = !empty($settings['review_word_singular']) ? $settings['review_word_singular'] : esc_html__('review', 'lc-addons-kit-for-elementor');
                $label_plural = !empty($settings['review_word_plural']) ? $settings['review_word_plural'] : esc_html__('reviews', 'lc-addons-kit-for-elementor');
                $label = (1 === (int) $count) ? $label_singular : $label_plural;
                ?>
                <span class="lcake-woo-product-rating-count">
                    (<?php echo esc_html($count) . ' ' . esc_html($label); ?>)
                </span>
            <?php endif; ?>
        </div>
        <?php
    }
}
