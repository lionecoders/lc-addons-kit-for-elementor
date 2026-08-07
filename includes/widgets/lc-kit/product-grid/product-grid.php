<?php
/**
 * Product Grid Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Product_Grid extends \Elementor\Widget_Base {

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
        return 'lcake-kit-product-grid';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Product Grid', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_style_depends() {
        return ['lcake-kit-product-grid-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Query', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'products_count',
            [
                'label' => esc_html__('Products Count', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 50,
            ]
        );

        $categories = [];
        if (LCAKE_Kit_Utils::is_woo_active()) {
            $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
            if (!is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $categories[$term->slug] = $term->name;
                }
            }
        }

        $this->add_control(
            'category',
            [
                'label' => esc_html__('Category', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $categories,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => esc_html__('Order By', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'lc-addons-kit-for-elementor'),
                    'price' => esc_html__('Price', 'lc-addons-kit-for-elementor'),
                    'popularity' => esc_html__('Popularity', 'lc-addons-kit-for-elementor'),
                    'rand' => esc_html__('Random', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => ['2' => '2', '3' => '3', '4' => '4'],
                'selectors' => ['{{WRAPPER}} .lcake-product-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'],
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
            'grid_gap',
            [
                'label' => esc_html__('Gap', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 60]],
                'default' => ['size' => 24, 'unit' => 'px'],
                'selectors' => ['{{WRAPPER}} .lcake-product-grid' => 'gap: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-product-grid-price' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'title_hover_underline',
            [
                'label' => esc_html__('Title Hover Underline', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                    'underline' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-product-grid-title a:hover' => 'text-decoration: {{VALUE}} !important;',
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

        $args = [
            'post_type' => 'product',
            'posts_per_page' => (int) $settings['products_count'],
            'orderby' => 'price' === $settings['order_by'] ? 'meta_value_num' : $settings['order_by'],
            'meta_key' => 'price' === $settings['order_by'] ? '_price' : '',
            'ignore_sticky_posts' => true,
        ];

        if (!empty($settings['category'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $settings['category'],
                ],
            ];
        }

        $query = new \WP_Query($args);

        if (!$query->have_posts()) {
            return;
        }
        ?>
        <div class="lcake-product-grid">
            <?php while ($query->have_posts()) : $query->the_post();
                global $product;
                if (!$product instanceof \WC_Product) {
                    $product = wc_get_product(get_the_ID());
                }
                if (!$product) {
                    continue;
                }
                ?>
                <div class="lcake-product-grid-card">
                    <a href="<?php the_permalink(); ?>" class="lcake-product-grid-thumb">
                        <?php echo $product->get_image('medium', ['class' => 'lcake-product-grid-image']); ?>
                    </a>
                    <div class="lcake-product-grid-content">
                        <h3 class="lcake-product-grid-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="lcake-product-grid-price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                        <div class="lcake-product-grid-cart">
                            <?php echo do_shortcode('[add_to_cart id="' . $product->get_id() . '" show_price="false"]'); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    }
}
