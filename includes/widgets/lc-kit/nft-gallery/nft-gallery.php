<?php
/**
 * NFT / Media Gallery Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Nft_Gallery extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-nft-gallery';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC NFT Gallery', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-gallery-masonry';
    }

    public function get_style_depends() {
        return ['lcake-kit-nft-gallery-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Name', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Item #001', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'price',
            [
                'label' => esc_html__('Price', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '0.5 ETH',
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => ['url' => ''],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['name' => 'Item #001', 'price' => '0.5 ETH'],
                    ['name' => 'Item #002', 'price' => '1.2 ETH'],
                    ['name' => 'Item #003', 'price' => '0.8 ETH'],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => ['2' => '2', '3' => '3', '4' => '4'],
                'selectors' => ['{{WRAPPER}} .lcake-nft-gallery' => 'grid-template-columns: repeat({{VALUE}}, 1fr);'],
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
                'selectors' => ['{{WRAPPER}} .lcake-nft-card-price' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $settings['items'] ?? [];

        if (empty($items)) {
            return;
        }
        ?>
        <div class="lcake-nft-gallery">
            <?php foreach ($items as $item) :
                $link = $item['link'] ?? [];
                $tag = !empty($link['url']) ? 'a' : 'div';
                ?>
                <<?php echo $tag; ?> class="lcake-nft-card"
                    <?php if ('a' === $tag) : ?>href="<?php echo esc_url($link['url']); ?>"<?php endif; ?>>
                    <div class="lcake-nft-card-media">
                        <?php echo LCAKE_Kit_Utils::get_attachment_image_html($item, 'image', 'medium', ['class' => 'lcake-nft-card-image']); ?>
                    </div>
                    <div class="lcake-nft-card-info">
                        <?php if (!empty($item['name'])) : ?>
                            <span class="lcake-nft-card-name"><?php echo esc_html($item['name']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($item['price'])) : ?>
                            <span class="lcake-nft-card-price"><?php echo esc_html($item['price']); ?></span>
                        <?php endif; ?>
                    </div>
                </<?php echo $tag; ?>>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
