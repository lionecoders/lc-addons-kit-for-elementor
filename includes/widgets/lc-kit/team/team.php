<?php
/**
 * Team Widget
 * 
 * @package LCAKE_Elementor_Addons_Kit
 */

use Elementor\Icons_Manager;
if (!defined('ABSPATH')) {
    exit;
}


class LCAKE_Kit_Team extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'lcake-kit-team';
    }

    public function get_title()
    {

        return esc_html__('LC Team', 'lc-addons-kit-for-elementor');
    }

    public function get_icon()
    {
        return 'eicon-person';
    }

    public function get_categories()
    {

        return ['lcake-page-kit'];
    }

    public function get_keywords()
    {

        return ['team', 'member', 'staff', 'person', 'profile'];
    }

    public function get_script_depends()
    {

        return ['lcake-team-js'];
    }

    public function get_style_depends()
    {

        return ['lcake-team-css'];
    }

    protected function register_controls()
    {

        // Team Content

        $this->start_controls_section(

            'lcake_team_content',
            [

                'label' => esc_html__('Team Member Content', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_style',

            [

                'label' => esc_html__('Style', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SELECT,

                'default' => 'default',

                'options' => [

                    'default' => esc_html__('Default', 'lc-addons-kit-for-elementor'),

                    'overlay' => esc_html__('Overlay', 'lc-addons-kit-for-elementor'),

                    'centered_style' => esc_html__('Centered', 'lc-addons-kit-for-elementor'),

                    'hover_info' => esc_html__('Hover on Social', 'lc-addons-kit-for-elementor'),

                    'overlay_details' => esc_html__('Overlay with Details', 'lc-addons-kit-for-elementor'),

                    'centered_style_details' => esc_html__('Centered with Details', 'lc-addons-kit-for-elementor'),

                    'long_height_hover' => esc_html__('Long Height with Hover', 'lc-addons-kit-for-elementor'),

                    'long_height_details' => esc_html__('Long Height with Details', 'lc-addons-kit-for-elementor'),

                    'long_height_details_hover' => esc_html__('Long Height with Details & Hover', 'lc-addons-kit-for-elementor'),

                    'overlay_circle' => esc_html__('Circle Overlay', 'lc-addons-kit-for-elementor'),

                    'overlay_circle_hover' => esc_html__('Circle Overlay & Hover', 'lc-addons-kit-for-elementor'),

                ],

            ]

        );

        $this->add_control(

            'lcake_team_image',

            [

                'label' => esc_html__('Choose Member Image', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::MEDIA,

                'dynamic' => [

                    'active' => true,

                ],

                'default' => [

                    'url' => \Elementor\Utils::get_placeholder_image_src(),

                    'id'    => -1

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Image_Size::get_type(),

            [

                'name' => 'lcake_team_thumbnail',

                'default' => 'large',

            ]

        );

        $this->add_control(

            'lcake_team_name',

            [

                'label' => esc_html__('Member Name', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::TEXT,

                'dynamic' => [

                    'active' => true,

                ],

                'default' => esc_html__('John Smith', 'lc-addons-kit-for-elementor'),

                'placeholder' => esc_html__('Member Name', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_position',

            [

                'label' => esc_html__('Member Position', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::TEXT,

                'dynamic' => [

                    'active' => true,

                ],

                'default' => esc_html__('Software Engineer', 'lc-addons-kit-for-elementor'),

                'placeholder' => esc_html__('Member Position', 'lc-addons-kit-for-elementor'),



            ]

        );

        // Show Icon

        $this->add_control(

            'lcake_team_toggle_icon',

            [

                'label' => esc_html__('Show Icon', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SWITCHER,

                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),

                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),

                'return_value' => 'yes',

                'default' => 'no',

                'condition' => [

                    'lcake_team_style' => 'default',

                ],

            ]

        );

        $this->add_control(

            'lcake_team_top_icons',

            [

                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::ICONS,

                'fa4compatibility' => 'lcake_team_top_icon',

                'default' => [

                    'value' => 'fas fa-star',

                    'library' => 'fa-solid',

                ],

                'condition' => [

                    'lcake_team_style' => 'default',

                    'lcake_team_toggle_icon' => 'yes',

                ],
                'label_block' => true,

            ]

        );

        // Show Description

        $this->add_control(

            'lcake_team_show_short_description',

            [

                'label' => esc_html__('Show Description', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SWITCHER,

                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),

                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),

                'return_value' => 'yes',

                'default' => 'no',

            ]

        );

        $this->add_control(

            'lcake_team_short_description',

            [

                'label' => esc_html__('About Member', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::TEXTAREA,

                'dynamic' => [

                    'active' => true,

                ],

                'default' => esc_html__('Passionate engineer focused on building fast, accessible, and user-friendly web experiences.', 'lc-addons-kit-for-elementor'),

                'placeholder' => esc_html__('About Member', 'lc-addons-kit-for-elementor'),

                'condition' => [

                    'lcake_team_show_short_description' => 'yes'

                ],
            ]
        );

        $this->end_controls_section();

        // Team Social section
        $this->start_controls_section(

            'lcake_team_section_social',
            [

                'label' => esc_html__('Social  Profiles', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_social_enable',

            [

                'label' => esc_html__('Display Social Profiles?', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SWITCHER,

                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),

                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),

                'return_value' => 'yes',

                'default' => 'yes',

            ]

        );

        $popup_selector = '.team-popup-id-{{ID}}';
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(

            'lcake_team_icons',

            [

                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),

                'label_block' => true,

                'type' => \Elementor\Controls_Manager::ICONS,

                'default' => [

                    'value' => 'fab fa-facebook-f',

                    'library' => 'fa-brands',

                ],

            ]

        );

        $repeater->add_control(

            'lcake_team_link',

            [

                'label' => esc_html__('Link', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::URL,

                'dynamic' => [

                    'active' => true,

                ],

                'default' => [

                    'url' => 'https://facebook.com',

                ],

            ]

        );

        // start tab for content

        $repeater->start_controls_tabs(

            'lcake_team_socialmedia_tabs'

        );

        // start normal tab

        $repeater->start_controls_tab(

            'lcake_team_socialmedia_normal',

            [

                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),

            ]

        );

        // set social icon color

        $repeater->add_control(

            'lcake_team_socialmedia_icon_color',

            [

                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '#FFFFFF',

                'selectors' => [

                    '{{WRAPPER}} {{CURRENT_ITEM}} > a' => 'color: {{VALUE}};',

                    '{{WRAPPER}} {{CURRENT_ITEM}} > a svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',

                    $popup_selector . ' {{CURRENT_ITEM}} > a' => 'color: {{VALUE}};',

                    $popup_selector . ' {{CURRENT_ITEM}} > a svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};'

                ],

            ]

        );

        // set social icon background color

        $repeater->add_control(

            'lcake_team_socialmedia_icon_bg_color',

            [

                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '#a1a1a1',

                'selectors' => [

                    '{{WRAPPER}} {{CURRENT_ITEM}} > a' => 'background-color: {{VALUE}};',

                    $popup_selector . ' {{CURRENT_ITEM}} > a' => 'background-color: {{VALUE}};',

                ],

            ]

        );

        $repeater->add_group_control(

            \Elementor\Group_Control_Border::get_type(),

            [

                'name' => 'lcake_team_socialmedia_border',

                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),

                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} > a,' . $popup_selector . ' {{CURRENT_ITEM}} > a',

            ]

        );

        $repeater->add_group_control(

            \Elementor\Group_Control_Box_Shadow::get_type(),
            [

                'name'       => 'lcake_team_socialmedai_list_box_shadow',

                'selector'   => '{{WRAPPER}} {{CURRENT_ITEM}} > a,' . $popup_selector . ' {{CURRENT_ITEM}} > a',

            ]

        );

        $repeater->end_controls_tab();

        // end normal tab

        //start hover tab

        $repeater->start_controls_tab(

            'lcake_team_socialmedia_hover',

            [

                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),

            ]

        );

        // set social icon color

        $repeater->add_control(

            'lcake_team_socialmedia_icon_hover_color',

            [

                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'selectors' => [

                    '{{WRAPPER}} {{CURRENT_ITEM}} > a:hover' => 'color: {{VALUE}};',

                    '{{WRAPPER}} {{CURRENT_ITEM}} > a:hover svg path'   => 'stroke: {{VALUE}}; fill: {{VALUE}};',

                    $popup_selector . ' {{CURRENT_ITEM}} > a:hover' => 'color: {{VALUE}};',

                    $popup_selector . ' {{CURRENT_ITEM}} > a:hover svg path'   => 'stroke: {{VALUE}}; fill: {{VALUE}};',

                ],

            ]

        );

        // set social icon background color

        $repeater->add_control(

            'lcake_team_socialmedia_icon_hover_bg_color',

            [

                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '#3b5998',

                'selectors' => [

                    '{{WRAPPER}} {{CURRENT_ITEM}} > a:hover' => 'background-color: {{VALUE}};',

                    $popup_selector . ' {{CURRENT_ITEM}} > a:hover' => 'background-color: {{VALUE}};',

                ],

            ]

        );

        $repeater->add_group_control(

            \Elementor\Group_Control_Border::get_type(),

            [

                'name' => 'lcake_team_socialmedia_border_hover',

                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),

                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} > a:hover,' . $popup_selector . ' {{CURRENT_ITEM}} > a:hover',

            ]

        );

        $repeater->add_group_control(

            \Elementor\Group_Control_Text_Shadow::get_type(),

            [

                'name' => 'lcake_team_socialmedia_icon_hover_text_shadow',

                'label' => esc_html__('Text Shadow', 'lc-addons-kit-for-elementor'),

                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} > a:hover,' . $popup_selector . ' {{CURRENT_ITEM}} > a:hover',

            ]

        );

        $repeater->add_group_control(

            \Elementor\Group_Control_Box_Shadow::get_type(),
            [

                'name'       => 'lcake_team_socialmedai_list_box_shadow_hover',

                'selector'   => '{{WRAPPER}} {{CURRENT_ITEM}} > a:hover,' . $popup_selector . ' {{CURRENT_ITEM}} > a:hover',

            ]

        );

        $repeater->end_controls_tab();

        //end hover tab
        $repeater->end_controls_tabs();
        $this->add_control(

            'lcake_team_social_icons',

            [

                'label' => esc_html__('Add Icon', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::REPEATER,

                'fields' => $repeater->get_controls(),

                'default' => [

                    [

                        'lcake_team_label' => esc_html__('Facebook', 'lc-addons-kit-for-elementor'),

                        'lcake_team_icons' => [

                            'value'     => 'fab fa-facebook-f',

                            'library'   => 'fa-brands',

                        ],

                        'lcake_team_link' => [

                            'url' => 'https://facebook.com',

                        ],

                        'lcake_team_socialmedia_icon_hover_bg_color' => '#3b5998',

                    ],

                    [

                        'lcake_team_label' => esc_html__('Twitter', 'lc-addons-kit-for-elementor'),

                        'lcake_team_icons' => [

                            'value'     => 'fab fa-twitter',

                            'library'   => 'fa-brands',

                        ],

                        'lcake_team_link' => [

                            'url' => 'https://twitter.com',

                        ],

                        'lcake_team_socialmedia_icon_hover_bg_color' => '#1da1f2',

                    ],

                    [

                        'lcake_team_label' => esc_html__('Pinterest', 'lc-addons-kit-for-elementor'),

                        'lcake_team_icons' => [

                            'value'     => 'fab fa-pinterest-p',

                            'library'   => 'fa-brands',

                        ],

                        'lcake_team_link' => [

                            'url' => 'https://pinterest.com',

                        ],

                        'lcake_team_socialmedia_icon_hover_bg_color' => '#e60023',

                    ],

                ],

                'title_field' => '{{{ lcake_team_label }}}',

                'condition' => [

                    'lcake_team_social_enable' => 'yes'

                ]

            ]

        );

        $this->end_controls_section();

        $this->start_controls_section(

            'lcake_team_popup_details',

            [

                'label' => esc_html__('Pop Up Details', 'lc-addons-kit-for-elementor'),

                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,

            ]

        );

        $this->add_control(

            'lcake_team_chose_popup',

            [

                'label' => esc_html__('Show Popup', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SWITCHER,

                'default' => 'yes',

            ]

        );

        $this->add_control(

            'lcake_team_description',

            [

                'label' => esc_html__('About Member', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::TEXTAREA,

                'dynamic' => [

                    'active' => true,

                ],

                'default' => esc_html__('A small river named Duden flows by their place and supplies it with the necessary', 'lc-addons-kit-for-elementor'),

                'placeholder' => esc_html__('About Member', 'lc-addons-kit-for-elementor'),

                'condition' => [

                    'lcake_team_chose_popup' => 'yes'

                ],



            ]

        );

        $this->add_control(

            'lcake_team_phone',

            [

                'label' => esc_html__('Phone', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::TEXT,

                'dynamic' => [

                    'active' => true,

                ],

                'default' => '+1 (859) 254-6589',

                'placeholder' => esc_html__('Phone Number', 'lc-addons-kit-for-elementor'),

                'condition' => [

                    'lcake_team_chose_popup' => 'yes'

                ],



            ]

        );

        $this->add_control(

            'lcake_team_email',

            [

                'label' => esc_html__('Email', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::TEXT,

                'dynamic' => [

                    'active' => true,

                ],

                'default' => 'info@example.com',

                'placeholder' => esc_html__('Email Address', 'lc-addons-kit-for-elementor'),

                'condition' => [

                    'lcake_team_chose_popup' => 'yes'

                ],



            ]

        );

        // Close icon change option
        $this->add_control(

            'lcake_team_close_icon_changes',

            [

                'label' => esc_html__('Close Icon', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::ICONS,

                'fa4compatibility' => 'lcake_team_close_icon_change',

                'default' => [

                    'value' => 'fas fa-times',

                    'library' => 'fa-solid',

                ],

                'label_block' => true,

                'condition' => [

                    'lcake_team_chose_popup' => 'yes'

                ],

                'separator' => 'before',

            ]

        );

        $this->add_control(

            'lcake_team_close_icon_alignment',

            [

                'label' => esc_html__('Close Icon Alignment', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::CHOOSE,

                'options' => [

                    'left' => [

                        'title' => esc_html__('Left', 'lc-addons-kit-for-elementor'),

                        'icon' => 'eicon-text-align-left',

                    ],

                    'right' => [

                        'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),

                        'icon' => 'eicon-text-align-right',

                    ],

                ],

                'default' => 'right',

                'condition' => [

                    'lcake_team_chose_popup' => 'yes'

                ],

            ]

        );
        $this->end_controls_section();

        // start style section here
        // Team content section style start
        $this->start_controls_section(

            'lcake_team_content_style',
            [

                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

            ]

        );

        $this->start_controls_tabs(

            'lcake_team_background_tabs'

        );

        // start normal tab

        $this->start_controls_tab(

            'lcake_team_content_normal',

            [

                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Background::get_type(),

            [

                'name' => 'lcake_team_background_content_normal',

                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),

                'types' => ['classic', 'gradient', 'video'],

                'selector' => '{{WRAPPER}} .lcake-profile-card, {{WRAPPER}} .lcake-profile-image-card',

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Box_Shadow::get_type(),
            [

                'name'      => 'lcake_team_content_box_shadow',

                'selector'  => '{{WRAPPER}} .lcake-profile-card, {{WRAPPER}} .lcake-profile-image-card',

            ]

        );

        $this->end_controls_tab();

        $this->start_controls_tab(

            'lcake_team_content_hover',

            [

                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Background::get_type(),

            [

                'name' => 'lcake_team_background_content_hover',

                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),

                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .lcake-profile-card:hover, {{WRAPPER}} .lcake-profile-image-card:hover, {{WRAPPER}} .lcake-profile-card::before, {{WRAPPER}} .lcake-profile-image-card::before, {{WRAPPER}} div .lcake-profile-card .profile-body::before, {{WRAPPER}} .lcake-image-card-v3 .lcake-profile-image-card:after,
                {{WRAPPER}} .lcake-profile-square-v.square-v4 .lcake-profile-card .lcake-profile-body::before',

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Box_Shadow::get_type(),
            [

                'name'      => 'lcake_team_content_box_shadow_hover_group',

                'selector'  => '{{WRAPPER}} .lcake-profile-card:hover, {{WRAPPER}} .lcake-profile-image-card:hover',

            ]

        );

        $this->add_control(

            'team_hover_animation',

            [

                'label'         => esc_html__('Hover Animation', 'lc-addons-kit-for-elementor'),

                'type'          => \Elementor\Controls_Manager::HOVER_ANIMATION,

            ]

        );

        $this->add_responsive_control(

            'overlay_height',

            [

                'label'         => esc_html__('Overlay Height', 'lc-addons-kit-for-elementor'),

                'type'          => \Elementor\Controls_Manager::SLIDER,

                'size_units'    => ['%', 'px'],

                'range'         => [

                    '%'     => [

                        'min'   => 0,

                        'max'   => 100

                    ],

                    'px'    => [

                        'min'   => 0,

                        'max'   => 500,

                        'step'  => 5

                    ]

                ],

                'default'       => [

                    'unit'  => '%',

                ],

                'selectors'     => [

                    '{{WRAPPER}} .lcake-team-style-long_height_hover:after'  => 'height: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_team_style'   => 'long_height_hover',

                ],

            ]

        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(

            'content_tabs_after',

            [

                'type'  => \Elementor\Controls_Manager::DIVIDER,

            ]

        );

        // contentmax height

        $this->add_responsive_control(

            'lcake_team_content_max_weight',

            [

                'label' => esc_html__('Max Height', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 1000,

                        'step' => 1,

                    ],

                    '%' => [

                        'min' => 0,

                        'max' => 100,

                    ],

                ],

                'default' => [

                    'unit' => 'px',

                    'size' => 380,

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-square-v .lcake-profile-card' => 'max-height: {{SIZE}}{{UNIT}};',

                ],
                'condition' => [
                    'lcake_team_style' => 'hover_info'
                ]

            ]

        );

        // Text aliment

        $this->add_control(
            'lcake_team_content_text_align',
            [

                'label' => esc_html__('Alignment', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'text-left' => [
                        'title' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'text-center' => [
                        'title' => esc_html__('Center', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'text-right' => [
                        'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'text-center',
                'toggle' => true,
            ]
        );

        $this->add_responsive_control(

            'lcake_team_content_padding',
            [

                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', 'em', '%'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-card, {{WRAPPER}} .lcake-profile-image-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

            ]

        );

        $this->add_responsive_control(
            'lcake_team_content_inner_padding',
            [

                'label' => esc_html__('Content Padding', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', 'em', '%'],

                'selectors' => [
                    '{{WRAPPER}} .lcake-profile-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lcake-profile-square-v .lcake-profile-card .lcake-profile-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lcake_team_content_border_color_group',

                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),

                'selector' => '{{WRAPPER}} .lcake-profile-card, {{WRAPPER}} .lcake-profile-image-card',
            ]
        );

        $this->add_responsive_control(
            'lcake_team_content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lcake-profile-card, {{WRAPPER}} .lcake-profile-image-card' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'lcake_team_content_overly_color_heading',
            [
                'label' => esc_html__('Hover Overy Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'lcake_team_style' => 'overlay_details'
                ]
            ]
        );

        $this->add_group_control(

            \Elementor\Group_Control_Background::get_type(),

            [

                'name' => 'lcake_team_content_overly_color',

                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),

                'types' => ['gradient'],

                'selector' => '{{WRAPPER}} .lcake-image-card-v2 .lcake-profile-image-card::before',

                'condition' => [

                    'lcake_team_style' => 'overlay_details'

                ]

            ]

        );

        $this->add_control(

            'lcake_team_remove_gutters',

            [

                'label' => esc_html__('Remove Gutter?', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SWITCHER,

                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),

                'label_off' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),

                'return_value' => 'yes',

                'default' => '',

            ]

        );

        $this->end_controls_section();

        // team content section style end



        // Image Styles section

        $this->start_controls_section(

            'lcake_team_image_style',
            [

                'label' => esc_html__('Image', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

            ]

        );

        $this->add_responsive_control(

            'lcake_team_image_weight',

            [

                'label' => esc_html__('Image Size', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%', 'em'],

                'range'  => [

                    'px' => [

                        'min'   => 10,

                        'max'   => 300,

                    ],

                    '%' => [

                        'min'   => 10,

                        'max'   => 100,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-square-v.square-v4 .lcake-profile-card .lcake-profile-header' => 'padding-top: {{SIZE}}{{UNIT}};',

                    '{{WRAPPER}} .lcake-profile-header > img, {{WRAPPER}} .lcake-profile-image-card img, {{WRAPPER}} .lcake-profile-image-card, {{WRAPPER}} .lcake-profile-header ' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'

                ],

                'default' => [

                    'unit' => '%'

                ]

            ]

        );

        $this->add_responsive_control(

            'lcake_team_image_height',

            [

                'label'         => esc_html__('Height', 'lc-addons-kit-for-elementor'),

                'type'          => \Elementor\Controls_Manager::SLIDER,

                'size_units'    => ['px', 'em'],

                'range'  => [

                    'px' => [

                        'min'   => 1,

                        'max'   => 500,

                    ],

                ],

                'condition' => [

                    'team_style!' => 'overlay',

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-card .lcake-profile-header' => 'height: {{SIZE}}{{UNIT}};',

                ],

            ]

        );

        $this->add_responsive_control(

            'lcake_team_image_height_margin_bottom',

            [

                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%', 'em'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-card .lcake-profile-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_team_style' => [

                        'default',
                        'centered_style',
                        'centered_style_details',
                        'long_height_details',
                        'long_height_details_hover'

                    ],

                ],

            ]

        );

        $this->add_responsive_control(

            'lcake_team_image_width',

            [

                'label'         => esc_html__('Width', 'lc-addons-kit-for-elementor'),

                'type'          => \Elementor\Controls_Manager::SLIDER,

                'size_units'    => ['px', 'em', '%'],

                'range'  => [

                    'px' => [

                        'min'   => 1,

                        'max'   => 500,

                    ],

                ],

                'condition' => [

                    'team_style!' => 'overlay',

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-card .lcake-profile-header' => 'width: {{SIZE}}{{UNIT}};',

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Box_Shadow::get_type(),
            [

                'name'      => 'lcake_team_image_shadow',

                'selector'  => '{{WRAPPER}} .lcake-profile-card .lcake-profile-header',

                'condition' => [

                    'lcake_team_style' => [

                        'default',
                        'centered_style',
                        'centered_style_details',
                        'long_height_details',
                        'long_height_details_hover'

                    ]

                ]

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Box_Shadow::get_type(),
            [

                'name'      => 'modal_img_shadow',

                'label'     => esc_html__('Box Shadow (Popup)', 'lc-addons-kit-for-elementor'),

                'selector'  => '{{WRAPPER}} .lcake-team-modal-img > img',

                'condition' => [

                    'lcake_team_chose_popup' => 'yes',

                    'lcake_team_style' => [

                        'default',
                        'centered_style',
                        'centered_style_details',
                        'long_height_details',
                        'long_height_details_hover'

                    ]

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Border::get_type(),

            [

                'name' => 'lcake_team_image_border',

                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),

                'selector' => '{{WRAPPER}} .lcake-profile-card .lcake-profile-header',

                'condition' => [

                    'lcake_team_style' => [

                        'default',
                        'centered_style',
                        'centered_style_details',
                        'long_height_details',
                        'long_height_details_hover'

                    ]

                ],

            ]

        );

        $this->add_responsive_control(

            'lcake_team_image_radius',

            [

                'label' => esc_html__('Border radius', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%', 'em'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-img.lcake-profile-header > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

                'default' => [

                    'top' => '0',

                    'right' => '0',

                    'left' => '0',

                    'bottom' => '0',

                    'unit' => '%',

                ],

                'condition' => [

                    'lcake_team_style' => [

                        'default',
                        'centered_style',
                        'centered_style_details',
                        'long_height_details',
                        'long_height_details_hover'

                    ]

                ]

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Background::get_type(),

            [

                'name' => 'lcake_team_image_background',

                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),

                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .lcake-profile-card .lcake-profile-header',

                'condition' => [

                    'lcake_team_style' => [

                        'default',
                        'centered_style',
                        'centered_style_details',
                        'long_height_details',
                        'long_height_details_hover'

                    ]

                ],

            ]

        );

        $this->add_control(

            'lcake_team_default_img_overlay_h',

            [

                'label' => esc_html__('Overlay', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::HEADING,

                'separator' => 'before',

                'condition' => [

                    'lcake_team_style' => 'default',

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Background::get_type(),

            [

                'name' => 'lcake_team_default_img_overlay',

                'label' => esc_html__('Overlay', 'lc-addons-kit-for-elementor'),

                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .lcake-profile-header:before',

                'condition' => [

                    'lcake_team_style' => 'default',

                ],

            ]

        );

        $this->end_controls_section();

        // Icon Styles
        $this->start_controls_section(

            'lcake_team_top_icon_style',

            [

                'label' => esc_html__('Icon', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

                'condition' => [

                    'lcake_team_style' => 'default',

                    'lcake_team_toggle_icon' => 'yes',

                ],

            ]

        );

        $this->add_responsive_control(

            'lcake_team_top_icon_align',

            [

                'label' => esc_html__('Alignment', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::CHOOSE,

                'options' => [

                    'start' => [

                        'title' => esc_html__('Left', 'lc-addons-kit-for-elementor'),

                        'icon' => 'eicon-text-align-left',

                    ],

                    'center' => [

                        'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),

                        'icon' => 'eicon-text-align-right',

                    ],

                    'end' => [

                        'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),

                        'icon' => 'eicon-text-align-right',

                    ],

                ],

                'toggle' => true,

            ]

        );

        $this->add_responsive_control(

            'lcake_team_top_icon_margin',

            [

                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%'],

                'selectors' => [

                    '{{WRAPPER}} .profile-icon > i, {{WRAPPER}} .profile-icon > svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

            ]

        );

        $this->add_responsive_control(

            'lcake_team_top_icon_padding',

            [

                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%'],

                'selectors' => [

                    '{{WRAPPER}} .profile-icon > i, {{WRAPPER}} .profile-icon > svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

            ]

        );

        $this->add_responsive_control(

            'lcake_team_top_icon_border_radius',

            [

                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-icon > i, {{WRAPPER}} .lcake-profile-icon > svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

                'default'   => [

                    'top'   => '50',

                    'left'  => '50',

                    'right' => '50',

                    'bottom' => '50',

                    'unit' => '%'

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Box_Shadow::get_type(),

            [

                'name' => 'lcake_team_top_icon_shadow',

                'selector' => '{{WRAPPER}} .lcake-profile-icon > i, {{WRAPPER}} .lcake-profile-icon > svg',

            ]

        );

        $this->add_responsive_control(

            'lcake_team_top_icon_fsize',

            [

                'label' => esc_html__('Font Size', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'range' => [

                    'px' => [

                        'min' => 6,

                        'max' => 300,

                    ],

                ],

                'default' => [

                    'size' => 22,

                    'unit' => 'px',

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-icon > i' => 'font-size: {{SIZE}}{{UNIT}};',

                    '{{WRAPPER}} .lcake-profile-icon > svg'   => 'max-width: {{SIZE}}{{UNIT}};',

                ],

            ]

        );

        $this->add_control(

            'lcake_team_top_icon_hw',

            [

                'label' => esc_html__('Use Height Width', 'lc-addons-kit-for-elementor'),

                'description'   => esc_html__('For svg icon, We don\'t need this. We will use font size and padding for adjusting size.', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SWITCHER,

                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),

                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),

                'return_value' => 'yes',

                'default' => 'yes',

            ]

        );

        $this->add_responsive_control(

            'lcake_team_top_icon_width',

            [

                'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 200,

                    ],

                ],

                'default' => [

                    'size' => 60,

                    'unit' => 'px',

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-icon > i' => 'width: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_team_top_icon_hw' => 'yes'

                ],

            ]

        );

        $this->add_responsive_control(

            'lcake_team_top_icon_height',

            [

                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 200,

                    ],

                ],

                'default' => [

                    'size' => 60,

                    'unit' => 'px',

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-icon > i' => 'height: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_team_top_icon_hw' => 'yes'

                ],

            ]

        );

        $this->add_responsive_control(

            'lcake_team_top_icon_lheight',

            [

                'label' => esc_html__('Line Height', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 200,

                    ],

                ],

                'default' => [

                    'size' => 60,

                    'unit' => 'px',

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-icon > i' => 'line-height: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_team_top_icon_hw' => 'yes'

                ],

            ]

        );

        $this->start_controls_tabs('top_icon_colors');

        $this->start_controls_tab(

            'lcake_team_top_icon_colors_normal',

            [

                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_top_icon_n_color',

            [

                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '#fff',

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-icon > i' => 'color: {{VALUE}};',

                    '{{WRAPPER}} .lcake-profile-icon > svg path'  => 'stroke: {{VALUE}}; fill: {{VALUE}};',

                ],

            ]

        );

        $this->add_control(

            'lcake_team_top_icon_n_bgcolor',

            [

                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '#fc0467',

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-icon > i, {{WRAPPER}} .lcake-profile-icon > svg' => 'background-color: {{VALUE}};',

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Border::get_type(),

            [

                'name' => 'lcake_team_top_icon_n_border',

                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),

                'selector' => '{{WRAPPER}} .lcake-profile-icon > i, {{WRAPPER}} .lcake-profile-icon > svg',

            ]

        );

        $this->end_controls_tab();
        $this->start_controls_tab(

            'lcake_team_top_icon_colors_hover',

            [

                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_top_icon_h_color',

            [

                'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '',

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-icon > i:hover' => 'color: {{VALUE}};',

                    '{{WRAPPER}} .lcake-profile-icon > svg:hover path'    => 'stroke: {{VALUE}}; fill: {{VALUE}};',

                ],

            ]

        );

        $this->add_control(

            'lcake_team_top_icon_h_bgcolor',

            [

                'label' => esc_html__('Background Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '',

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-icon > i:hover, {{WRAPPER}} .lcake-profile-icon > svg:hover' => 'background-color: {{VALUE}};',

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Border::get_type(),

            [

                'name' => 'lcake_team_top_icon_h_border',

                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),

                'selector' => '{{WRAPPER}} .lcake-profile-icon > i:hover, {{WRAPPER}} .lcake-profile-icon > svg:hover',

            ]

        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Name Styles
        $this->start_controls_section(

            'lcake_team_name_style',
            [

                'label' => esc_html__('Name', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Typography::get_type(),
            [

                'name'       => 'lcake_team_name_typography',

                'selector'   => '{{WRAPPER}} .lcake-profile-body .lcake-profile-title',

            ]

        );

        $this->start_controls_tabs(

            'lcake_team_name_tabs'

        );

        $this->start_controls_tab(

            'lcake_team_name_normal',

            [

                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_name_color',

            [

                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-profile-body .lcake-profile-title' => 'color: {{VALUE}};'

                ],

            ]

        );

        $this->end_controls_tab();

        $this->start_controls_tab(

            'lcake_team_name_hover',

            [

                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_name_hover_color',

            [

                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-profile-body:hover .profile-title' => 'color: {{VALUE}};',

                    '{{WRAPPER}} .lcake-profile-card:hover .profile-title' => 'color: {{VALUE}} !important',

                ],

            ]

        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(

            'lcake_team_name_margin',

            [

                'label'         => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),

                'type'          => \Elementor\Controls_Manager::SLIDER,

                'size_units'    => ['px', 'em'],

                'separator' => 'before',

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-body .lcake-profile-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                ],

            ]

        );

        $this->end_controls_section();

        // Position Styles
        $this->start_controls_section(

            'lcake_team_position_style',
            [

                'label' => esc_html__('Member Position', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Typography::get_type(),
            [

                'name'       => 'lcake_team_position_typography',

                'selector'   => '{{WRAPPER}} .lcake-profile-body .lcake-profile-designation',

            ]

        );

        $this->start_controls_tabs(

            'lcake_team_position_tabs'

        );

        $this->start_controls_tab(

            'lcake_team_position_normal',

            [

                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_position_color',

            [

                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-profile-body .lcake-profile-designation' => 'color: {{VALUE}};'

                ],

            ]

        );

        $this->end_controls_tab();

        $this->start_controls_tab(

            'lcake_team_position_hover',

            [

                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_position_hover_color',

            [

                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-profile-card:hover .lcake-profile-body .lcake-profile-designation,

                    {{WRAPPER}} .lcake-profile-body .lcake-profile-designation:hover' => 'color: {{VALUE}};'

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Text_Shadow::get_type(),
            [

                'name'       => 'lcake_team_position_hover_shadow',

                'selector'   => '{{WRAPPER}} .lcake-profile-card:hover .lcake-profile-body .profile-designation,

                {{WRAPPER}} .lcake-profile-body .profile-designation:hover',

            ]

        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(

            'lcake_team_position_margin_bottom',

            [

                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 150,

                        'step' => 1,

                    ],

                    '%' => [

                        'min' => 0,

                        'max' => 100,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-body .lcake-profile-designation' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                ],

                'separator' => 'before',

            ]

        );

        $this->end_controls_section();

        // Position Styles
        $this->start_controls_section(

            'lcake_team_text_content_style_tab',
            [

                'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Typography::get_type(),
            [

                'name'       => 'lcake_team_text_content_typography',

                'selector'   => '{{WRAPPER}} .lcake-profile-body .lcake-profile-content',

            ]

        );

        $this->start_controls_tabs(

            'lcake_team_text_content_tabs'

        );

        $this->start_controls_tab(

            'lcake_team_text_content_normal',

            [

                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_text_content_color',

            [

                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-profile-body .lcake-profile-content' => 'color: {{VALUE}};'

                ],

            ]

        );

        $this->end_controls_tab();

        $this->start_controls_tab(

            'lcake_team_text_content_hover',

            [

                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),

            ]

        );

        $this->add_control(

            'lcake_team_text_content_hover_color',

            [

                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-profile-card:hover .lcake-profile-body .lcake-profile-content' => 'color: {{VALUE}};',

                    '{{WRAPPER}} .lcake-profile-image-card:hover .lcake-profile-body .lcake-profile-content' => 'color: {{VALUE}};',

                ],

            ]

        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(

            'lcake_team_text_content_margin_bottom',

            [

                'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%', 'em'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-profile-body .lcake-profile-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

                'separator' => 'before',

            ]

        );

        $this->end_controls_section();

        // Social Styles
        $this->start_controls_section(

            'lcake_team_social_style',
            [

                'label' => esc_html__('Social  Profiles', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

                'condition' => [

                    'lcake_team_social_enable' => 'yes'

                ]

            ]

        );

        // Alignment
        $this->add_responsive_control(

            'lcake_socialmedai_list_item_align',

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

                'toggle' => true,

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-social-list' => 'text-align: {{VALUE}};',

                    $popup_selector . ' .lcake-team-social-list' => 'text-align: {{VALUE}};',

                ],

            ]

        );

        // Display design
        $this->add_responsive_control(

            'lcake_socialmedai_list_display',

            [

                'label' => esc_html__('Display', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SELECT,

                'default' => 'inline-block',

                'options' => [

                    'inline-block' => esc_html__('Inline Block', 'lc-addons-kit-for-elementor'),

                    'block' => esc_html__('Block', 'lc-addons-kit-for-elementor'),

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-social-list > li' => 'display: {{VALUE}};',

                    $popup_selector . ' .lcake-team-social-list > li' => 'display: {{VALUE}};',

                ],

            ]

        );

        // border radius
        $this->add_responsive_control(

            'lcake_socialmedai_list_border_radius',

            [

                'label' => esc_html__('Border radius', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%', 'em'],

                'default' => [

                    'top' => '50',

                    'right' => '50',

                    'bottom' => '50',

                    'left' => '50',

                    'unit' => '%',

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-social-list > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-social-list > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

            ]

        );

        // Padding style
        $this->add_responsive_control(

            'lcake_socialmedai_list_padding',

            [

                'label'         => esc_html__('Padding', 'lc-addons-kit-for-elementor'),

                'type'          => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units'    => ['px', 'em'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-social-list > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-social-list > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

            ]

        );

        // margin style
        $this->add_responsive_control(

            'lcake_socialmedai_list_margin',

            [

                'label'         => esc_html__('Margin', 'lc-addons-kit-for-elementor'),

                'type'          => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units'    => ['px', 'em'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-social-list > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-social-list > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

            ]

        );


        $this->add_responsive_control(

            'lcake_socialmedai_list_icon_size',

            [

                'label' => esc_html__('Icon Size', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 1,

                        'max' => 100,

                        'step' => 5,

                    ],

                    '%' => [

                        'min' => 1,

                        'max' => 100,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-social-list > li > a i' => 'font-size: {{SIZE}}{{UNIT}};',

                    '{{WRAPPER}} .lcake-team-social-list > li > a svg' => 'max-width: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-social-list > li > a i' => 'font-size: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-social-list > li > a svg' => 'max-width: {{SIZE}}{{UNIT}};',

                ],

            ]

        );

        $this->add_control(

            'lcake_socialmedai_list_style_use_height_and_width',

            [

                'label' => esc_html__('Use Height Width', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SWITCHER,

                'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),

                'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),

                'return_value' => 'yes',

                'default' => 'no',

            ]

        );

        $this->add_responsive_control(

            'lcake_socialmedai_list_width',

            [

                'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 200,

                        'step' => 1,

                    ],

                    '%' => [

                        'min' => 0,

                        'max' => 100,

                    ],

                ],

                'default' => [

                    'unit' => 'px',

                    'size' => 30,

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-social-list > li > a' => 'width: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-social-list > li > a' => 'width: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_socialmedai_list_style_use_height_and_width' => 'yes'

                ]

            ]

        );

        $this->add_responsive_control(

            'lcake_socialmedai_list_height',

            [

                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 200,

                        'step' => 1,

                    ],

                    '%' => [

                        'min' => 0,

                        'max' => 100,

                    ],

                ],

                'default' => [

                    'unit' => 'px',

                    'size' => 30,

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-social-list > li > a' => 'height: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-social-list > li > a' => 'height: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_socialmedai_list_style_use_height_and_width' => 'yes'

                ]

            ]

        );

        $this->add_responsive_control(

            'lcake_socialmedai_list_line_height',

            [

                'label' => esc_html__('Line Height', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 200,

                        'step' => 1,

                    ],

                    '%' => [

                        'min' => 0,

                        'max' => 100,

                    ],

                ],

                'default' => [

                    'unit' => 'px',

                    'size' => 30,

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-social-list > li > a' => 'line-height: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-social-list > li > a' => 'line-height: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_socialmedai_list_style_use_height_and_width' => 'yes'

                ]

            ]

        );

        $this->end_controls_section();

        // Overlay Styles

        $this->start_controls_section(

            'lcake_team_overlay_style',
            [

                'label' => esc_html__('Overlay', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

                'condition' => [

                    'team_style' => 'overlay',

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Background::get_type(),

            [

                'name' => 'lcake_team_background_overlay',

                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),

                'types' => ['gradient'],

                'selector' => '{{WRAPPER}} .lcake-profile-image-card:before',

            ]

        );

        $this->end_controls_section();

        // Modal Styles start here

        $this->start_controls_section(

            'lcake_team_modal_style',
            [

                'label' => esc_html__('Popup Controls', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

                'condition' => [

                    'lcake_team_chose_popup' => 'yes'

                ]

            ]

        );

        $this->add_control(

            'lcake_team_modal_heading',

            [

                'label' => esc_html__('Modal', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::HEADING,

                'separator' => 'before',

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Background::get_type(),

            [

                'name' => 'lcake_team_modal_background',

                'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),

                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .lcake-team-popup .modal-content, ' . $popup_selector . '.lcake-team-popup .modal-content',

            ]

        );

        $this->add_control(

            'lcake_team_modal_name_heading',

            [

                'label' => esc_html__('Name', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::HEADING,

                'separator' => 'before',

            ]

        );

        $this->add_control(

            'lcake_team_modal_name_color',

            [

                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-team-modal-title' => 'color: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-title' => 'color: {{VALUE}};',

                ],

            ]

        );



        $this->add_group_control(

            \Elementor\Group_Control_Typography::get_type(),
            [

                'name'       => 'lcake_team_modal_name_typography',

                'selector'   => '{{WRAPPER}} .lcake-team-modal-title,' . $popup_selector . ' .lcake-team-modal-title',

            ]

        );



        $this->add_responsive_control(

            'lcake_team_modal_name_margin_bottom',

            [

                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 150,

                        'step' => 1,

                    ],

                    '%' => [

                        'min' => 0,

                        'max' => 100,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                ],

            ]

        );



        $this->add_control(

            'lcake_team_modal_position_heading',

            [

                'label' => esc_html__('Member Position', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::HEADING,

                'separator' => 'before',

            ]

        );



        $this->add_control(

            'lcake_team_modal_position_color',

            [

                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-team-modal-position' => 'color: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-position' => 'color: {{VALUE}};'

                ],

            ]

        );



        $this->add_group_control(

            \Elementor\Group_Control_Typography::get_type(),
            [

                'name'       => 'lcake_team_modal_position_typography',

                'selector'   => '{{WRAPPER}} .lcake-team-modal-position,' . $popup_selector . ' .lcake-team-modal-position',

            ]

        );



        $this->add_responsive_control(

            'lcake_team_modal_position_margin_bottom',

            [

                'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'size_units' => ['px', '%'],

                'range' => [

                    'px' => [

                        'min' => 0,

                        'max' => 150,

                        'step' => 1,

                    ],

                    '%' => [

                        'min' => 0,

                        'max' => 100,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-position' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-position' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                ],

            ]

        );



        // Modal Description

        $this->add_control(

            'modal_desc',

            [

                'label'     => esc_html__('Description', 'lc-addons-kit-for-elementor'),

                'type'      => \Elementor\Controls_Manager::HEADING,

                'separator' => 'before',

            ]

        );



        // Modal Description - Color

        $this->add_control(

            'modal_desc_color',

            [

                'label'     => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'      => \Elementor\Controls_Manager::COLOR,

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-content'  => 'color: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-content'  => 'color: {{VALUE}};',

                ]

            ]

        );



        // Modal Description - Typography

        $this->add_group_control(

            \Elementor\Group_Control_Typography::get_type(),
            [

                'name'       => 'modal_desc_font',

                'selector'   => '{{WRAPPER}} .lcake-team-modal-content,' .  $popup_selector . ' .lcake-team-modal-content',

            ]

        );



        // Modal Description - Margin Bottom

        $this->add_responsive_control(

            'modal_desc_margin_bottom',

            [

                'label'         => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),

                'type'          => \Elementor\Controls_Manager::SLIDER,

                'size_units'    => ['px', '%'],

                'range'         => [

                    'px' => [

                        'min'   => 0,

                        'max'   => 150,

                        'step'  => 1,

                    ],

                    '%'  => [

                        'min'   => 0,

                        'max'   => 100,

                    ],

                ],

                'selectors'     => [

                    '{{WRAPPER}} .lcake-team-modal-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                ],

            ]

        );



        $this->add_control(

            'more_options',

            [

                'label' => esc_html__('Phone and Email', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::HEADING,

                'separator' => 'before',

            ]

        );





        $this->add_group_control(

            \Elementor\Group_Control_Typography::get_type(),
            [

                'name'       => 'lcake_team_info_typography',

                'selector'   => '{{WRAPPER}} .lcake-team-modal-list,' . $popup_selector . ' .lcake-team-modal-list',

            ]

        );



        $this->add_control(

            'lcake_team_info_color',

            [

                'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-team-modal-list' => 'color: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-list' => 'color: {{VALUE}};'

                ],

            ]

        );



        $this->add_control(

            'lcake_team_info_hover_color',

            [

                'label'      => esc_html__('Color Hover', 'lc-addons-kit-for-elementor'),

                'type'       => \Elementor\Controls_Manager::COLOR,

                'selectors'  => [

                    '{{WRAPPER}} .lcake-team-modal-list a:hover' => 'color: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-list a:hover' => 'color: {{VALUE}};'

                ],

            ]

        );



        $this->end_controls_section();



        $this->start_controls_section(

            'lcake_team_close_icon',

            [

                'label' => esc_html__('Close Icon', 'lc-addons-kit-for-elementor'),

                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

                'condition' => [

                    'lcake_team_chose_popup' => 'yes'

                ]

            ]

        );



        $this->start_controls_tabs('lcake_icon_box_icon_colors');



        $this->start_controls_tab(

            'lcake_team_icon_colors_normal',

            [

                'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),

            ]

        );



        $this->add_control(

            'lcake_team_icon_primary_color',

            [

                'label' => esc_html__('Icon Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '#656565',

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close' => 'color: {{VALUE}};',

                    '{{WRAPPER}} .lcake-team-modal-close svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-close' => 'color: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-close svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',

                ],

            ]

        );



        $this->add_control(

            'lcake_team_icon_secondary_color_normal',

            [

                'label' => esc_html__('Icon BG Color', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '',

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close' => 'background-color: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-close' => 'background-color: {{VALUE}};',

                ],

            ]

        );



        $this->add_group_control(

            \Elementor\Group_Control_Border::get_type(),

            [

                'name' => 'lcake_team_border',

                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),

                'selector' => '{{WRAPPER}} .lcake-team-modal-close,' . $popup_selector . ' .lcake-team-modal-close',

            ]

        );







        $this->add_responsive_control(

            'lcake_team_icon_border_radius',

            [

                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Box_Shadow::get_type(),

            [

                'name' => 'lcake_icon_icon_box_shadow_normal_group',

                'selector' => '{{WRAPPER}} .lcake-team-modal-close,' . $popup_selector . ' .lcake-team-modal-close',

            ]

        );

        $this->end_controls_tab();



        $this->start_controls_tab(

            'lcake_team_icon_colors_hover',

            [

                'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),

            ]

        );



        $this->add_control(

            'lcake_team_hover_primary_color',

            [

                'label' => esc_html__('Icon Color (Hover)', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '',

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close:hover' => 'color: {{VALUE}};',

                    '{{WRAPPER}} .lcake-team-modal-close:hover svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-close:hover' => 'color: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-close:hover svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',

                ],

            ]

        );



        $this->add_control(

            'lcake_team_hover_background_color',

            [

                'label' => esc_html__('Icon BG Color (Hover)', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::COLOR,

                'default' => '',

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close:hover' => 'background-color: {{VALUE}};',

                    $popup_selector . ' .lcake-team-modal-close:hover' => 'background-color: {{VALUE}};',

                ],

            ]

        );



        $this->add_group_control(

            \Elementor\Group_Control_Border::get_type(),

            [

                'name' => 'lcake_team_border_icon_group',

                'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),

                'selector' => '{{WRAPPER}} .lcake-team-modal-close:hover,' . $popup_selector . ' .lcake-team-modal-close:hover',

            ]

        );



        $this->add_responsive_control(

            'lcake_icon_box_icons_hover_border_radius',

            [

                'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-close:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

            ]

        );

        $this->add_group_control(

            \Elementor\Group_Control_Box_Shadow::get_type(),

            [

                'name' => 'lcake_team_shadow_group',

                'selector' => '{{WRAPPER}} .lcake-team-modal-close:hover,' . $popup_selector . ' .lcake-team-modal-close:hover',

            ]

        );

        $this->end_controls_tab();



        $this->end_controls_tabs();

        $this->add_responsive_control(

            'lcake_team_close_icon_size',

            [

                'label' => esc_html__('Font Size', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'range' => [

                    'px' => [

                        'min' => 6,

                        'max' => 300,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close' => 'font-size: {{SIZE}}{{UNIT}};',

                    '{{WRAPPER}} .lcake-team-modal-close svg' => 'max-width: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-close' => 'font-size: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-close svg' => 'max-width: {{SIZE}}{{UNIT}};',

                ],

                'separator' => 'before',

            ]

        );



        $this->add_responsive_control(

            'lcake_team_close_icon_padding',

            [

                'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::DIMENSIONS,

                'size_units' => ['px', '%', 'em'],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],

            ]

        );



        $this->add_responsive_control(

            'lcake_team_close_icon_enable_height_width',

            [

                'label' => esc_html__('Use Height Width', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SWITCHER,

                'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),

                'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),

                'return_value' => 'yes',

                'default' => '',

            ]

        );



        $this->add_responsive_control(

            'lcake_team_close_icon_width',

            [

                'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'range' => [

                    'px' => [

                        'min' => 10,

                        'max' => 200,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close' => 'width: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-close' => 'width: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_team_close_icon_enable_height_width' => 'yes',

                ],

            ]

        );



        $this->add_responsive_control(

            'lcake_team_close_icon_height',

            [

                'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'range' => [

                    'px' => [

                        'min' => 10,

                        'max' => 200,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close' => 'height: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-close' => 'height: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_team_close_icon_enable_height_width' => 'yes',

                ],

            ]

        );



        $this->add_responsive_control(

            'lcake_team_close_icon_line_height',

            [

                'label' => esc_html__('Line Height', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'range' => [

                    'px' => [

                        'min' => 10,

                        'max' => 200,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-team-modal-close' => 'line-height: {{SIZE}}{{UNIT}};',

                    $popup_selector . ' .lcake-team-modal-close' => 'line-height: {{SIZE}}{{UNIT}};',

                ],

                'condition' => [

                    'lcake_team_close_icon_enable_height_width' => 'yes',

                ],



            ]

        );



        $this->add_responsive_control(

            'lcake_team_close_icon_vertical_align',

            [

                'label' => esc_html__('Vertical Position ', 'lc-addons-kit-for-elementor'),

                'type' => \Elementor\Controls_Manager::SLIDER,

                'range' => [

                    'px' => [

                        'min' => -200,

                        'max' => 200,

                    ],

                ],

                'selectors' => [

                    '{{WRAPPER}} .lcake-infobox .lcake-box-header .lcake-info-box-icon' => ' -webkit-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}});',

                    $popup_selector . ' .lcake-infobox .lcake-box-header .lcake-info-box-icon' => ' -webkit-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}});',

                ],

                'condition' => [

                    'lcake_icon_box_icon_position!' => 'top'

                ]



            ]

        );



        $this->end_controls_section();
    }



    protected function render()
    {

        echo '<div class="lcake-main-wrapper">';

        echo    $this->render_template();

        echo   '</div>';
    }



    protected function render_template()
    {

        $settings = $this->get_settings_for_display();

        extract($settings);





        // Image sectionn

        $image_html = '';

        if (!empty($lcake_team_image['url'])) {

            $this->add_render_attribute('image', 'src', $lcake_team_image['url']);

            $this->add_render_attribute('image', 'alt', \Elementor\Control_Media::get_image_alt($lcake_team_image));

            $this->add_render_attribute('image', 'title', \Elementor\Control_Media::get_image_title($lcake_team_image));



            $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'lcake_team_thumbnail', 'lcake_team_image');
        }



        $this->add_render_attribute(

            'profile_card',

            [

                'class' => 'lcake-profile-card elementor-animation-' . $team_hover_animation . ' ' . $lcake_team_content_text_align . ' lcake-team-style-' . $lcake_team_style,

            ]

        );



        if (in_array($lcake_team_style, array('default', 'centered_style', 'centered_style_details', 'long_height_details', 'long_height_details_hover'))):

?>

            <?php if ($lcake_team_style == 'centered_style'): ?> <div class="lcake-profile-square-v"> <?php endif; ?>

                <?php if ($lcake_team_style == 'centered_style_details'): ?> <div class="lcake-profile-square-v square-v5 no_gutters"> <?php endif; ?>

                    <?php if ($lcake_team_style == 'long_height_details'): ?> <div class="lcake-profile-square-v square-v6 no_gutters"> <?php endif; ?>

                        <?php if ($lcake_team_style == 'long_height_details_hover'): ?> <div class="lcake-profile-square-v square-v6 square-v6-v2 no_gutters"><?php endif; ?>



                            <div <?php echo $this->get_render_attribute_string('profile_card'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped by elementor 
                                    ?>>

                                <?php if ($settings['lcake_team_chose_popup'] == 'yes') : ?>

                                    <a aria-label="profile" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#lcake_team_modal_<?php echo esc_attr($this->get_id() . '_' . get_the_ID()); ?>" class="lcake-team-popup">

                                    <?php endif; ?>



                                    <div class="lcake-profile-header lcake-team-img <?php echo esc_attr($lcake_team_style == 'default' ? 'lcake-img-overlay lcake-team-img-block' : ''); ?>" <?php if ((isset($settings['lcake_team_chose_popup']) ? $lcake_team_chose_popup : 'no')  == 'yes') : ?> data-bs-toggle="modal" data-bs-target="#lcake_team_modal_<?php echo esc_attr($this->get_id() . '_' . get_the_ID()); ?>" <?php endif; ?>>

                                        <?php echo wp_kses($image_html, \LCAKE_Kit_Utils::get_kses_array()); ?>

                                    </div><!-- .profile-header END -->

                                    <?php if ($settings['lcake_team_chose_popup'] == 'yes') : ?>

                                    </a>

                                <?php endif; ?>





                                <div class="lcake-profile-body">

                                    <?php if ('default' == $lcake_team_style && 'yes' == $lcake_team_toggle_icon && !empty($lcake_team_top_icons)): ?>

                                        <div class="lcake-profile-icon<?php echo esc_attr($lcake_team_top_icon_align) ? ' icon-align-' . esc_attr($lcake_team_top_icon_align) : ''; ?>">



                                            <?php

                                            // new icon

                                            $migrated = isset($settings['__fa4_migrated']['lcake_team_top_icons']);

                                            // Check if its a new widget without previously selected icon using the old Icon control

                                            $is_new = empty($settings['lcake_team_top_icon']);

                                            if ($is_new || $migrated) {

                                                // new icon

                                                Icons_Manager::render_icon($settings['lcake_team_top_icons'], ['aria-hidden' => 'true']);
                                            } else {

                                            ?>

                                                <i class="<?php echo esc_attr($settings['lcake_team_top_icon']); ?>" aria-hidden="true"></i>

                                            <?php

                                            }

                                            ?>

                                        </div>

                                    <?php endif; ?>



                                    <h2 class="lcake-profile-title">

                                        <?php if ($settings['lcake_team_chose_popup'] == 'yes') : ?>

                                            <a aria-label="profile" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#lcake_team_modal_<?php echo esc_attr($this->get_id() . '_' . get_the_ID()); ?>" class="lcake-team-popup">

                                                <?php echo esc_html($lcake_team_name); ?>

                                            </a>

                                        <?php else: ?>

                                            <?php echo esc_html($lcake_team_name); ?>

                                        <?php endif; ?>

                                    </h2>

                                    <p class="lcake-profile-designation"><?php echo esc_html($lcake_team_position); ?></p>

                                    <?php if ($lcake_team_show_short_description == 'yes' && $lcake_team_short_description != ''): ?>

                                        <p class="lcake-profile-content"><?php echo wp_kses($lcake_team_short_description, \LCAKE_Kit_Utils::get_kses_array()); ?></p>

                                    <?php endif; ?>

                                </div><!-- .profile-body END -->







                                <?php

                                if (isset($lcake_team_social_enable) && $lcake_team_social_enable == 'yes') { ?>

                                    <div class="lcake-profile-footer">

                                        <?php if (!empty($lcake_team_social_icons) && is_array($lcake_team_social_icons)) :

                                            foreach ($lcake_team_social_icons as $icon) {

                                                $item_key = 'social_item_' . $icon['_id'];

                                                $link_key = 'social_link_' . $icon['_id'];

                                                $this->add_render_attribute($item_key, 'class', 'elementor-repeater-item-' . $icon['_id']);

                                                if (!empty($icon['lcake_team_label'])) {

                                                    $this->add_render_attribute($link_key, 'aria-label', esc_attr($icon['lcake_team_label']));
                                                }

                                                if (!empty($icon['lcake_team_link']['url'])) {

                                                    $this->add_render_attribute($link_key, 'href', esc_url($icon['lcake_team_link']['url']));
                                                } else {

                                                    $this->add_render_attribute($link_key, 'href', 'javascript:void(0)');
                                                }

                                                if (!empty($icon['lcake_team_link']['is_external'])) {

                                                    $this->add_render_attribute($link_key, 'target', '_blank');

                                                    $this->add_render_attribute($link_key, 'rel', 'noopener noreferrer');
                                                }
                                            }

                                            require LCAKE_EAK_PATH . 'includes/widgets/lc-kit/team/parts/social-list.php';

                                        endif; ?>

                                    </div>

                                <?php

                                }

                                ?>

                            </div>

                            <?php if (in_array($lcake_team_style, array('centered_style', 'centered_style_details', 'long_height_details', 'long_height_details_hover'))): ?>
                            </div> <?php endif; ?>

                    <?php endif; ?>



                    <?php if (in_array($lcake_team_style, array('overlay', 'overlay_details', 'long_height_hover', 'overlay_circle', 'overlay_circle_hover'))): ?>

                        <?php if ($lcake_team_style == 'overlay_details'): ?> <div class="lcake-image-card-v2"> <?php endif; ?>

                            <?php if ($lcake_team_style == 'long_height_hover'): ?> <div class="<?php echo esc_attr($settings['lcake_team_remove_gutters'] == 'yes' ? '' : 'small-gutters'); ?> lcake-image-card-v3"> <?php endif; ?>

                                <?php if ($lcake_team_style == 'overlay_circle'): ?> <div class="lcake-style-circle lcake-team-img-fit"> <?php endif; ?>

                                    <?php if ($lcake_team_style == 'overlay_circle_hover'): ?> <div class="lcake-image-card-v2 lcake-style-circle"> <?php endif; ?>

                                        <div class="lcake-profile-image-card elementor-animation-<?php echo esc_attr($team_hover_animation) ?> lcake-team-img lcake-team-style-<?php echo esc_attr($lcake_team_style); ?> <?php if (isset($lcake_team_content_text_align)) {
                                                                                                                                                                                                                                echo esc_attr($lcake_team_content_text_align);
                                                                                                                                                                                                                            } ?>">



                                            <?php if ($lcake_team_style == 'long_height_hover') { ?>

                                                <?php echo wp_kses($image_html, \LCAKE_Kit_Utils::get_kses_array()); ?>

                                            <?php

                                                $modalClass = 'team-sidebar_' . $lcake_team_style . '';
                                            } else {

                                                $modalClass = 'team-modal_' . $lcake_team_style . '';

                                            ?>

                                                <?php echo wp_kses($image_html, \LCAKE_Kit_Utils::get_kses_array()); ?>

                                            <?php } ?>

                                            <div class="lcake-hover-area">

                                                <div class="lcake-profile-body">

                                                    <h2 class="lcake-profile-title">

                                                        <?php if ($settings['lcake_team_chose_popup'] == 'yes') : ?>

                                                            <a aria-label="profile" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#lcake_team_modal_<?php echo esc_attr($this->get_id() . '_' . get_the_ID()); ?>" class="lcake-team-popup">

                                                                <?php echo esc_html($lcake_team_name); ?>

                                                            </a>

                                                        <?php else: ?>

                                                            <?php echo esc_html($lcake_team_name); ?>

                                                        <?php endif; ?>

                                                    </h2>

                                                    <p class="lcake-profile-designation"><?php echo esc_html($lcake_team_position); ?></p>

                                                    <?php if ($lcake_team_show_short_description == 'yes' && $lcake_team_short_description != ''): ?>

                                                        <p class="lcake-profile-content"><?php echo wp_kses($lcake_team_short_description, \LCAKE_Kit_Utils::get_kses_array()); ?></p>

                                                    <?php endif; ?>

                                                </div>

                                                <?php if (isset($lcake_team_social_enable) && $lcake_team_social_enable == 'yes') { ?>

                                                    <div class="lcake-profile-footer">

                                                        <?php

                                                        if (!empty($lcake_team_social_icons) && is_array($lcake_team_social_icons)) {

                                                            foreach ($lcake_team_social_icons as $icon) {

                                                                $item_key = 'social_item_' . $icon['_id'];

                                                                $link_key = 'social_link_' . $icon['_id'];

                                                                $this->add_render_attribute($item_key, 'class', 'elementor-repeater-item-' . $icon['_id']);

                                                                if (!empty($icon['lcake_team_label'])) {

                                                                    $this->add_render_attribute($link_key, 'aria-label', esc_attr($icon['lcake_team_label']));
                                                                }

                                                                if (!empty($icon['lcake_team_link']['url'])) {

                                                                    $this->add_render_attribute($link_key, 'href', esc_url($icon['lcake_team_link']['url']));
                                                                } else {

                                                                    $this->add_render_attribute($link_key, 'href', 'javascript:void(0)');
                                                                }

                                                                if (!empty($icon['lcake_team_link']['is_external'])) {

                                                                    $this->add_render_attribute($link_key, 'target', '_blank');

                                                                    $this->add_render_attribute($link_key, 'rel', 'noopener noreferrer');
                                                                }
                                                            }
                                                        }

                                                        require LCAKE_EAK_PATH . 'includes/widgets/lc-kit/team/parts/social-list.php';

                                                        ?>

                                                    </div>

                                                <?php

                                                }

                                                ?>

                                            </div>

                                        </div>

                                        <?php if (in_array($lcake_team_style, array('overlay_details', 'long_height_hover', 'overlay_circle', 'overlay_circle_hover'))): ?>
                                        </div> <?php endif; ?>



                                <?php

                            endif;

                            if ('hover_info' == $lcake_team_style):

                                ?>


                                    <div class="lcake-profile-square-v square-v4 elementor-animation-<?php echo esc_attr($team_hover_animation) ?> lcake-team-style-<?php echo esc_attr($lcake_team_style); ?>">

                                        <div class="lcake-profile-card <?php if (isset($lcake_team_content_text_align)) {
                                                                            echo esc_attr($lcake_team_content_text_align);
                                                                        } ?>">

                                            <div class="lcake-profile-header lcake-team-img" <?php if ($settings['lcake_team_chose_popup'] == 'yes') : ?> data-bs-toggle="modal" data-bs-target="#lcake_team_modal_<?php echo esc_attr($this->get_id() . '_' . get_the_ID()); ?>" <?php endif; ?>>

                                                <?php echo wp_kses($image_html, \LCAKE_Kit_Utils::get_kses_array()); ?>

                                            </div><!-- .profile-header END -->

                                            <div class="lcake-profile-body">

                                                <h2 class="lcake-profile-title">

                                                    <?php if ($settings['lcake_team_chose_popup'] == 'yes') : ?>

                                                        <a aria-label="profile" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#lcake_team_modal_<?php echo esc_attr($this->get_id() . '_' . get_the_ID()); ?>" class="lcake-team-popup">

                                                            <?php echo esc_html($lcake_team_name); ?>

                                                        </a>

                                                    <?php else: ?>

                                                        <?php echo esc_html($lcake_team_name); ?>

                                                    <?php endif; ?>

                                                </h2>

                                                <p class="lcake-profile-designation"><?php echo esc_html($lcake_team_position); ?></p>

                                                <?php if ($lcake_team_show_short_description == 'yes' && $lcake_team_short_description != ''): ?>

                                                    <p class="lcake-profile-content"><?php echo wp_kses($lcake_team_short_description, \LCAKE_Kit_Utils::get_kses_array()); ?></p>

                                                <?php endif; ?>

                                                <?php

                                                if (isset($lcake_team_social_enable) && $lcake_team_social_enable == 'yes') {

                                                    require LCAKE_EAK_PATH . 'includes/widgets/lc-kit/team/parts/social-list.php';
                                                }

                                                ?>

                                            </div>

                                        </div>

                                    </div>

                                <?php endif; ?>



                        <?php if ($lcake_team_chose_popup == 'yes'):
                            $lcake_modal_close_align = isset($lcake_team_close_icon_alignment) ? $lcake_team_close_icon_alignment : 'right';
                            require_once LCAKE_EAK_PATH . 'includes/widgets/lc-kit/team/components/popup.php';

                        endif;
                    }
                }
