<?php
/**
 * Heading Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Heading extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-heading';
    }

    public function get_style_depends() {
        return ['lcake-kit-heading-css'];
    }

    public function get_title() {
        return esc_html__('Heading', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-t-letter';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_keywords() {
        return ['heading', 'text', 'title', 'modern'];
    }

    protected function register_controls() {
        // CONTENT TAB
        $this->start_controls_section(
            'lcake_section_content',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lcake_heading_text',
            [
                'label' => esc_html__('Heading Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Build Beautiful Experiences', 'lc-addons-kit-for-elementor'),
                'placeholder' => esc_html__('Enter your heading', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lcake_heading_tag',
            [
                'label' => esc_html__('HTML Tag', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
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
            ]
        );

        $this->add_responsive_control(
            'lcake_heading_alignment',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .lcake-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // STYLE TAB
        $this->start_controls_section(
            'lcake_section_style',
            [
                'label' => esc_html__('Heading Style', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lcake_heading_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .lcake-heading .lcake-heading-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_heading_gradient_effect',
            [
                'label' => esc_html__('Enable Gradient Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'lcake_heading_gradient_color_left',
            [
                'label' => esc_html__('Gradient Left Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4f46e5',
                'condition' => [
                    'lcake_heading_gradient_effect' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'lcake_heading_gradient_color_right',
            [
                'label' => esc_html__('Gradient Right Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ec4899',
                'condition' => [
                    'lcake_heading_gradient_effect' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-heading .lcake-heading-title.lcake-heading-gradient' => 'background: linear-gradient(to right, {{lcake_heading_gradient_color_left.VALUE}}, {{VALUE}}); -webkit-background-clip: text; -webkit-text-fill-color: transparent;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_heading_typography',
                'selector' => '{{WRAPPER}} .lcake-heading .lcake-heading-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'lcake_heading_text_shadow',
                'selector' => '{{WRAPPER}} .lcake-heading .lcake-heading-title',
            ]
        );

        $this->add_responsive_control(
            'lcake_heading_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $heading_text = $settings['lcake_heading_text'];
        $heading_tag  = !empty($settings['lcake_heading_tag']) ? $settings['lcake_heading_tag'] : 'h2';
        
        if (empty($heading_text)) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lcake-heading');
        
        $title_classes = ['lcake-heading-title'];
        if ($settings['lcake_heading_gradient_effect'] === 'yes') {
            $title_classes[] = 'lcake-heading-gradient';
        }
        $this->add_render_attribute('title', 'class', $title_classes);

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
            echo '<' . tag_escape($heading_tag) . ' ' . $this->get_render_attribute_string('title') . '>';
                echo wp_kses_post($heading_text);
            echo '</' . tag_escape($heading_tag) . '>';
        echo '</div>';
    }

    protected function content_template() {
        ?>
        <#
        var heading_tag = settings.lcake_heading_tag ? settings.lcake_heading_tag : 'h2';
        var title_class = 'lcake-heading-title';
        if (settings.lcake_heading_gradient_effect === 'yes') {
            title_class += ' lcake-heading-gradient';
        }
        #>
        <div class="lcake-heading">
            <{{{ heading_tag }}} class="{{ title_class }}">
                {{{ settings.lcake_heading_text }}}
            </{{{ heading_tag }}}>
        </div>
        <?php
    }
} 