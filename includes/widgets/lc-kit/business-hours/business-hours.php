<?php
/**
 * Business Hours Widget
 * 
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Business_Hours extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-business-hours';
    }

    public function get_title() {
        return esc_html__('Business Hours', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-clock-o';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_keywords() {
        return ['business', 'hours', 'time', 'schedule', 'opening', 'closing'];
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

        $this->add_control(
            'lcake_content_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Business Hours', 'lc-addons-kit-for-elementor'),
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'day',
            [
                'label' => esc_html__('Day', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'monday',
                'options' => [
                    'monday' => esc_html__('Monday', 'lc-addons-kit-for-elementor'),
                    'tuesday' => esc_html__('Tuesday', 'lc-addons-kit-for-elementor'),
                    'wednesday' => esc_html__('Wednesday', 'lc-addons-kit-for-elementor'),
                    'thursday' => esc_html__('Thursday', 'lc-addons-kit-for-elementor'),
                    'friday' => esc_html__('Friday', 'lc-addons-kit-for-elementor'),
                    'saturday' => esc_html__('Saturday', 'lc-addons-kit-for-elementor'),
                    'sunday' => esc_html__('Sunday', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $repeater->add_control(
            'open_time',
            [
                'label' => esc_html__('Opening Time', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '09:00',
                'placeholder' => esc_html__('09:00', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'close_time',
            [
                'label' => esc_html__('Closing Time', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '18:00',
                'placeholder' => esc_html__('18:00', 'lc-addons-kit-for-elementor'),
            ]
        );

        $repeater->add_control(
            'closed',
            [
                'label' => esc_html__('Closed', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $repeater->add_control(
            'closed_text',
            [
                'label' => esc_html__('Closed Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Closed', 'lc-addons-kit-for-elementor'),
                'condition' => [
                    'closed' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'lcake_content_business_hours',
            [
                'label' => esc_html__('Business Hours', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'day' => 'monday',
                        'open_time' => '09:00',
                        'close_time' => '18:00',
                    ],
                    [
                        'day' => 'tuesday',
                        'open_time' => '09:00',
                        'close_time' => '18:00',
                    ],
                    [
                        'day' => 'wednesday',
                        'open_time' => '09:00',
                        'close_time' => '18:00',
                    ],
                    [
                        'day' => 'thursday',
                        'open_time' => '09:00',
                        'close_time' => '18:00',
                    ],
                    [
                        'day' => 'friday',
                        'open_time' => '09:00',
                        'close_time' => '18:00',
                    ],
                    [
                        'day' => 'saturday',
                        'open_time' => '10:00',
                        'close_time' => '16:00',
                    ],
                    [
                        'day' => 'sunday',
                        'closed' => 'yes',
                        'closed_text' => esc_html__('Closed', 'lc-addons-kit-for-elementor'),
                    ],
                ],
                'title_field' => '{{{ day }}}',
            ]
        );

        $this->add_control(
            'lcake_contect_highlight_today',
            [
                'label' => esc_html__('Highlight Today', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'lcake_content_time_format',
            [
                'label' => esc_html__('Time Format', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '24',
                'options' => [
                    '12' => esc_html__('12 Hour', 'lc-addons-kit-for-elementor'),
                    '24' => esc_html__('24 Hour', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function add_style_controls() {
        $this->start_controls_section(
            'lcake_section_style_container',
            [
                'label' => esc_html__('Container', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lcake_container_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_container_border',
                'selector' => '{{WRAPPER}} .lcake-business-hours',
            ]
        );

        $this->add_control(
            'lcake_container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_container_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'lcake_section_style_title',
            [
                'label' => esc_html__('Title', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lcake_style_title_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_title_typography',
                'selector' => '{{WRAPPER}} .lcake-business-hours-title',
            ]
        );

        $this->add_responsive_control(
            'lcake_style_title_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'lcake_style_section_style_hours',
            [
                'label' => esc_html__('Hours', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lcake_style_hours_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_style_hours_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'hours_typography',
                'selector' => '{{WRAPPER}} .lcake-business-hours-item',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'hours_border',
                'selector' => '{{WRAPPER}} .lcake-business-hours-item',
            ]
        );

        $this->add_responsive_control(
            'lcake_style_hours_padding',
            [
                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_style_hours_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'lcake_style_section_style_today',
            [
                'label' => esc_html__('Today Highlight', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'highlight_today' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'lcake_style_today_background_color',
            [
                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours-item.today' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_style_today_color',
            [
                'label' => esc_html__('Text Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-business-hours-item.today' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'today_border',
                'selector' => '{{WRAPPER}} .lcake-business-hours-item.today',
            ]
        );

        $this->end_controls_section();
    }

    private function get_day_name($day) {
        $days = [
            'monday' => esc_html__('Monday', 'lc-addons-kit-for-elementor'),
            'tuesday' => esc_html__('Tuesday', 'lc-addons-kit-for-elementor'),
            'wednesday' => esc_html__('Wednesday', 'lc-addons-kit-for-elementor'),
            'thursday' => esc_html__('Thursday', 'lc-addons-kit-for-elementor'),
            'friday' => esc_html__('Friday', 'lc-addons-kit-for-elementor'),
            'saturday' => esc_html__('Saturday', 'lc-addons-kit-for-elementor'),
            'sunday' => esc_html__('Sunday', 'lc-addons-kit-for-elementor'),
        ];
        
        return isset($days[$day]) ? $days[$day] : $day;
    }
    private function is_today($day) {
    $today = strtolower(gmdate('l'));
        $day_map = [
            'monday' => 'monday',
            'tuesday' => 'tuesday',
            'wednesday' => 'wednesday',
            'thursday' => 'thursday',
            'friday' => 'friday',
            'saturday' => 'saturday',
            'sunday' => 'sunday',
        ];
        
        return isset($day_map[$day]) && $day_map[$day] === $today;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Updated to use new prefixed name
        if (empty($settings['lcake_content_business_hours'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'lcake-business-hours');

        echo '<div ' . esc_attr($this->get_render_attribute_string('wrapper')) . '>';

        // Title
        if (!empty($settings['lcake_content_title'])) {
            echo '<h3 class="lcake-business-hours-title">' . esc_html($settings['lcake_content_title']) . '</h3>';
        }

        echo '<div class="lcake-business-hours-list">';

        foreach ($settings['lcake_content_business_hours'] as $hour) {
            $item_class = 'lcake-business-hours-item';

            // Highlight today check with new setting name
            if ($settings['lcake_contect_highlight_today'] === 'yes' && $this->is_today($hour['day'])) {
                $item_class .= ' today';
            }

            echo '<div class="' . esc_attr($item_class) . '">';
            echo '<span class="lcake-business-hours-day">' . esc_html($this->get_day_name($hour['day'])) . '</span>';

            if (!empty($hour['closed']) && $hour['closed'] === 'yes') {
                echo '<span class="lcake-business-hours-time closed">' . esc_html($hour['closed_text']) . '</span>';
            } else {
                // Format times based on lcake_content_time_format
                $open_time  = $this->lcake_format_business_time($hour['open_time'], $settings['lcake_content_time_format']);
                $close_time = $this->lcake_format_business_time($hour['close_time'], $settings['lcake_content_time_format']);

                echo '<span class="lcake-business-hours-time">' . esc_html($open_time) . ' - ' . esc_html($close_time) . '</span>';
            }

            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
    }


    // Add this helper inside your widget class
    private function lcake_format_business_time($time, $format_type) {
        if (empty($time)) {
            return '';
        }
        $timestamp = strtotime($time);

        return ($format_type === '12')
            ? gmdate('h:i A', $timestamp) // 12-hour format
            : gmdate('H:i', $timestamp);  // 24-hour format
    }

} 