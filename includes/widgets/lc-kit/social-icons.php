<?php
/**
 * Social Icons Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Social_Icons extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-social-icons';
    }

    public function get_title() {
        return esc_html__('Social Icons', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-social-icons';
    }

    public function get_categories() {
        return ['lc-page-kit'];
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
            'lc_content_section',
            [
                'label' => esc_html__('Content', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        

        $repeater = new \Elementor\Repeater();

        // set social icon
        $repeater->add_control(
            'lc_socialmedia_icons',
            [
                'label' => esc_html__( 'Icon', 'lc-elementor-addons-kit' ),
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
                'label' => esc_html__('Link', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-elementor-addons-kit'),
            ]
        );

        // Add the Title control
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Social Platform', 'lc-elementor-addons-kit'),
            ]
        );


        // Add the repeater control itself        
        $this->add_control(
            'lc_content_social_icons',
            [
                'label' => esc_html__('Social Icons', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'lc_socialmedia_icons' => [
                            'value' => 'fab fa-facebook-f',
                            'library' => 'fa-brands',
                        ],
                        'link' => [
                            'url' => 'https://facebook.com',
                        ],
                    ],
                    [
                        'lc_socialmedia_icons' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-brands',
                        ],
                        'link' => [
                            'url' => 'https://twitter.com',
                        ],
                    ],
                    [
                        'lc_socialmedia_icons' => [
                            'value' => 'fab fa-instagram',
                            'library' => 'fa-brands',
                        ],
                        'link' => [
                            'url' => 'https://instagram.com',
                        ],
                    ],
                ],
                'title_field' => '{{{ lc_socialmedia_icons.value }}}', 
            ]
        );


        $this->add_control(
            'lc_content_layout',
            [
                'label' => esc_html__('Layout', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'lc-elementor-addons-kit'),
                    'vertical' => esc_html__('Vertical', 'lc-elementor-addons-kit'),
                ],
            ]
        );

        $this->add_control(
            'lc_content_alignment',
            [
                'label' => esc_html__('Alignment', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'lc-elementor-addons-kit'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'lc-elementor-addons-kit'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'lc-elementor-addons-kit'),
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
            'lc_content_show_title',
            [
                'label' => esc_html__('Show Title', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'lc_section_style_icons',
            [
                'label' => esc_html__('Icons', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'lc_style_icon_size',
            [
                'label' => esc_html__('Size', 'lc-elementor-addons-kit'),
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
                    '{{WRAPPER}} .lc-social-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lc-social-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lc_style_icon_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
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
                    '{{WRAPPER}} .lc-social-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lc_style_icon_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lc_style_icon_color',
            [
                'label' => esc_html__('Icon Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icon a' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'icon_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lc_style_icon_border',
                'selector' => '{{WRAPPER}} .lc-social-icon',
            ]
        );

        $this->add_control(
            'lc_style_icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'lc_section_style_hover',
            [
                'label' => esc_html__('Hover', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lc_style_icon_hover_color',
            [
                'label' => esc_html__('Hover Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icon a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icon:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icon:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'lc_title_style_section_title',
            [
                'label' => esc_html__('Title', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'lc_content_show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'lc_title_style_title_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icon-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lc_style_title_typography',
                'selector' => '{{WRAPPER}} .lc-social-icon-title',
            ]
        );

        $this->add_responsive_control(
            'lc_style_title_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-social-icon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['lc_content_social_icons']) || !is_array($settings['lc_content_social_icons'])) {
            return;
        }

        $layout = !empty($settings['lc_content_layout']) ? $settings['lc_content_layout'] : 'horizontal';

        // Wrapper attributes
        $this->add_render_attribute('wrapper', [
            'class' => [
                'lc-social-icons',
                'lc-social-icons--' . esc_attr($layout),
            ],
            'role' => 'list',
        ]);

        echo '<ul ' . $this->get_render_attribute_string('wrapper') . '>';

        // Allowed URL schemes
        $allowed_schemes = ['http', 'https', 'mailto', 'tel'];

        foreach ((array) $settings['lc_content_social_icons'] as $icon) {
            $id = !empty($icon['_id']) ? $icon['_id'] : uniqid('lc_social_', true);

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
            $this->add_link_attributes('link_' . $id, $link);

            // Aria label
            $aria_label = !empty($icon['title']) ? $icon['title'] : '';
            if (!empty($aria_label)) {
                $this->add_render_attribute('link_' . $id, 'aria-label', esc_attr($aria_label));
            }

            echo '<li class="lc-social-icon">';
            echo '<a ' . $this->get_render_attribute_string('link_' . $id) . '>';

            // Icon rendering using Elementor Icons Manager
            if (!empty($icon['lc_socialmedia_icons']) && is_array($icon['lc_socialmedia_icons'])) {
                \Elementor\Icons_Manager::render_icon($icon['lc_socialmedia_icons'], ['aria-hidden' => 'true']);
            }

            // Title (if enabled)
            if (!empty($settings['lc_content_show_title']) && $settings['lc_content_show_title'] === 'yes' && !empty($icon['title'])) {
                echo '<span class="lc-social-icon-title">' . esc_html($icon['title']) . '</span>';
            }

            echo '</a>';
            echo '</li>';
        }

        echo '</ul>';
    }

} 