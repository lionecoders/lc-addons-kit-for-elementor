<?php
/**
 * Icon Box Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Icon_Box extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-icon-box';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('LC Icon Box', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-icon-box';
    }

    public function get_style_depends() {
        return ['lcake-kit-icon-box-css'];
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
            'icon',
            [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Icon Box Title', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-addons-kit-for-elementor'),
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__('Top', 'lc-addons-kit-for-elementor'),
                    'left' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
                    'right' => esc_html__('Right', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );
        
        $this->add_control(
            'title_size',
            [
                'label' => esc_html__('Title HTML Tag', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-icon-box-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6', // modern blue default
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lcake-icon-box-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(59, 130, 246, 0.1)',
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-icon_wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_background_color',
            [
                'label' => esc_html__('Hover Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b82f6',
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-wrapper:hover .lcake-icon-box-icon_wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'selector' => '{{WRAPPER}} .lcake-icon-box-icon_wrapper',
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-icon_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-icon_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lcake-icon-box-title',
            ]
        );
        $this->end_controls_section();

        // Description Style
        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lcake-icon-box-description',
            ]
        );

        $this->end_controls_section();

        // Box Style
        $this->start_controls_section(
            'section_style_box',
            [
                'label' => esc_html__('Box', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_text_align',
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
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .lcake-icon-box-wrapper',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-icon-box-wrapper',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_hover_shadow',
                'label' => esc_html__('Hover Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-icon-box-wrapper:hover',
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-icon-box-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $icon = $settings['icon'] ?? [];
        $title = $settings['title'] ?? '';
        $description = $settings['description'] ?? '';
        $link = $settings['link'] ?? [];
        $icon_position = $settings['icon_position'] ?? 'top';

        $this->add_render_attribute('icon_box', 'class', [
            'lcake-icon-box-wrapper',
            'lcake-icon-box--' . esc_attr($icon_position),
        ]);

        $this->add_render_attribute('icon', 'class', 'lcake-icon-box-icon');
        $this->add_render_attribute('title', 'class', 'lcake-icon-box-title');
        $this->add_render_attribute('description', 'class', 'lcake-icon-box-description');

        ?>
        <div <?php echo $this->get_render_attribute_string('icon_box'); ?>>
            <?php if (!empty($icon['value'])) : ?>
                <div class="lcake-icon-box-icon_wrapper">
                    <div <?php echo $this->get_render_attribute_string('icon'); ?>>
                        <?php \Elementor\Icons_Manager::render_icon($icon, ['aria-hidden' => 'true']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="lcake-icon-box-content">
                <?php if (!empty($title)) : ?>
                    <?php 
                    $title_tag = isset($settings['title_size']) ? $settings['title_size'] : 'h3'; 
                    // validate html tag for security
                    $valid_tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p'];
                    $title_tag = in_array($title_tag, $valid_tags) ? $title_tag : 'h3';
                    ?>
                    
                    <?php if (!empty($link['url'])) : ?>
                        <a href="<?php echo esc_url($link['url']); ?>" class="lcake-icon-box-link"
                           <?php echo !empty($link['is_external']) ? 'target="_blank"' : ''; ?>
                           <?php echo !empty($link['nofollow']) ? 'rel="nofollow"' : ''; ?>>
                            <<?php echo $title_tag; ?> <?php echo $this->get_render_attribute_string('title'); ?>>
                                <?php echo wp_kses_post($title); ?>
                            </<?php echo $title_tag; ?>>
                        </a>
                    <?php else : ?>
                        <<?php echo $title_tag; ?> <?php echo $this->get_render_attribute_string('title'); ?>>
                            <?php echo wp_kses_post($title); ?>
                        </<?php echo $title_tag; ?>>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!empty($description)) : ?>
                    <div <?php echo $this->get_render_attribute_string('description'); ?>>
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}