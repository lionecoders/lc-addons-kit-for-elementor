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
        return esc_html__('NFT Gallery', 'lc-addons-kit-for-elementor');
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
            'section_style_grid',
            [
                'label' => esc_html__('Grid & Media', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'grid_gap',
            [
                'label' => esc_html__('Gap', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 24,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-nft-gallery' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'media_aspect_ratio',
            [
                'label' => esc_html__('Aspect Ratio', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1/1',
                'options' => [
                    '1/1' => esc_html__('1:1 Square', 'lc-addons-kit-for-elementor'),
                    '4/3' => esc_html__('4:3 Standard', 'lc-addons-kit-for-elementor'),
                    '16/9' => esc_html__('16:9 Widescreen', 'lc-addons-kit-for-elementor'),
                    'auto' => esc_html__('Auto (Original)', 'lc-addons-kit-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-nft-card-media' => 'aspect-ratio: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_card',
            [
                'label' => esc_html__('Card', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('card_states');

        $this->start_controls_tab(
            'card_normal',
            [
                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lcake-nft-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .lcake-nft-card',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'card_hover',
            [
                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'card_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-nft-card:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_hover_shadow',
                'selector' => '{{WRAPPER}} .lcake-nft-card:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__('Info Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '16',
                    'bottom' => '16',
                    'left' => '20',
                    'right' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-nft-card-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'right' => '20',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-nft-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-nft-card',
            ]
        );

        $this->add_responsive_control(
            'card_hover_translate',
            [
                'label' => esc_html__('Hover Translate Y (px)', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 6,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-nft-card:hover' => 'transform: translateY(-{{SIZE}}px);',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_name',
            [
                'label' => esc_html__('Name', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .lcake-nft-card-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .lcake-nft-card-name',
            ]
        );

        $this->add_control(
            'heading_price',
            [
                'label' => esc_html__('Price', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-nft-card-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .lcake-nft-card-price',
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
