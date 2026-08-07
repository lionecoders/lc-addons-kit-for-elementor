<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;


if (!defined('ABSPATH'))
    exit;


class LCAKE_Kit_Countdown_Timer extends Widget_Base
{

    public $base;

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
    }

    public function get_script_depends()
    {
        return ['lcake-kit-countdown-js', 'lcake-kit-countdown-timer-js'];
    }

    public function get_name()
    {
        return 'lcake-kit-countdown-timer';
    }

    public function get_title()
    {
        return esc_html__('Countdown Timer', 'lc-addons-kit-for-elementor');
    }

    public function get_icon()
    {
        return 'eicon-countdown';
    }

    public function get_categories()
    {
        return ['lcake-page-kit'];
    }

    public function get_keywords()
    {
        return ['countdown', 'timer', 'clock', 'time', 'deadline'];
    }

    public function get_help_url()
    {
        return 'https://wpmet.com/doc/countdown-timer/';
    }

    protected function is_dynamic_content(): bool
    {
        return false;
    }

    public function has_widget_inner_wrapper(): bool
    {
        return !Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('Presets', 'lc-addons-kit-for-elementor'),
            ]
        );


        $this->add_control(
            'lcake_countdown_timer_style',
            [
                'label' => esc_html__('Choose Style', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1', 'lc-addons-kit-for-elementor'),
                    'style2' => esc_html__('Style 2', 'lc-addons-kit-for-elementor'),
                    'style3' => esc_html__('Style 3', 'lc-addons-kit-for-elementor'),
                    'style4' => esc_html__('Style 4', 'lc-addons-kit-for-elementor'),
                    'style5' => esc_html__('Style 5', 'lc-addons-kit-for-elementor'),
                    'style6' => esc_html__('Style 6', 'lc-addons-kit-for-elementor'),
                ],
            ]
        );
        $this->end_controls_section();
        // Timer setting


        $this->start_controls_section(
            'lcake_countdown_timer_timer_setting',
            [
                'label' => esc_html__('Timer Settings  ', 'lc-addons-kit-for-elementor'),
            ]
        );


        $this->add_control(
            'lcake_countdown_timer_due_time',
            [
                'label' => esc_html__('Countdown Due Date', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => date("Y-m-d", strtotime("+ 1 day")), // PHPCS:Ignore WordPress.DateTime.RestrictedFunctions.date_date
                'description' => esc_html__('Set the due date and time', 'lc-addons-kit-for-elementor'),
            ]
        );
        $this->add_control(
            'lcake_countdown_timer_content_setting',
            [
                'label' => esc_html__('Custom Labels', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_weeks_label',
            [
                'label' => esc_html__('Weeks', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('Weeks', 'lc-addons-kit-for-elementor'),
                'condition' => ['lcake_countdown_timer_style' => 'style3'],
            ]
        );


        $this->add_control(
            'lcake_countdown_timer_days_label',
            [
                'label' => esc_html__('Days', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('Days', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_hours_label',
            [
                'label' => esc_html__('Hours', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('Hours', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_minutes_hours_label',
            [
                'label' => esc_html__('Minutes', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('Minutes', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_seconds_hours_label',
            [
                'label' => esc_html__('Seconds', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('Seconds', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'lcake_countdown_timer_on_expire_settings',
            [
                'label' => esc_html__('Expire Action', 'lc-addons-kit-for-elementor')
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_title',
            [
                'label' => esc_html__('On Expiry Title', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('Countdown is finished!', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_expiry_content',
            [
                'label' => esc_html__('On Expiry Content', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('This event/offer has ended. Thank you for your interest!', 'lc-addons-kit-for-elementor'),
            ]
        );

        $this->end_controls_section();

        // start style here........

        // content settings styles start
        $this->start_controls_section(
            'lcake_countdown_timer_content_style',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,

            ]
        );
        // set width for Days
        $this->add_responsive_control(
            'lcake_countdown_timer_days_width',
            [
                'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown-inner' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        // set Height for Days
        $this->add_responsive_control(
            'lcake_countdown_timer_days_height',
            [
                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown-inner' => 'height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        // set Line Height for Days
        $this->add_responsive_control(
            'lcake_countdown_timer_days__line_height',
            [
                'label' => esc_html__('Line Height', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-content .lcake-timer-count,
                    {{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-content .lcake-timer-count,
					{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box  .lcake-timer-content,
					{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container .lcake-inner-container,
					{{WRAPPER}} .lcake-flip-clock .lcake-top,
					{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container ' => 'line-height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'lcake_countdown_timer_content_margin_bottom',
            [
                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'step' => 1,
                    ],
                ],
                'desktop_default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 30,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 15,
                    'unit' => 'px',
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown-inner' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // end content settings

        //weeks Style Section
        $this->start_controls_section(
            'lcake_countdown_timer_weeks_style',
            [
                'label' => esc_html__('Weeks', 'lc-addons-kit-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'lcake_countdown_timer_style' => 'style3'
                ],
            ]
        );

        // Start Digits for weeks
        $this->add_control(
            'lcake_countdown_timer_weeks_heading_digits',
            [
                'label' => esc_html__('Digits', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        // Set Digits color for weeks
        $this->add_control(
            'lcake_countdown_timer_weeks_digits_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks  > .lcake-count' => 'color: {{VALUE}};'
                ],
            ]
        );
        // Set Digits typeography for weeks
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_weeks_digits_typography_group',
                'selector' => '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks  > .lcake-count',
            ]
        );

        // Set Digits margin for weeks
        $this->add_responsive_control(
            'lcake_countdown_timer_weeks_digits_margin_bottom',
            [
                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => -30,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks  > .lcake-count' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_weeks_label_title',
            [
                'label' => esc_html__('Label', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'lcake_countdown_timer_weeks_label_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks  > .lcake-label' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_weeks_label_typography_group',
                'selector' => '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks  > .lcake-label',
                'fields_options' => [
                    'font_weight' => [
                        'default' => '400',
                    ],
                    'font_family' => [
                        'default' => 'Lato',
                    ],
                    'font_size' => ['default' => ['unit' => 'px', 'size' => 14]]
                ],
                'seperator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_weeks_label_background_group',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks  > .lcake-label',
                'seperator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_weeks_label_border_color',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks  > .lcake-label',
            ]
        );
        $this->add_responsive_control(
            'lcake_countdown_timer_weeks_label_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks  > .lcake-label, ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_weeks_label_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks  > .lcake-label',
            ]
        );


        $this->add_responsive_control(
            'lcake_countdown_timer_weeks_lebel_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],

                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-clock > .lcake-wks > .lcake-label
					' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // start genaral setting styles
        $this->add_control(
            'lcake_countdown_timer_weeks_heading_general',
            [
                'label' => esc_html__('General', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_weeks_background_group',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-flip-clock  > .lcake-wks .lcake-count',
                'seperator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_weeks_border_color_group',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-wks .lcake-inner-container,
				{{WRAPPER}} .lcake-flip-clock  > .lcake-wks ',

            ]
        );
        $this->add_responsive_control(
            'lcake_countdown_timer_weeks_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-flip-clock > .lcake-wks ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_weeks_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-flip-clock > .lcake-wks ',

            ]
        );

        $this->end_controls_section();

        // end digit section styles for Weeks


        //Days Style Section
        $this->start_controls_section(
            'lcake_countdown_timer_days_style',
            [
                'label' => esc_html__('Days', 'lc-addons-kit-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Start Digits for Days
        $this->add_control(
            'lcake_countdown_timer_days_heading_digits',
            [
                'label' => esc_html__('Digits', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        // Set Digits color for Days
        $this->add_control(
            'lcake_countdown_timer_days_digits_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-days .lcake-timer-count, {{WRAPPER}} .lcake-flip-clock .lcake-days .lcake-count' => 'color: {{VALUE}};'
                ],
            ]
        );
        // Set Digits typeography for Days
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_days_digits_typography_group',
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-days .lcake-timer-content > span.lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-days .lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-days .lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-days .lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-days .lcake-timer-count,
				{{WRAPPER}} .lcake-flip-clock .lcake-days .lcake-count',
            ]
        );

        // Set Digits margin for Days
        $this->add_responsive_control(
            'lcake_countdown_timer_days_digits_margin_bottom',
            [
                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -30,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-days .lcake-timer-count, {{WRAPPER}} .lcake-flip-clock .lcake-days .lcake-count' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_days_label_title',
            [
                'label' => esc_html__('Label', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'lcake_countdown_timer_days_label_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-days .lcake-timer-title, {{WRAPPER}} .lcake-flip-clock .lcake-days .lcake-label' => 'color: {{VALUE}};'
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_days_label_typography_group',
                'selector' => '{{WRAPPER}} .lcake-flip-clock .lcake-days .lcake-label,
								{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-days .lcake-timer-title',
                'fields_options' => [
                    // Inner control name
                    'font_weight' => [
                        // Inner control settings
                        'default' => '400',
                    ],
                    'font_family' => [
                        'default' => 'Lato',
                    ],
                    'font_size' => ['default' => ['unit' => 'px', 'size' => 14]]
                ],
                'seperator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_days_label_background_group',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-flip-clock .lcake-days .lcake-label,
								{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-days .lcake-timer-title
								',
                'seperator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_days_label_border_color',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => ' {{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-days .lcake-timer-content > span.lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-flip-clock .lcake-days .lcake-label
								',
            ]
        );
        $this->add_responsive_control(
            'lcake_countdown_timer_days_label_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-days .lcake-inner-container, {{WRAPPER}} .lcake-flip-clock .lcake-days' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_days_label_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-days .lcake-timer-content > span.lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-days .lcake-timer-title,
								{{WRAPPER}} .lcake-flip-clock .lcake-days .lcake-label
				',
            ]
        );

        $this->add_responsive_control(
            'lcake_countdown_timer_days_lebel_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],

                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-days .lcake-timer-title, {{WRAPPER}} .lcake-flip-clock .lcake-days .lcake-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // start genaral settings
        $this->add_control(
            'lcake_countdown_timer_days_heading_general',
            [
                'label' => esc_html__('General', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );



        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_days_background_group',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-days .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-days .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-days .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-days .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-days .lcake-inner-container,
								{{WRAPPER}} .lcake-flip-clock  > .lcake-days .lcake-count ',
                'seperator' => 'before'
            ]
        );

        // overlay color

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_days_border_color_group',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-flip-clock .lcake-days ',
            ]
        );
        $this->add_responsive_control(
            'lcake_countdown_timer_days_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-days .lcake-inner-container, {{WRAPPER}} .lcake-flip-clock .lcake-days' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_days_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-days .lcake-inner-container,
				{{WRAPPER}} .lcake-flip-clock .lcake-days ',
            ]
        );

        $this->end_controls_section();

        // end digit section styles for Days


        //Hours Style Section start
        $this->start_controls_section(
            'lcake_countdown_timer_hours_style',
            [
                'label' => esc_html__('Hours', 'lc-addons-kit-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_hours_heading_digits',
            [
                'label' => esc_html__('Digits', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'lcake_countdown_timer_hours_digits_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-hours .lcake-timer-count, {{WRAPPER}} .lcake-flip-clock .lcake-hrs .lcake-count' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_hours_digits_typography_group',
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-hours .lcake-timer-content > span.lcake-timer-count,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-hours .lcake-timer-count,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-hours .lcake-timer-count,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-hours .lcake-timer-count,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-hours .lcake-timer-count,
								{{WRAPPER}} .lcake-flip-clock .lcake-hrs .lcake-count',
            ]
        );
        $this->add_responsive_control(
            'lcake_countdown_timer_hours_digits_margin_bottom',
            [
                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => -30,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],

                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-hours .lcake-timer-count, {{WRAPPER}} .lcake-flip-clock .lcake-hrs .lcake-count' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'lcake_countdown_timer_hours_label_title',
            [
                'label' => esc_html__('Label', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'lcake_countdown_timer_hours_label_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-hours .lcake-timer-title, {{WRAPPER}} .lcake-flip-clock .lcake-hrs .lcake-label' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_hours_label_typography_group',
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-hours .lcake-timer-content > span.lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-flip-clock .lcake-hrs .lcake-label',
                'fields_options' => [
                    // Inner control name
                    'font_weight' => [
                        // Inner control settings
                        'default' => '400',
                    ],
                    'font_family' => [
                        'default' => 'Lato',
                    ],
                    'font_size' => ['default' => ['unit' => 'px', 'size' => 14]]
                ],
                'seperator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_hours_label_background_group',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-flip-clock .lcake-hrs .lcake-label,
                {{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-hours .lcake-timer-title
								',
                'seperator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_hours_label_border_color',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => ' {{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-hours .lcake-timer-content > span.lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-hours .lcake-timer-title,
                {{WRAPPER}} .lcake-flip-clock .lcake-hrs .lcake-label
                ',
            ]
        );
        $this->add_responsive_control(
            'lcake_countdown_timer_hours_label_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-hours .lcake-inner-container, {{WRAPPER}} .lcake-flip-clock .lcake-hrs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_hours_label_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-hours .lcake-timer-content > span.lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-hours .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-hours .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-hours .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-hours .lcake-timer-title,
								{{WRAPPER}} .lcake-flip-clock .lcake-hrs .lcake-label
				',
            ]
        );


        $this->add_responsive_control(
            'lcake_countdown_timer_hours_lebel_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],

                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-hours .lcake-timer-title, {{WRAPPER}} .lcake-flip-clock .lcake-hrs .lcake-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // start genaral styles
        $this->add_control(
            'lcake_countdown_timer_hours_heading_general',
            [
                'label' => esc_html__('General', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_hours_background',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-hours .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-hours .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-hours .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-hours .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-hours .lcake-inner-container,
								{{WRAPPER}} .lcake-flip-clock  > .lcake-hrs .lcake-count ',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_hours_border_color_group',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-flip-clock .lcake-hrs ',
            ]
        );

        $this->add_responsive_control(
            'lcake_countdown_timer_hours_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-hours .lcake-inner-container, {{WRAPPER}} .lcake-flip-clock .lcake-hrs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_hours_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-hours .lcake-inner-container,
				{{WRAPPER}} .lcake-flip-clock .lcake-hrs ',
            ]
        );

        $this->end_controls_section();


        //Minutes Style Section

        $this->start_controls_section(
            'lcake_countdown_timer_minutes_style',
            [
                'label' => esc_html__('Minutes', 'lc-addons-kit-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Start Digits for Days
        $this->add_control(
            'lcake_countdown_timer_minutes_heading_digits',
            [
                'label' => esc_html__('Digits', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        // Set Digits color for Days
        $this->add_control(
            'lcake_countdown_timer_minutes_digits_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-minutes .lcake-timer-count, {{WRAPPER}} .lcake-flip-clock .lcake-mins .lcake-count' => 'color: {{VALUE}};'
                ],
            ]
        );
        // Set Digits typeography for Days
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_minutes_digits_typography_group',
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-minutes .lcake-timer-content > span.lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-minutes .lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-minutes .lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-minutes .lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-minutes .lcake-timer-count,
				{{WRAPPER}} .lcake-flip-clock .eins .eount, {{WRAPPER}} .lcake-flip-clock .lcake-mins .lcake-count',
            ]
        );

        // Set Digits margin for Days
        $this->add_responsive_control(
            'lcake_countdown_timer_minutes_digits_margin_bottom',
            [
                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => -30,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-minutes .lcake-timer-count, {{WRAPPER}} .lcake-flip-clock .lcake-mins .lcake-count' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_minutes_label_title',
            [
                'label' => esc_html__('Label', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'lcake_countdown_timer_minutes_label_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-minutes .lcake-timer-title, {{WRAPPER}} .lcake-flip-clock .lcake-mins .lcake-label' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_minutes_label_typography_group',
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-minutes .lcake-timer-content > span.lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-flip-clock .lcake-mins .lcake-label',
                'fields_options' => [
                    // Inner control name
                    'font_weight' => [
                        // Inner control settings
                        'default' => '400',
                    ],
                    'font_family' => [
                        'default' => 'Lato',
                    ],
                    'font_size' => ['default' => ['unit' => 'px', 'size' => 14]]
                ],
                'seperator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_minutes_label_background_group',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-flip-clock .lcake-mins .lcake-label,
								{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-minutes .lcake-timer-title
								',
                'seperator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_minutes_label_border_color',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => ' {{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-minutes .lcake-timer-content > span.lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-flip-clock .lcake-mins .lcake-label
								',
            ]
        );
        $this->add_responsive_control(
            'lcake_countdown_timer_minutes_label_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-minutes .lcake-inner-container, {{WRAPPER}} .lcake-flip-clock .lcake-mins' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_minutes_label_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-minutes .lcake-timer-content > span.lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-minutes .lcake-timer-title,
								{{WRAPPER}} .lcake-flip-clock .lcake-mins .lcake-label
				',
            ]
        );

        $this->add_responsive_control(
            'lcake_countdown_timer_minutes_lebel_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],

                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-minutes .lcake-timer-title, {{WRAPPER}} .lcake-flip-clock .lcake-mins .lcake-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        // start genaral styles
        $this->add_control(
            'lcake_countdown_timer_minutes_heading_general',
            [
                'label' => esc_html__('General', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_minutes_background',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-minutes .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-minutes .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-minutes .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-minutes .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-minutes .lcake-inner-container,
								{{WRAPPER}} .lcake-flip-clock  > .lcake-mins .lcake-count ',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_minutes_border_color_group',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-flip-clock .lcake-mins ',
            ]
        );

        $this->add_responsive_control(
            'lcake_countdown_timer_minutes_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-minutes .lcake-inner-container, {{WRAPPER}} .lcake-flip-clock .lcake-mins' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_minutes_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-minutes .lcake-inner-container,
				{{WRAPPER}} .lcake-flip-clock .lcake-mins ',
            ]
        );


        $this->end_controls_section();

        // end minutes style section


        //Seconds Style Section

        $this->start_controls_section(
            'lcake_countdown_timer_seconds_style',
            [
                'label' => esc_html__('Seconds', 'lc-addons-kit-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Start Digits for Days
        $this->add_control(
            'lcake_countdown_timer_seconds_heading_digits',
            [
                'label' => esc_html__('Digits', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        // Set Digits color for Days
        $this->add_control(
            'lcake_countdown_timer_seconds_digits_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-seconds .lcake-timer-count, {{WRAPPER}} .lcake-flip-clock .lcake-secs .lcake-count' => 'color: {{VALUE}};'
                ],
            ]
        );
        // Set Digits typeography for Days
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_seconds_digits_typography_group',
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-seconds .lcake-timer-content > span.lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-seconds .lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-seconds .lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-seconds .lcake-timer-count,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-seconds .lcake-timer-count,
				{{WRAPPER}} .lcake-flip-clock .lcake-secs .lcake-count',
            ]
        );

        // Set Digits margin for Days
        $this->add_responsive_control(
            'lcake_countdown_timer_seconds_digits_margin_bottom',
            [
                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => -30,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-seconds .lcake-timer-count, {{WRAPPER}} .lcake-flip-clock .lcake-secs .lcake-count' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_seconds_label_title',
            [
                'label' => esc_html__('Label', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'lcake_countdown_timer_seconds_label_color',
            [
                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-seconds .lcake-timer-title, {{WRAPPER}} .lcake-flip-clock .lcake-secs .lcake-label' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'lcake_countdown_timer_seconds_label_typography_group',
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-seconds .lcake-timer-content > span.lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-flip-clock .lcake-secs .lcake-label',
                'fields_options' => [
                    // Inner control name
                    'font_weight' => [
                        // Inner control settings
                        'default' => '400',
                    ],
                    'font_family' => [
                        'default' => 'Lato',
                    ],
                    'font_size' => ['default' => ['unit' => 'px', 'size' => 14]]
                ],
                'seperator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_seconds_label_background_group',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-flip-clock .lcake-secs .lcake-label,
								{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-seconds .lcake-timer-title
								',
                'seperator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_seconds_label_border_color',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => ' {{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-seconds .lcake-timer-content > span.lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-flip-clock .lcake-secs .lcake-label
								',
            ]
        );
        $this->add_responsive_control(
            'lcake_countdown_timer_seconds_label_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-seconds .lcake-inner-container, {{WRAPPER}} .lcake-flip-clock .lcake-secs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_seconds_label_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-seconds .lcake-timer-content > span.lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-seconds .lcake-timer-title,
								{{WRAPPER}} .lcake-flip-clock .lcake-secs .lcake-label
				',
            ]
        );

        $this->add_responsive_control(
            'lcake_countdown_timer_seconds_lebel_margin',
            [
                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],

                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-seconds .lcake-timer-title, {{WRAPPER}} .lcake-flip-clock .lcake-secs .lcake-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // start genaral styles
        $this->add_control(
            'lcake_countdown_timer_seconds_heading_general',
            [
                'label' => esc_html__('General', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_seconds_background',
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-seconds .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-seconds .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-seconds .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-seconds .lcake-inner-container,
								{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-seconds .lcake-inner-container,
								{{WRAPPER}} .lcake-flip-clock  > .lcake-secs .lcake-count ',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'lcake_countdown_timer_seconds_border_color_group',
                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-flip-clock .lcake-secs ',
            ]
        );

        $this->add_responsive_control(
            'lcake_countdown_timer_seconds_border_radious_open',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-timer-container.lcake-seconds .lcake-inner-container, {{WRAPPER}} .lcake-flip-clock .lcake-secs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lcake_countdown_timer_seconds_box_shadow_group',
                'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
                'selector' => '{{WRAPPER}} .lcake-countdown-timer .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-2 .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3 .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-3.lcake-version-box .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-countdown-timer-4 .lcake-timer-container.lcake-seconds .lcake-inner-container,
				{{WRAPPER}} .lcake-flip-clock .lcake-secs ',
            ]
        );
        $this->end_controls_section();
        // end seconds style section

        //Section Background

        $this->start_controls_section(
            'lcake_countdown_timer_bg_style',
            [
                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'lcake_countdown_timer_style' => 'style6'
                ]
            ]
        );

        $this->add_responsive_control(
            'lcake_countdown_timer_content_height',
            [
                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'step' => 1,
                    ],
                ],
                'desktop_default' => [
                    'size' => 120,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 100,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-inner-container' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'lcake_countdown_timer_content_line_height',
            [
                'label' => esc_html__('Line Height', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'step' => 1,
                    ],
                ],
                'desktop_default' => [
                    'size' => 120,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 100,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-countdown .lcake-inner-container' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_countdown_timer_outer_section_bg_style',
            [
                'label' => esc_html__('Outer Part', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_outer_background_group',
                'label' => esc_html__('Outer Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-countdown-container .lcake-countdown-timer-4',
            ]
        );
        $this->add_control(
            'lcake_countdown_timer_inner_section_bg_style',
            [
                'label' => esc_html__('Inner Part', 'lc-addons-kit-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lcake_countdown_timer_inner_background_group',
                'label' => esc_html__('Inner Background', 'lc-addons-kit-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .lcake-countdown-container',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        echo '<div class="lcake-wid-con" >';
        $this->render_raw();
        echo '</div>';
    }

    protected function render_raw()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (isset($lcake_countdown_timer_weeks_label)) {
            $this->add_render_attribute('lcake_countdown_timer', 'data-date-lcake-week', esc_attr(wp_strip_all_tags($lcake_countdown_timer_weeks_label)));
        }

        if (isset($lcake_countdown_timer_days_label)) {
            $this->add_render_attribute('lcake_countdown_timer', 'data-date-lcake-day', esc_attr(wp_strip_all_tags($lcake_countdown_timer_days_label)));
        }

        if (isset($lcake_countdown_timer_hours_label)) {
            $this->add_render_attribute('lcake_countdown_timer', 'data-date-lcake-hour', esc_attr(wp_strip_all_tags($lcake_countdown_timer_hours_label)));
        }

        if (isset($lcake_countdown_timer_minutes_hours_label)) {
            $this->add_render_attribute('lcake_countdown_timer', 'data-date-lcake-minute', esc_attr(wp_strip_all_tags($lcake_countdown_timer_minutes_hours_label)));
        }

        if (isset($lcake_countdown_timer_seconds_hours_label)) {
            $this->add_render_attribute('lcake_countdown_timer', 'data-date-lcake-second', esc_attr(wp_strip_all_tags($lcake_countdown_timer_seconds_hours_label)));
        }

        if (isset($lcake_countdown_timer_due_time)) {
            $this->add_render_attribute('lcake_countdown_timer', 'data-lcake-countdown', esc_attr($lcake_countdown_timer_due_time));
        }

        $this->add_render_attribute('lcake_countdown_timer', [
            'data-finish-title' => esc_attr(wp_strip_all_tags($lcake_countdown_timer_title)),
            'data-finish-content' => esc_attr(wp_strip_all_tags($lcake_countdown_timer_expiry_content)),
        ]);

        switch ($lcake_countdown_timer_style) {
            case 'style1':
                $this->add_render_attribute('lcake_countdown_timer', 'class', 'lcake-countdown-timer lcake-countdown text-center');
                break;
            case 'style2':
                $this->add_render_attribute('lcake_countdown_timer', 'class', 'lcake-countdown-timer-2 lcake-countdown text-center');
                break;
            case 'style3':
                $this->add_render_attribute('lcake_countdown_timer', 'class', 'lcake-flip-clock text-center');
                break;
            case 'style4':
                $this->add_render_attribute('lcake_countdown_timer', 'class', 'lcake-countdown-timer-3 lcake-countdown text-center');
                break;
            case 'style5':
                $this->add_render_attribute('lcake_countdown_timer', 'class', 'lcake-countdown-timer-3 lcake-countdown lcake-version-box text-center align-items-end');
                break;
            case 'style6':
                $this->add_render_attribute('lcake_countdown_timer', 'class', 'lcake-countdown-timer-4 lcake-countdown');
                break;
        }

        if ($lcake_countdown_timer_style != 'style6') {
            $markup = sprintf('<div %s></div>', $this->get_render_attribute_string('lcake_countdown_timer'));
        } else {
            $markup = sprintf('<div class="lcake-countdown-container text-center"><div %s></div></div>', $this->get_render_attribute_string('lcake_countdown_timer'));
        }

        // PHPCS - the variable $markup holds safe data.
        echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
