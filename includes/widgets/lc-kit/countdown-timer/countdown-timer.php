<?php
/**
 * Countdown Timer Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LC_Kit_Countdown_Timer extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lc-kit-countdown-timer';
    }

    public function get_title() {
        return esc_html__('Countdown Timer', 'lc-elementor-addons-kit');
    }

    public function get_icon() {
        return 'eicon-countdown';
    }

    public function get_categories() {
        return ['lc-page-kit'];
    }

    public function get_keywords() {
        return ['countdown', 'timer', 'clock', 'time', 'deadline'];
    }

    public function get_script_depends() {
        return ['lc-countdown-timer'];
    }

    protected function add_content_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'due_date',
            [
                'label' => esc_html__('Due Date', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'enableTime' => true,
                    'dateFormat' => 'Y-m-d H:i',
                ],
                'default' => date('Y-m-d H:i', strtotime('+1 month')),
            ]
        );

        $this->add_control(
            'label_days',
            [
                'label' => esc_html__('Days Label', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Days', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'label_hours',
            [
                'label' => esc_html__('Hours Label', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Hours', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'label_minutes',
            [
                'label' => esc_html__('Minutes Label', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Minutes', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'label_seconds',
            [
                'label' => esc_html__('Seconds Label', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Seconds', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'show_days',
            [
                'label' => esc_html__('Show Days', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_hours',
            [
                'label' => esc_html__('Show Hours', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_minutes',
            [
                'label' => esc_html__('Show Minutes', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_seconds',
            [
                'label' => esc_html__('Show Seconds', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'lc-elementor-addons-kit'),
                'label_off' => esc_html__('Hide', 'lc-elementor-addons-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'expire_message',
            [
                'label' => esc_html__('Expire Message', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Time is up!', 'lc-elementor-addons-kit'),
                'description' => esc_html__('Message to display when countdown expires', 'lc-elementor-addons-kit'),
            ]
        );

        $this->add_control(
            'redirect_url',
            [
                'label' => esc_html__('Redirect URL', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'lc-elementor-addons-kit'),
                'description' => esc_html__('URL to redirect to when countdown expires (optional)', 'lc-elementor-addons-kit'),
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'section_style_countdown',
            [
                'label' => esc_html__('Countdown', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'countdown_alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .lc-countdown-timer' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'countdown_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-countdown-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'countdown_border',
                'selector' => '{{WRAPPER}} .lc-countdown-item',
            ]
        );

        $this->add_control(
            'countdown_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'countdown_padding',
            [
                'label' => esc_html__('Padding', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'countdown_margin',
            [
                'label' => esc_html__('Margin', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lc-countdown-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_numbers',
            [
                'label' => esc_html__('Numbers', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'numbers_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-countdown-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'numbers_typography',
                'selector' => '{{WRAPPER}} .lc-countdown-number',
            ]
        );

        $this->add_responsive_control(
            'numbers_bottom_space',
            [
                'label' => esc_html__('Spacing', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lc-countdown-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_labels',
            [
                'label' => esc_html__('Labels', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'labels_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-countdown-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'labels_typography',
                'selector' => '{{WRAPPER}} .lc-countdown-label',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_expire_message',
            [
                'label' => esc_html__('Expire Message', 'lc-elementor-addons-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'expire_message_color',
            [
                'label' => esc_html__('Color', 'lc-elementor-addons-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lc-countdown-expire' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'expire_message_typography',
                'selector' => '{{WRAPPER}} .lc-countdown-expire',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['due_date'])) {
            return;
        }

        $due_date = strtotime($settings['due_date']);
        if (!$due_date) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lc-countdown-timer');
        $this->add_render_attribute('wrapper', 'data-due-date', $due_date);
        $this->add_render_attribute('wrapper', 'data-expire-message', $settings['expire_message']);
        
        if (!empty($settings['redirect_url']['url'])) {
            $this->add_render_attribute('wrapper', 'data-redirect-url', $settings['redirect_url']['url']);
        }

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        
        if ($settings['show_days'] === 'yes') {
            echo '<div class="lc-countdown-item lc-countdown-days">';
            echo '<div class="lc-countdown-number" data-days>00</div>';
            echo '<div class="lc-countdown-label">' . esc_html($settings['label_days']) . '</div>';
            echo '</div>';
        }

        if ($settings['show_hours'] === 'yes') {
            echo '<div class="lc-countdown-item lc-countdown-hours">';
            echo '<div class="lc-countdown-number" data-hours>00</div>';
            echo '<div class="lc-countdown-label">' . esc_html($settings['label_hours']) . '</div>';
            echo '</div>';
        }

        if ($settings['show_minutes'] === 'yes') {
            echo '<div class="lc-countdown-item lc-countdown-minutes">';
            echo '<div class="lc-countdown-number" data-minutes>00</div>';
            echo '<div class="lc-countdown-label">' . esc_html($settings['label_minutes']) . '</div>';
            echo '</div>';
        }

        if ($settings['show_seconds'] === 'yes') {
            echo '<div class="lc-countdown-item lc-countdown-seconds">';
            echo '<div class="lc-countdown-number" data-seconds>00</div>';
            echo '<div class="lc-countdown-label">' . esc_html($settings['label_seconds']) . '</div>';
            echo '</div>';
        }

        echo '<div class="lc-countdown-expire" style="display: none;">' . esc_html($settings['expire_message']) . '</div>';
        
        echo '</div>';
    }

    protected function content_template() {
        ?>
        <# if (settings.due_date) { #>
            <div class="lc-countdown-timer" data-due-date="{{ settings.due_date }}" data-expire-message="{{ settings.expire_message }}"<# if (settings.redirect_url.url) { #> data-redirect-url="{{ settings.redirect_url.url }}"<# } #>>
                <# if (settings.show_days === 'yes') { #>
                    <div class="lc-countdown-item lc-countdown-days">
                        <div class="lc-countdown-number" data-days>00</div>
                        <div class="lc-countdown-label">{{{ settings.label_days }}}</div>
                    </div>
                <# } #>
                <# if (settings.show_hours === 'yes') { #>
                    <div class="lc-countdown-item lc-countdown-hours">
                        <div class="lc-countdown-number" data-hours>00</div>
                        <div class="lc-countdown-label">{{{ settings.label_hours }}}</div>
                    </div>
                <# } #>
                <# if (settings.show_minutes === 'yes') { #>
                    <div class="lc-countdown-item lc-countdown-minutes">
                        <div class="lc-countdown-number" data-minutes>00</div>
                        <div class="lc-countdown-label">{{{ settings.label_minutes }}}</div>
                    </div>
                <# } #>
                <# if (settings.show_seconds === 'yes') { #>
                    <div class="lc-countdown-item lc-countdown-seconds">
                        <div class="lc-countdown-number" data-seconds>00</div>
                        <div class="lc-countdown-label">{{{ settings.label_seconds }}}</div>
                    </div>
                <# } #>
                <div class="lc-countdown-expire" style="display: none;">{{{ settings.expire_message }}}</div>
            </div>
        <# } #>
        <?php
    }
} 