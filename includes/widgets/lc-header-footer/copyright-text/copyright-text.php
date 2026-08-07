<?php
/**
 * Copyright Text Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Header_Footer_Copyright_Text extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-header-footer-copyright-text';
    }

    public function get_title() {
        return esc_html__('Copyright Text', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-text';
    }

    public function get_categories() {
        return ['lc-header-footer-kit1'];
    }

    public function get_style_depends() {
        return ['lc-header-footer-copyright-text-css'];
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
            'text',
            [
                'label' => esc_html__('Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('© {year} {site_name}. All rights reserved.', 'lc-addons-kit-for-elementor'),
                'description' => esc_html__('Use {year} and {site_name} as dynamic placeholders.', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'lc-addons-kit-for-elementor'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'lc-addons-kit-for-elementor'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => esc_html__('Right', 'lc-addons-kit-for-elementor'), 'icon' => 'eicon-text-align-right'],
                ],
                'default' => 'center',
                'selectors' => ['{{WRAPPER}} .lc-hf-copyright' => 'text-align: {{VALUE}};'],
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
            'text_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9ca3af',
                'selectors' => ['{{WRAPPER}} .lc-hf-copyright' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .lc-hf-copyright' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .lc-hf-copyright',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $text = $settings['text'] ?? '';

        if ('' === trim($text)) {
            return;
        }

        $replacements = [
            '{year}' => gmdate('Y'),
            '{site_name}' => get_bloginfo('name'),
        ];
        $text = strtr($text, $replacements);
        ?>
        <p class="lc-hf-copyright"><?php echo wp_kses_post($text); ?></p>
        <?php
    }
}
