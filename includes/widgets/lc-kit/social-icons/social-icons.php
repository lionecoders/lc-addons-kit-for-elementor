<?php
/**
 * Social Icons Widget
 * 
 * @package LCAKE_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Social_Icons extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-social-icons';
    }

    public function get_title() {
        return esc_html__('LC Social Icons', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-social-icons';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_keywords() {
        return ['social', 'icons', 'facebook', 'twitter', 'instagram', 'linkedin'];
    }

    protected function register_controls() {
        $this->add_content_controls();
        $this->add_style_controls();
    }
    protected function add_content_controls() {
        $this->start_controls_section(
            'lcake_content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        

        $repeater = new \Elementor\Repeater();

        // set social icon
        $repeater->add_control(
            'lcake_socialmedia_icons',
            [
                'label' => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'label_block' => true,
                'default' => [
                    'value' => 'fab fa-facebook-f',
                    'library' => 'fa-brands',
                ],
            ]
        );

        // Add the Link control
        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-addons-kit-for-elementor'),
            ]
        );

        // Add the Title control
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Social Platform', 'lc-addons-kit-for-elementor'),
            ]
        );


        // Add the repeater control itself        
        $this->add_control(
            'lcake_content_social_icons',
            [
                'label' => esc_html__('Social Icons', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'lcake_socialmedia_icons' => [
                            'value' => 'fab fa-facebook-f',
                            'library' => 'fa-brands',
                        ],
                        'link' => [
                            'url' => 'https://facebook.com',
                        ],
                    ],
                    [
                        'lcake_socialmedia_icons' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-brands',
                        ],
                        'link' => [
                            'url' => 'https://twitter.com',
                        ],
                    ],
                    [
                        'lcake_socialmedia_icons' => [
                            'value' => 'fab fa-instagram',
                            'library' => 'fa-brands',
                        ],
                        'link' => [
                            'url' => 'https://instagram.com',
                        ],
                    ],
                ],
                'title_field' => '{{{ title.value }}}', 
            ]
        );


        $this->add_control(
            'lcake_content_layout',
            [
                'label' => esc_html__('Layout', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'lc-addons-kit-for-elementor'),
                    'vertical' => esc_html__('Vertical', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'lcake_content_alignment',
            [
                'label' => esc_html__('Alignment', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icons' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'lc_content_layout' => 'horizontal', 
                ],
            ]
        );



        $this->add_control(
            'lcake_content_show_title',
            [
                'label' => esc_html__('Show Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'lcake_section_style_icons',
            [
                'label' => esc_html__('Icons', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'lcake_style_icon_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-social-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_style_icon_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_style_icon_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_style_icon_color',
            [
                'label' => esc_html__('Icon Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon a svg path' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .lcake-social-icon a i' => 'color: {{VALUE}} !important;',
                ],
            ]
        );



        $this->add_control(
            'icon_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_style_icon_border',
                'selector' => '{{WRAPPER}} .lcake-social-icon',
            ]
        );

        $this->add_control(
            'lcake_style_icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'lcake_section_style_hover',
            [
                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lcake_style_icon_hover_color',
            [
                'label' => esc_html__('Icon Hover Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon:hover a svg path' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .lcake-social-icon:hover a i' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'lcake_title_style_title_hover_color',
            [
                'label' => esc_html__('Title Hover Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon-title:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'lcake_content_show_title' => 'yes',
                ],
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'lcake_title_style_section_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'lcake_content_show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'lcake_title_style_title_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_style_title_typography',
                'selector' => '{{WRAPPER}} .lcake-social-icon-title',
            ]
        );

        $this->add_responsive_control(
            'lcake_style_title_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-social-icon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['lcake_content_social_icons']) || !is_array($settings['lcake_content_social_icons'])) {
            return;
        }

        $layout = !empty($settings['lcake_content_layout']) ? $settings['lcake_content_layout'] : 'horizontal';

        // Wrapper attributes
        $this->add_render_attribute('wrapper', [
            'class' => [
                'lcake-social-icons',
                'lcake-social-icons--' . esc_attr($layout),
            ],
            'role' => 'list',
        ]);

        echo '<ul ' . ($this->get_render_attribute_string('wrapper')) . '>';

        // Allowed URL schemes
        $allowed_schemes = ['http', 'https', 'mailto', 'tel'];

        foreach ((array) $settings['lcake_content_social_icons'] as $icon) {
            $id = !empty($icon['_id']) ? $icon['_id'] : uniqid('lcake_social_', true);

            $link = isset($icon['link']) && is_array($icon['link']) ? $icon['link'] : [];
            $url  = isset($link['url']) ? trim($link['url']) : '';

            if (empty($url)) {
                continue;
            }

            $scheme = wp_parse_url($url, PHP_URL_SCHEME);
            if ($scheme && !in_array(strtolower($scheme), $allowed_schemes, true)) {
                continue;
            }

            // Sanitize URL
            $link['url'] = esc_url_raw($url);

            // Add link attributes
            $this->add_link_attributes('link_' . esc_attr($id), $link);

            // Aria label
            $aria_label = !empty($icon['lcake_title']) ? $icon['lcake_title'] : '';
            if (!empty($aria_label)) {
                $this->add_render_attribute('link_' . esc_attr($id), 'aria-label', esc_attr($aria_label));
            }

            echo '<li class="lcake-social-icon">';
            echo '<a ' . ($this->get_render_attribute_string('link_' . esc_attr($id))) . '>';

            // Icon rendering using Elementor Icons Manager
            if (!empty($icon['lcake_socialmedia_icons']) && is_array($icon['lcake_socialmedia_icons'])) {
                \Elementor\Icons_Manager::render_icon($icon['lcake_socialmedia_icons'], ['aria-hidden' => 'true']);
            }

            // Title (if enabled)
            if (!empty($settings['lcake_content_show_title']) && $settings['lcake_content_show_title'] === 'yes' && !empty($icon['title'])) {
                echo '<span class="lcake-social-icon-title">' . esc_html($icon['title']) . '</span>';
            }

            echo '</a>';
            echo '</li>';
        }

        echo '</ul>';
    }

} 