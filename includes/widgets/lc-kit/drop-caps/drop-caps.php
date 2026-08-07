<?php
/**
 * Drop Caps Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Drop_Caps extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'lcake-kit-drop-caps';
    }

    public function get_style_depends()
    {
        return ['lcake-kit-drop-caps-css'];
    }

    public function get_title()
    {
        return esc_html__('Drop Caps', 'lc-addons-kit-for-elementor');
    }

    public function get_icon()
    {
        return 'eicon-text';
    }

    public function get_categories()
    {
        return ['lcake-page-kit'];
    }

    public function get_keywords()
    {
        return ['drop', 'caps', 'text', 'typography', 'letter', 'initial'];
    }

    protected function register_controls()
    {
        $this->add_content_controls();
        $this->add_style_controls();
    }
    protected function add_content_controls()
    {
        $this->start_controls_section(
            'lc_content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lc_content_text',
            [
                'label' => esc_html__('Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('This is an example of a drop cap paragraph. You can customize the look and feel of the initial letter using the styling controls above, or type your own custom text in this editor. Drop caps are a great way to style the beginning of articles, posts, and sections on your web pages.', 'lc-addons-kit-for-elementor'),
                'placeholder' => esc_html__('Enter your text here...', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lc_content_drop_cap_letter',
            [
                'label' => esc_html__('Drop Cap Letter', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => esc_html__('Enter the letter for drop cap', 'lc-addons-kit-for-elementor'),
                'description' => esc_html__('Enter the letter that should be displayed as a drop cap. If left empty, the first letter of the text will be used.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lc_content_drop_cap_position',
            [
                'label' => esc_html__('Drop Cap Position', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
                    'right' => esc_html__('Right', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls()
    {
        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Text', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lc_style_text_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .lcake-drop-caps-text',
            ]
        );

        $this->add_responsive_control(
            'lc_style_text_alignment',
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
                    'justify' => [
                        'title' => esc_html__('Justified', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lc_style_text_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'lc_section_style_drop_cap',
            [
                'label' => esc_html__('Drop Cap', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lc_style_drop_cap_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-letter' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lc_style_drop_cap_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-letter' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lc_style_drop_cap_size',
            [
                'label' => esc_html__('Size', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-letter' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lc_style_drop_cap_line_height',
            [
                'label' => esc_html__('Line Height', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-letter' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'drop_cap_border',
                'selector' => '{{WRAPPER}} .lcake-drop-caps-letter',
            ]
        );

        $this->add_control(
            'lc_style_drop_cap_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-letter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lc_style_drop_cap_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-letter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lc_style_drop_cap_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-drop-caps-letter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'drop_cap_box_shadow',
                'selector' => '{{WRAPPER}} .lcake-drop-caps-letter',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['lc_content_text'])) {
            return;
        }

        $text = $settings['lc_content_text'];

        // Get drop cap letter
        if (!empty($settings['lc_content_drop_cap_letter'])) {
            $drop_cap_letter = $settings['lc_content_drop_cap_letter'];
        } else {
            $clean_text = trim(strip_tags($text));
            $drop_cap_letter = mb_substr($clean_text, 0, 1, 'UTF-8');
        }

        // Remove ONLY first letter from original text (keep HTML safe)
        if (!empty($drop_cap_letter)) {
            $escaped_letter = preg_quote($drop_cap_letter, '/');
            $text = preg_replace('/(^|>)([^<]*?)' . $escaped_letter . '/u', '$1$2', $text, 1);
        }

        // Wrapper classes
        $this->add_render_attribute('wrapper', 'class', 'lcake-drop-caps-wrapper');

        if (!empty($settings['lc_content_drop_cap_position'])) {
            $this->add_render_attribute(
                'wrapper',
                'class',
                'lcake-drop-caps-position-' . esc_attr($settings['lc_content_drop_cap_position'])
            );
        }

        // Output
        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        echo '<span class="lcake-drop-caps-letter">' . esc_html($drop_cap_letter) . '</span>';
        echo '<div class="lcake-drop-caps-text">' . wp_kses_post($text) . '</div>';
        echo '</div>';
    }


}