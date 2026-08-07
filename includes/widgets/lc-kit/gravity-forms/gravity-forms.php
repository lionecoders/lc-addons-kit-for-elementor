<?php
/**
 * Gravity Forms Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Gravity_Forms extends \Elementor\Widget_Base {

    public function get_required_dependencies() {
        return [
            [
                'type' => 'plugin',
                'class' => 'GFForms',
                'name' => 'Gravity Forms',
            ],
        ];
    }

    public function get_name() {
        return 'lcake-kit-gravity-forms';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Gravity Forms', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_style_depends() {
        return ['lcake-kit-gravity-forms-css'];
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
            'form_id',
            [
                'label' => esc_html__('Select Form', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => LCAKE_Kit_Utils::lcake_get_gravity_forms(),
                'default' => 0,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Form Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'show_description',
            [
                'label' => esc_html__('Show Form Description', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gform_wrapper .gform_heading .gform_title, {{WRAPPER}} .gform_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .gform_wrapper .gform_heading .gform_title, {{WRAPPER}} .gform_title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gform_wrapper .gform_heading .gform_title, {{WRAPPER}} .gform_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gform_wrapper .gform_heading .gform_description, {{WRAPPER}} .gform_description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .gform_wrapper .gform_heading .gform_description, {{WRAPPER}} .gform_description',
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .gform_wrapper .gform_heading .gform_description, {{WRAPPER}} .gform_description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!class_exists('GFForms')) {
            LCAKE_Kit_Utils::plugin_inactive_notice('Gravity Forms');
            return;
        }

        $settings = $this->get_settings_for_display();

        if (empty($settings['form_id'])) {
            return;
        }

        if (function_exists('gravity_form_enqueue_scripts')) {
            gravity_form_enqueue_scripts((int) $settings['form_id'], true);
        }
        ?>
        <div class="lcake-gravity-forms">
            <?php echo do_shortcode(sprintf(
                '[gravityform id="%d" title="%s" description="%s" ajax="true"]',
                (int) $settings['form_id'],
                'yes' === $settings['show_title'] ? 'true' : 'false',
                'yes' === $settings['show_description'] ? 'true' : 'false'
            )); ?>
        </div>
        <?php
    }
}
