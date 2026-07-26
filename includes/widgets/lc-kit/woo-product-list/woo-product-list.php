<?php
/**
 * WooCommerce Product List Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Product_List extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-woo-product-list';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Woo Product List', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-woocommerce';
    }

    public function get_style_depends() {
        return ['lcake-kit-woo-product-list-css'];
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
                'default' => 5,
                'min' => 1,
                'max' => 50,
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
                    'popularity' => esc_html__('Popularity', 'lc-addons-kit-for-elementor'),
                    'rand' => esc_html__('Random', 'lc-addons-kit-for-elementor'),
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

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-woo-list-price' => 'color: {{VALUE}};'],
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

        $query = new \WP_Query([
            'post_type' => 'product',
            'posts_per_page' => (int) $settings['products_count'],
            'orderby' => $settings['order_by'],
            'ignore_sticky_posts' => true,
        ]);

        if (!$query->have_posts()) {
            return;
        }
        ?>
        <div class="lcake-woo-list">
            <?php while ($query->have_posts()) : $query->the_post();
                global $product;
                if (!$product instanceof \WC_Product) {
                    $product = wc_get_product(get_the_ID());
                }
                if (!$product) {
                    continue;
                }
                ?>
                <div class="lcake-woo-list-item">
                    <a href="<?php the_permalink(); ?>" class="lcake-woo-list-thumb">
                        <?php echo $product->get_image('thumbnail', ['class' => 'lcake-woo-list-image']); ?>
                    </a>
                    <div class="lcake-woo-list-content">
                        <h3 class="lcake-woo-list-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="lcake-woo-list-rating"><?php echo wc_get_rating_html($product->get_average_rating()); ?></div>
                        <div class="lcake-woo-list-price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                    </div>
                    <div class="lcake-woo-list-cart">
                        <?php echo do_shortcode('[add_to_cart id="' . $product->get_id() . '" show_price="false"]'); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    }
}
