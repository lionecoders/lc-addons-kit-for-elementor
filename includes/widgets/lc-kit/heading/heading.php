<?php
/**
 * Heading Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Heading Widget Class
 */
class LC_Kit_Heading extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'lc-kit-heading';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['lc-page-kit'];
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('Heading', 'lc-elementor-addons-kit');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-heading';
    }

    /**
     * Add content controls
     */
    protected function add_content_controls() {
        $this->add_control(
            'heading_text',
            [
                'label' => esc_html__('Heading Text', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Enter your heading', 'lc-elementor-addons-kit'),
                'placeholder' => esc_html__('Enter your heading', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label' => esc_html__('HTML Tag', 'lc-elementor-addons-kit'),
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

        $this->add_control(
            'heading_alignment',
            [
                'label' => esc_html__('Alignment', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'lc-elementor-addons-kit'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'lc-elementor-addons-kit'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'lc-elementor-addons-kit'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );
    }

    /**
     * Add style controls
     */
    protected function add_style_controls() {
        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .lc-kit-heading',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'heading_text_shadow',
                'selector' => '{{WRAPPER}} .lc-kit-heading',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-kit-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    /**
     * Render widget
     */
    protected function render_widget($settings) {
        $heading_text = $settings['heading_text'];
        $heading_tag = $settings['heading_tag'];

        if (empty($heading_text)) {
            return;
        }

        $this->add_render_attribute('heading', 'class', 'lc-kit-heading');

        echo sprintf(
            '<%1$s %2$s>%3$s</%1$s>',
            tag_escape($heading_tag),
            $this->get_render_attribute_string('heading'),
            esc_html($heading_text)
        );
    }

    /**
     * Content template
     */
    protected function content_template() {
        ?>
        <{{ settings.heading_tag }} class="lc-kit-heading">
            {{{ settings.heading_text }}}
        </{{ settings.heading_tag }}>
        <?php
    }
} 