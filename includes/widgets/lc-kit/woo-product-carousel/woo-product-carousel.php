<?php
/**
 * WooCommerce Product Carousel Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Product_Carousel extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-woo-product-carousel';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Woo Product Carousel', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-woocommerce';
    }

    public function get_style_depends() {
        return ['lcake-swiper-css', 'lcake-kit-woo-product-carousel-css'];
    }

    public function get_script_depends() {
        return ['lcake-swiper-js', 'lcake-kit-woo-product-carousel-js'];
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
                'default' => 8,
                'min' => 1,
                'max' => 50,
            ]
        );

        $this->add_responsive_control(
            'slides_per_view',
            [
                'label' => esc_html__('Slides Per View', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 4,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'min' => 1,
                'max' => 6,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'lc-addons-kit-for-elementor'),
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
            'price_color',
            [
                'label' => esc_html__('Price Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-woo-carousel-price' => 'color: {{VALUE}};'],
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
            'ignore_sticky_posts' => true,
        ]);

        if (!$query->have_posts()) {
            return;
        }

        $config = [
            'slidesPerView' => (int) ($settings['slides_per_view'] ?? 4),
            'slidesPerViewTablet' => (int) ($settings['slides_per_view_tablet'] ?? 2),
            'slidesPerViewMobile' => (int) ($settings['slides_per_view_mobile'] ?? 1),
            'autoplay' => 'yes' === $settings['autoplay'],
            'loop' => 'yes' === $settings['loop'],
        ];
        ?>
        <div class="lcake-woo-carousel-wrapper">
            <div class="lcake-woo-carousel swiper" data-config="<?php echo esc_attr(wp_json_encode($config)); ?>">
                <div class="swiper-wrapper">
                    <?php while ($query->have_posts()) : $query->the_post();
                        global $product;
                        if (!$product instanceof \WC_Product) {
                            $product = wc_get_product(get_the_ID());
                        }
                        if (!$product) {
                            continue;
                        }
                        ?>
                        <div class="swiper-slide">
                            <div class="lcake-woo-carousel-card">
                                <a href="<?php the_permalink(); ?>" class="lcake-woo-carousel-thumb">
                                    <?php echo $product->get_image('medium', ['class' => 'lcake-woo-carousel-image']); ?>
                                </a>
                                <div class="lcake-woo-carousel-content">
                                    <h3 class="lcake-woo-carousel-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="lcake-woo-carousel-price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="lcake-woo-carousel-nav lcake-woo-carousel-prev">&#10094;</div>
            <div class="lcake-woo-carousel-nav lcake-woo-carousel-next">&#10095;</div>
        </div>
        <?php
        wp_reset_postdata();
    }
}
