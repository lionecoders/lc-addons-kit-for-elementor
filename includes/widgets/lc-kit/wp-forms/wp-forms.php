<?php
/**
 * WPForms Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Wp_Forms extends \Elementor\Widget_Base {

    public function get_required_dependencies() {
        return [
            [
                'type' => 'plugin',
                'function' => 'wpforms',
                'name' => 'WPForms',
            ],
        ];
    }

    public function get_name() {
        return 'lcake-kit-wp-forms';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('WPForms', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_style_depends() {
        return ['lcake-kit-wp-forms-css'];
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
                'options' => LCAKE_Kit_Utils::lcake_get_wpforms(),
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

        $this->end_controls_section();

        // --- Container Styles ---
        $this->start_controls_section(
            'section_style_form',
            [
                'label' => esc_html__('Form Container', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'form_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'selector' => '{{WRAPPER}} .lcake-wp-forms',
            ]
        );

        $this->add_control(
            'form_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Title Styles ---
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
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lcake-wp-forms .wpforms-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Labels Styles ---
        $this->start_controls_section(
            'section_style_labels',
            [
                'label' => esc_html__('Labels', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-field-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .lcake-wp-forms .wpforms-field-label',
            ]
        );

        $this->add_responsive_control(
            'label_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-field-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Input Fields Styles ---
        $this->start_controls_section(
            'section_style_inputs',
            [
                'label' => esc_html__('Input Fields', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="text"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="email"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="tel"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="url"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="number"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form textarea,
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form select' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="text"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="email"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="tel"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="url"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="number"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form textarea,
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form select' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="text"],
                               {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="email"],
                               {{WRAPPER}} .lcake-wp-forms .wpforms-form textarea,
                               {{WRAPPER}} .lcake-wp-forms .wpforms-form select',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'input_border',
                'selector' => '{{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="text"],
                               {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="email"],
                               {{WRAPPER}} .lcake-wp-forms .wpforms-form textarea,
                               {{WRAPPER}} .lcake-wp-forms .wpforms-form select',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="text"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="email"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form textarea,
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="text"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form input[type="email"],
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form textarea,
                     {{WRAPPER}} .lcake-wp-forms .wpforms-form select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Submit Button Styles ---
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Submit Button', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-submit' => 'background-color: {{VALUE}}; transition: all 0.3s ease-in-out;',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-submit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-submit:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-submit:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_hover_color',
            [
                'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-submit:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .lcake-wp-forms .wpforms-submit',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .lcake-wp-forms .wpforms-submit',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-wp-forms .wpforms-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!function_exists('wpforms')) {
            LCAKE_Kit_Utils::plugin_inactive_notice('WPForms');
            return;
        }

        $settings = $this->get_settings_for_display();

        if (empty($settings['form_id'])) {
            return;
        }
        ?>
        <div class="lcake-wp-forms">
            <?php echo do_shortcode(sprintf(
                '[wpforms id="%d" title="%s"]',
                (int) $settings['form_id'],
                'yes' === $settings['show_title'] ? 'true' : 'false'
            )); ?>
        </div>
        <?php
    }
}
