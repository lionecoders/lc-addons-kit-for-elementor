<?php
/**
 * WooCommerce Product Compare Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Woo_Product_Compare extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-woo-product-compare';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Woo Product Compare', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-woocommerce';
    }

    public function get_style_depends() {
        return ['lcake-kit-woo-product-compare-css'];
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
            'products',
            [
                'label' => esc_html__('Products', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => LCAKE_Kit_Utils::is_woo_active() ? array_slice(LCAKE_Kit_Utils::get_woo_product_options(), 1, null, true) : [],
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
            'header_bg',
            [
                'label' => esc_html__('Header Background', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => ['{{WRAPPER}} .lcake-woo-compare thead th' => 'background-color: {{VALUE}};'],
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
        $product_ids = $settings['products'] ?? [];

        if (empty($product_ids)) {
            return;
        }

        $products = array_filter(array_map('wc_get_product', $product_ids));

        if (empty($products)) {
            return;
        }

        $rows = [
            'image' => esc_html__('Image', 'lc-addons-kit-for-elementor'),
            'price' => esc_html__('Price', 'lc-addons-kit-for-elementor'),
            'rating' => esc_html__('Rating', 'lc-addons-kit-for-elementor'),
            'description' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
            'add_to_cart' => esc_html__('Add To Cart', 'lc-addons-kit-for-elementor'),
        ];
        ?>
        <div class="lcake-woo-compare-wrapper">
            <table class="lcake-woo-compare">
                <thead>
                    <tr>
                        <th></th>
                        <?php foreach ($products as $product) : ?>
                            <th><?php echo esc_html($product->get_name()); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $key => $label) : ?>
                        <tr>
                            <td class="lcake-woo-compare-label"><?php echo esc_html($label); ?></td>
                            <?php foreach ($products as $product) : ?>
                                <td>
                                    <?php switch ($key) :
                                        case 'image': ?>
                                            <?php echo $product->get_image('thumbnail'); ?>
                                            <?php break;
                                        case 'price': ?>
                                            <?php echo wp_kses_post($product->get_price_html()); ?>
                                            <?php break;
                                        case 'rating': ?>
                                            <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                                            <?php break;
                                        case 'description': ?>
                                            <?php echo esc_html(wp_trim_words($product->get_short_description(), 15, '...')); ?>
                                            <?php break;
                                        case 'add_to_cart': ?>
                                            <?php echo do_shortcode('[add_to_cart id="' . $product->get_id() . '" show_price="false"]'); ?>
                                            <?php break;
                                    endswitch; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
