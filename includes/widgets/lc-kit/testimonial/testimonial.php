<?php

/**
 * Testimonial Widget (Standalone)
 *
 * Drop this file into your plugin and include it when registering widgets.
 * Works without namespaces.
 *
 * @package LC_Elementor_Addons_Kit
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class LCAKE_Kit_Testimonial extends \Elementor\Widget_Base
{

	/*---------------------------
	 * Meta
	 *--------------------------*/

	public function get_name()
	{
		return 'lcake_kit_testimonial';
	}

	public function get_title()
	{
		return __('LC Testimonial', 'lc-elementor-addons-kit');
	}

	public function get_icon()
	{
		return 'eicon-testimonial';
	}
	
	public function get_categories()
	{
		return array('lcake-page-kit');
	}

	public function get_keywords()
	{
		return array('testimonial', 'review', 'quote', 'feedback', 'client', 'rating');
	}

	public function get_script_depends()
	{
		return ['lcake-kit-testimonial-js', 'lcake-kit-swiper-js','lcake-btsp-js'];
	}

	public function get_style_depends()
	{
		return ['lcake-kit-testimonial-css', 'lcake-kit-swiper-css', 'lcake-btsp-css'];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'lcake_testimonial_layout_section_tab_style',
			[
				'label' => esc_html__('Layout', 'lc-addons-kit-for-elementor'),
			]
		);


		// Card style

		$this->add_control(
			'lcake_testimonial_style',
			[
				'label' => esc_html__('Choose Style', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'style1' => 'Style 1',
					'style2' => 'Style 2',
					'style3' => 'Style 3',
					'style4' => 'Style 4',
					'style5' => 'Style 5',
					'style6' => 'Style 6'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lcake_testimonial_section_tab_style',
			[
				'label' => esc_html__('Testimonial', 'lc-addons-kit-for-elementor'),
			]
		);

		// enable warter mark icon
		$this->add_control(
			'lcake_testimonial_wartermark_enable',
			[
				'label' => esc_html__('Enable Quote Icon', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'lcake_testimonial_style' => ['style2', 'style4', 'style5', 'style6']
				]
			]
		);

		$this->add_control(
			'lcake_testimonial_wartermarks',
			[
				'label' => esc_html__('Quote Icon', 'lc-addons-kit-for-elementor'),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'lcake_testimonial_wartermark',
				'default' => [
					'value' => 'icon icon-quote',
					'library' => 'lcakeicons',
				],
				'condition' => [
					'lcake_testimonial_wartermark_enable' => 'yes',
					'lcake_testimonial_style' => ['style2', 'style4', 'style5', 'style6'],
				],
			]
		);

		// water mark position
		$this->add_control(
			'lcake_testimonial_wartermark_position',
			[
				'label' => esc_html__('Quote Icon Position', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'bottom',
				'separator'    => 'before',
				'options' => [
					'top'  => esc_html__('Top', 'lc-addons-kit-for-elementor'),
					'bottom' => esc_html__('Bottom', 'lc-addons-kit-for-elementor'),
				],
				'condition' => [
					'lcake_testimonial_wartermark_enable' => 'yes',
					'lcake_testimonial_style' => ['style5']
				],
				'selectors_dictionary' => [
					'top' => 'position: unset;',
					'bottom' => 'bottom: 30px; right: 30px;',
				],
				'selectors' => [
					'{{WRAPPER}} .lcake_testimonial_style_5 .lcake-watermark-icon' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lcake_testimonial_wartermark_mask_show_badge',
			[
				'label' => esc_html__('Show Quote Icon Badge', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator'    => 'before',
				'condition' => [
					'lcake_testimonial_wartermark_enable' => 'yes',
					'lcake_testimonial_style' => ['style6']
				]
			]
		);

		$this->add_control(
			'lcake_testimonial_wartermark_custom_position',
			[
				'label' => esc_html__('Custom Position', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('Hide', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => 'no',
				'separator'	=> 'before',
				'condition' => [
					'lcake_testimonial_wartermark_enable' => 'yes',
					'lcake_testimonial_style'			 => 'style2',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_wartermark_custom_position_offset_x',
			[
				'label' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake_watermark_icon_custom_position' => 'left: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'lcake_testimonial_wartermark_enable'		  => 'yes',
					'lcake_testimonial_wartermark_custom_position' => 'yes',
					'lcake_testimonial_style'			 		  => 'style2',
				]
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_wartermark_custom_position_offset_y',
			[
				'label' => esc_html__('top', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake_watermark_icon_custom_position' => 'top: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'lcake_testimonial_wartermark_enable' 		  => 'yes',
					'lcake_testimonial_wartermark_custom_position' => 'yes',
					'lcake_testimonial_style'			 		  => 'style2',
				]
			]
		);

		$this->add_control(
			'lcake_testimonial_before_rating',
			[
				'type' 		=> \Elementor\Controls_Manager::DIVIDER,
				'condition'	=> [
					'lcake_testimonial_style!' => ['style1', 'style3'],
				],
			]
		);

		// enable rating
		$this->add_control(
			'lcake_testimonial_rating_enable',
			[
				'label' => esc_html__('Enable Rating', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'lcake_testimonial_style' => ['style3', 'style4', 'style5', 'style6']
				]
			]
		);

		// enable title separetor
		$this->add_control(
			'lcake_testimonial_title_separetor',
			[
				'label'     => esc_html__('Show Separator', 'lc-addons-kit-for-elementor'),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'default'   => 'yes',
				'condition' => [
					'lcake_testimonial_style' => ['style1', 'style2'],
				]
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'client_name',
			[
				'label' => esc_html__('Client Name', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__('Testimonial #1', 'lc-addons-kit-for-elementor'),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'designation',
			[
				'label' => esc_html__('Designation', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => esc_html__('Designation', 'lc-addons-kit-for-elementor'),
			]
		);

		$repeater->add_control(
			'review',
			[
				'label' => esc_html__('Testimonial Review', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => esc_html__('Review Text', 'lc-addons-kit-for-elementor'),
			]
		);

		$repeater->add_control(
			'rating',
			[
				'label' => esc_html__('Testimonial Rating', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '5',
				'options'   => [
					'5'     => esc_html__('5', 'lc-addons-kit-for-elementor'),
					'4'     => esc_html__('4', 'lc-addons-kit-for-elementor'),
					'3'     => esc_html__('3', 'lc-addons-kit-for-elementor'),
					'2'     => esc_html__('2', 'lc-addons-kit-for-elementor'),
					'1'     => esc_html__('1', 'lc-addons-kit-for-elementor'),
				],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'			=> esc_html__('Link', 'lc-addons-kit-for-elementor'),
				'type'			=> \Elementor\Controls_Manager::URL,
				'dynamic'		=> [
					'active' => true,
				],
				'placeholder'	=> esc_url('https://wpmet.com', 'lc-addons-kit-for-elementor'),
			]
		);

		$repeater->add_control(
			'client_photo',
			[
				'label' => esc_html__('Client Avatar', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
					'id'    => -1
				],
				'separator'	=> 'before',
			]
		);

		$repeater->add_control(
			'client_logo',
			[
				'label' => esc_html__('Logo', 'lc-addons-kit-for-elementor'),
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

		$repeater->add_control(
			'use_hover_logo',
			[
				'label' => esc_html__('Display different logo on hover?', 'lc-addons-kit-for-elementor'),
				'description' => esc_html__('This option only work for style 1 & 2', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'default' => 'no',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'client_logo_active',
			[
				'label' => esc_html__('Logo Active', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
					'id'    => -1
				],
				'condition' => ['use_hover_logo' => 'yes'],
			]
		);

		$repeater->add_control(
			'lcake_testimonial_active',
			[
				'label' => esc_html__('Active Testimonial?', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_background_group',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic'],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
			]
		);
		$this->add_control(
			'lcake_testimonial_data',
			[
				'label' => esc_html__('Testimonial', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'default' => [
					['client_name' => esc_html__('Testimonial #1', 'lc-addons-kit-for-elementor')],
					['client_name' => esc_html__('Testimonial #2', 'lc-addons-kit-for-elementor')],
					['client_name' => esc_html__('Testimonial #3', 'lc-addons-kit-for-elementor')],
				],

				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ client_name }}}',
			]
		);



		$this->end_controls_section();

		// setting section

		$this->start_controls_section(
			'lcake_testimonial_layout_settings',
			[
				'label' => esc_html__('Settings', 'lc-addons-kit-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_left_right_spacing',
			[
				'label' => esc_html__('Spacing Left Right', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'desktop_default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider' => '--lcake_testimonial_left_right_spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_top_bottom_spacing',
			[
				'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_slidetoshow',
			[
				'label' => esc_html__('Slides To Show', 'lc-addons-kit-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 1,
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider' => '--lcake_testimonial_slidetoshow:  {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_slidesToScroll',
			[
				'label' => esc_html__('Slides To Scroll', 'lc-addons-kit-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'lcake_testimonial_speed',
			[
				'label' => esc_html__('Speed', 'lc-addons-kit-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10000,
				'step' => 1,
				'default' => 1000,
			]
		);

		$this->add_control(
			'lcake_testimonial_autoplay',
			[
				'label' => esc_html__('Autoplay', 'lc-addons-kit-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'lcake_testimonial_show_arrow',
			[
				'label' => esc_html__('Show Arrow', 'lc-addons-kit-for-elementor'),
				'type' =>   \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lcake_testimonial_show_dot',
			[
				'label' => esc_html__('Show Dots', 'lc-addons-kit-for-elementor'),
				'type' =>   \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lcake_testimonial_left_arrows',
			[
				'label' => esc_html__('Left Arrow Icon', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'lcake_testimonial_left_arrow',
				'default' => [
					'value' => 'lcake-left',
					'library' => 'lcakeicons',
				],
				'condition' => [
					'lcake_testimonial_show_arrow' => 'yes',
				]
			]
		);

		$this->add_control(
			'lcake_testimonial_right_arrows',
			[
				'label' => esc_html__('Right Arrow Icon', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'lcake_testimonial_right_arrow',
				'default' => [
					'value' => 'lcake-right',
					'library' => 'lcakeicons',
				],
				'condition' => [
					'lcake_testimonial_show_arrow' => 'yes',
				]
			]
		);

		$this->add_control(
			'lcake_testimonial_loop',
			[
				'label' => esc_html__('Enable Loop?', 'lc-addons-kit-for-elementor'),
				'type' =>   \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lcake_testimonial_pause_on_hover',
			[
				'label' => esc_html__('Pause on Hover', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lcake_testimonial_section_layout',
			[
				'label'	 => esc_html__('Layout', 'lc-addons-kit-for-elementor'),
				'tab'	 => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_layout_margin',
			[
				'label'         => esc_html__('Column Gap', 'lc-addons-kit-for-elementor'),
				'type'          => \Elementor\Controls_Manager::SLIDER,
				'size_units'    => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-testimonial-slider,
						{{WRAPPER}} .lcake-testimonial-item,
						{{WRAPPER}} .lcake-testimonial-card' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'lcake_testimonial_layout_padding',
			[
				'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-content, {{WRAPPER}} .lcake-single-testimonial-slider, {{WRAPPER}} .lcake-testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_parent_container_margin',
			[
				'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider-block-style' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'lcake_testimonial_style' => ['style4']
				]
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_layout_border_radius',
			[
				'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-content, {{WRAPPER}} .lcake-single-testimonial-slider, {{WRAPPER}} .lcake-testimonial-card' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('lcake_testimonial_wrapper_tabs');
		$this->start_controls_tab(
			'lcake_testimonial_wrapper_tab_normal',
			[
				'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_layout_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-commentor-content, {{WRAPPER}} .lcake-single-testimonial-slider, {{WRAPPER}} .lcake-testimonial-card',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lcake_testimonial_layout_border',
				'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-single-testimonial-slider, {{WRAPPER}} .lcake-testimonial-card',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'lcake_testimonial_layout_shadow',
				'selector'  => '{{WRAPPER}} .lcake-commentor-content, {{WRAPPER}} .lcake-single-testimonial-slider, {{WRAPPER}} .lcake-testimonial-card',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_testimonial_wrapper_tab_hover',
			[
				'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_layout_active_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-single-testimonial-slider:before, {{WRAPPER}} .lcake-testimonial-card:before',
			]
		);

		$this->add_control(
			'lcake_testimonial_layout_active_border_color',
			[
				'label' => esc_html__('Border Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lcake-single-testimonial-slider:hover, {{WRAPPER}} .lcake-testimonial-card:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'lcake_testimonial_layout_hover_shadow',
				'selector'  => '{{WRAPPER}} .lcake-commentor-content:hover, {{WRAPPER}} .lcake-single-testimonial-slider:hover, {{WRAPPER}} .lcake-testimonial-card:hover',
			]
		);

		$this->add_control(
			'lcake_testimonial_hover_effect',
			[
				'label'		=> esc_html__('Hover Effect', 'lc-addons-kit-for-elementor'),
				'type'		=> \Elementor\Controls_Manager::SELECT,
				'options'	=> [
					'slide'		=> esc_html__('Slide', 'lc-addons-kit-for-elementor'),
					'fade' 		=> esc_html__('Fade', 'lc-addons-kit-for-elementor'),
				],
				'default'	=> 'slide',
				'prefix_class'	=> 'lcake-testimonial-',
				'condition'	=> [
					'lcake_testimonial_style!'								=> 'style3',
					'lcake_testimonial_layout_active_background_background!' => '',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_testimonial_wrapper_tab_active',
			[
				'label' => esc_html__('Active', 'lc-addons-kit-for-elementor'),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_active_layout_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active, {{WRAPPER}} .lcake-testimonial-card.testimonial-active',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'lcake_testimonial_active_layout_shadow',
				'selector'  => '{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active, {{WRAPPER}} .lcake-testimonial-card.testimonial-active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'lcake_testimonial_section_wraper_style',
			[
				'label'	 => esc_html__('Wrapper Content Style', 'lc-addons-kit-for-elementor'),
				'tab'	 => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'lcake_testimonial_section_wraper_vertical_alignment',
			[
				'label' => esc_html__('Vertical Alignment', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start'    => [
						'title' => esc_html__('Top', 'lc-addons-kit-for-elementor'),
						'icon' => 'eicon-sort-up',
					],
					'center' => [
						'title' => esc_html__('Center', 'lc-addons-kit-for-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__('Bottom', 'lc-addons-kit-for-elementor'),
						'icon' => 'eicon-sort-down',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-col' => 'align-self: {{VALUE}};'
				],
				'default' => 'center',
				'condition' => [
					'lcake_testimonial_style' => 'style1',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_section_wraper_horizontal_alignment',
			[
				'label' => esc_html__('Horizontal Alignment', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-content' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .lcake-testimonial-card' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .lcake-profile-info' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .lcake-commentor-bio' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}',
					'{{WRAPPER}} .lcake_testimonial_style_5 .lcake-commentor-header' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_section_wraper_padding',
			[
				'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lcake_testimonial_section_wraper_use_height',
			[
				'label' => esc_html__('Use Fixed Height', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'lc-addons-kit-for-elementor'),
				'label_off' => esc_html__('No', 'lc-addons-kit-for-elementor'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_section_height',
			[
				'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 10,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-content' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lcake_testimonial_section_wraper_use_height' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		// description
		$this->start_controls_section(
			'lcake_testimonial_content_description',
			[
				'label' => esc_html__('Description', 'lc-addons-kit-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lcake_testimonial_description_color',
			[
				'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lcake-single-testimonial-slider .lcake-commentor-content > p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lcake-testimonial-card .lcake-commentor-content > p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lcake_testimonial_description_active_color',
			[
				'label' => esc_html__('Hover & Active Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-commentor-content > p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-commentor-content > p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lcake-testimonial-card:hover .lcake-commentor-content > p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'lcake_testimonial_description_typography',
				'label' => esc_html__('Typography', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-single-testimonial-slider .lcake-commentor-content > p, {{WRAPPER}} .lcake-testimonial-card .lcake-commentor-content > p',
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_description_margin',
			[
				'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-testimonial-slider .lcake-commentor-content > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-testimonial-card .lcake-commentor-content > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Testimonial Review Rating

		$this->start_controls_section(
			'lcake_testimonial_section_testimonial_ratting_style',
			[
				'label'	 => esc_html__('Rating', 'lc-addons-kit-for-elementor'),
				'tab'	 => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lcake_testimonial_style' => ['style3', 'style4', 'style5', 'style6'],
					'lcake_testimonial_rating_enable' => 'yes'
				]
			]
		);

		// Testimonial Review ratting Color
		$this->add_control(
			'lcake_testimonial_review_ratting_color',
			[
				'label'		 => esc_html__('Color', 'lc-addons-kit-for-elementor'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'default'	 => '#fec42d',
				'selectors'	 => [
					'{{WRAPPER}} .lcake-stars > li > a, {{WRAPPER}} .lcake-stars > li > span' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lcake_testimonial_rating_hover_color',
			[
				'label'		=> esc_html__('Hover & Active Color', 'lc-addons-kit-for-elementor'),
				'type'		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-stars > li > a, 
					{{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-stars > li > span, 
					{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-stars > li > a, 
					{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-stars > li > span, 
					{{WRAPPER}} .lcake-testimonial-card:hover .lcake-stars > li > a, 
					{{WRAPPER}} .lcake-testimonial-card:hover .lcake-stars > li > span' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_review_ratting_font_size',
			[
				'label'         => esc_html__('Font Size', 'lc-addons-kit-for-elementor'),
				'type'          => \Elementor\Controls_Manager::SLIDER,
				'size_units'    => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-stars > li > a, {{WRAPPER}} .lcake-stars > li > span' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_review_ratting_right_spacing',
			[
				'label' => esc_html__('Items Margin Right', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-stars > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_review_ratting_padding',
			[
				'label' => esc_html__('Review Padding', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-stars' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_testimonial_review_ratting_spacing',
			[
				'label' => esc_html__('Review Margin', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-stars' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'lcake_testimonial_section_wathermark_style',
			[
				'label'	 => esc_html__('Quote Icon', 'lc-addons-kit-for-elementor'),
				'tab'	 => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lcake_testimonial_wartermark_enable' => 'yes',
					'lcake_testimonial_style!'			 => ['style1', 'style3'],
				]
			]
		);

		$this->start_controls_tabs(
			'lcake_testimonial_client_watermark_color_tabs'
		);

		$this->start_controls_tab(
			'lcake_testimonial_client_watermark_normal_color_tab',
			[
				'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
			]
		);

		// Testimonial wathermark Color
		$this->add_responsive_control(
			'lcake_testimonial_section_wathermark_color',
			[
				'label'		 => esc_html__('Color', 'lc-addons-kit-for-elementor'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lcake-single-testimonial-slider .lcake-watermark-icon > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-testimonial-slider-block-style .lcake-commentor-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-testimonial-slider-block-style-two .lcake-icon-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-testimonial-slider-block-style-three .lcake-icon-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-watermark-icon svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_section_wathermark_icon_badge_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-commentor-content > i, {{WRAPPER}} .lcake-icon-content > i,{{WRAPPER}} .lcake-watermark-icon > i, {{WRAPPER}} .lcake-watermark-icon svg',
				'condition' => [
					'lcake_testimonial_style!' => 'style6'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_testimonial_client_watermark_active_color_tab',
			[
				'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_section_wathermark_active_color',
			[
				'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-watermark-icon > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-testimonial-slider-block-style:hover .lcake-commentor-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-testimonial-slider-block-style-two:hover .lcake-icon-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-testimonial-slider-block-style-three:hover .lcake-icon-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-watermark-icon svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active:hover .lcake-watermark-icon > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active:hover .lcake-watermark-icon svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',


				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_section_wathermark_icon_badge_hover_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}.lcake-single-testimonial-slider:hover .lcake-commentor-content > i, {{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-icon-content > i,{{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-watermark-icon > i, {{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-watermark-icon svg,
				
				{{WRAPPER}}.lcake-single-testimonial-slider.testimonial-active:hover .lcake-commentor-content > i, {{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active:hover .lcake-icon-content > i,{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active:hover .lcake-watermark-icon > i, {{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active:hover .lcake-watermark-icon svg
				',
				'condition' => [
					'lcake_testimonial_style!' => 'style6'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_testimonial_client_watermark_hover_color_tab',
			[
				'label' => esc_html__('Active', 'lc-addons-kit-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_section_wathermark_hover_color',
			[
				'label'      => esc_html__('Color', 'lc-addons-kit-for-elementor'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-watermark-icon > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-watermark-icon svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_section_wathermark_icon_badge_active_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-commentor-content > i, {{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-icon-content > i, {{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-watermark-icon > i, {{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-watermark-icon svg',
				'condition' => [
					'lcake_testimonial_style!' => 'style6'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'lcake_testimonial_client_watermark_color_tab_end',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		// Testimonial wathermark icon size
		$this->add_responsive_control(
			'lcake_testimonial_section_wathermark_typography',
			[
				'label' => esc_html__('Icon Size', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-watermark-icon > i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-watermark-icon > svg'	=> 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_testimonial_section_wathermark_margin_bottom',
			[
				'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider-block-style .lcake-commentor-content > i' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-testimonial-slider-block-style-three .lcake-icon-content > i' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-watermark-icon'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_testimonial_section_wathermark_icon_padding',
			[
				'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-content > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-icon-content > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-watermark-icon > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-watermark-icon svg'	=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_section_wathermark_icon_radius',
			[
				'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-content > i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-icon-content > i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-watermark-icon > i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-watermark-icon svg'	=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'lcake_testimonial_style!' => 'style6'
				],
			]
		);

		$this->add_control(
			'lcake_testimonial_section_wathermark_badge_devider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
				'condition' => [
					'lcake_testimonial_wartermark_mask_show_badge' => 'yes'
				]
			]
		);

		// watermark badge
		$this->add_responsive_control(
			'lcake_testimonial_section_wathermark_badge_radius',
			[
				'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider-block-style-three .lcake-icon-content.commentor-badge::before' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lcake_testimonial_wartermark_mask_show_badge' => 'yes'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_section_wathermark_badge_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider-block-style-three .lcake-icon-content.commentor-badge::before',
				'condition' => [
					'lcake_testimonial_wartermark_mask_show_badge' => 'yes'
				]
			]
		);
		$this->end_controls_section();
		// title separetor
		$this->start_controls_section(
			'lcake_testimonial_title_separetor_tab',
			[
				'label' => esc_html__('Title Separetor', 'lc-addons-kit-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lcake_testimonial_title_separetor' => 'yes',
					'lcake_testimonial_style' => ['style1', 'style2'],
				]
			]
		);

		$this->start_controls_tabs(
			'lcake_testimonial_client_title_separetor_color_tabs'
		);

		$this->start_controls_tab(
			'lcake_testimonial_client_title_separetor_normal_color_tab',
			[
				'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
			]
		);
		$this->add_control(
			'lcake_testimonial_title_separator_color',
			[
				'label'      => esc_html__('Separator Color', 'lc-addons-kit-for-elementor'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .lcake-single-testimonial-slider .lcake-border-hr' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_testimonial_client_title_separetor_active_color_tab',
			[
				'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
			]
		);

		$this->add_control(
			'lcake_testimonial_title_separator_active_color',
			[
				'label'      => esc_html__('Separator Color', 'lc-addons-kit-for-elementor'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-border-hr' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'lcake_testimonial_client_title_separetor_color_tab_end',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_title_separator_width',
			[
				'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-testimonial-slider .lcake-border-hr' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_title_separator_height',
			[
				'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-testimonial-slider .lcake-border-hr' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_title_separator_margin',
			[
				'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .lcake-single-testimonial-slider .lcake-border-hr' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// client style
		$this->start_controls_section(
			'lcake_testimonial_client_content_section',
			[
				'label' => esc_html__('Client', 'lc-addons-kit-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// client name heading
		$this->add_control(
			'lcake_testimonial_client_name_heading',
			[
				'label' => esc_html__('Client Name', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		// Client Name Color
		$this->add_control(
			'lcake_testimonial_client_name_normal_color',
			[
				'label'		 => esc_html__('Color', 'lc-addons-kit-for-elementor'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lcake-profile-info .lcake-author-name' => 'color: {{VALUE}};'
				],
			]
		);

		// Client Name Color
		$this->add_control(
			'lcake_testimonial_client_name_active_color',
			[
				'label'		 => esc_html__('Hover & Active Color', 'lc-addons-kit-for-elementor'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-author-name' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-author-name' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		 => 'lcake_testimonial_client_name_typography',
				'selector'	 => '{{WRAPPER}} .lcake-profile-info .lcake-author-name',
			]
		);

		// client name margin bottom
		$this->add_responsive_control(
			'lcake_testimonial_client_name_spacing_bottom',
			[
				'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-profile-info .lcake-author-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// client designation heading
		$this->add_control(
			'lcake_testimonial_client_designation_heading',
			[
				'label' => esc_html__('Client Designation', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Designation Color
		$this->add_control(
			'lcake_testimonial_designation_normal_color',
			[
				'label'		 => esc_html__('Color', 'lc-addons-kit-for-elementor'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lcake-profile-info .lcake-author-des' => 'color: {{VALUE}};'
				],
			]
		);

		// Designation Hover Color
		$this->add_control(
			'lcake_testimonial_designation_active_color',
			[
				'label'		 => esc_html__('Hover & Active Color', 'lc-addons-kit-for-elementor'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lcake-single-testimonial-slider:hover .lcake-author-des' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-single-testimonial-slider.testimonial-active .lcake-author-des' => 'color: {{VALUE}};'
				],
			]
		);

		// Designation typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		 => 'lcake_testimonial_designation_typography',
				'selector'	 => '{{WRAPPER}} .lcake-profile-info .lcake-author-des',
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_spacing',
			[
				'label' => esc_html__('Margin', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-bio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// client logo heading
		$this->add_control(
			'lcake_testimonial_client_logo_heading',
			[
				'label' => esc_html__('Client Logo', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'lcake_testimonial_style' => ['style1', 'style2']
				]
			]
		);

		// client logo margin bottom
		$this->add_responsive_control(
			'lcake_testimonial_client_logo_margin_bottom',
			[
				'label' => esc_html__('Margin Bottom', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
					'size' => 32,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-content .lcake-client-logo' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lcake_testimonial_style' => ['style1', 'style2']
				]
			]
		);

		/**
		 * Heading: Client Image
		 */
		$this->add_control(
			'lcake_testimonial_client_image_heading',
			[
				'label' => esc_html__('Client Image', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'lcake_testimonial_style' => ['style1', 'style4', 'style5', 'style6']
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_client_image_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-profile-image-card::before',
				'condition' => [
					'lcake_testimonial_style' => ['style1']
				]
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_img_pos',
			[
				'label'		=> esc_html__('Image Position', 'lc-addons-kit-for-elementor'),
				'type'		=> \Elementor\Controls_Manager::CHOOSE,
				'options'	=> [
					'left' => [
						'title'	=> esc_html__('Left', 'lc-addons-kit-for-elementor'),
						'icon'	=> 'eicon-caret-left',
					],
					'top' => [
						'title'	=> esc_html__('Top', 'lc-addons-kit-for-elementor'),
						'icon'	=> 'eicon-caret-up',
					],
					'bottom' => [
						'title'	=> esc_html__('Bottom', 'lc-addons-kit-for-elementor'),
						'icon'	=> 'eicon-caret-down',
					],
					'right' => [
						'title'	=> esc_html__('Right', 'lc-addons-kit-for-elementor'),
						'icon'	=> 'eicon-caret-right',
					],
				],
				'selectors_dictionary' => [
					'left'   => '-webkit-box-orient: horizontal; -webkit-box-direction: normal; -ms-flex-direction: row; flex-direction: row;',
					'top'    => '-webkit-box-orient: vertical; -webkit-box-direction: normal; -ms-flex-direction: column; flex-direction: column;',
					'bottom' => '-webkit-box-orient: vertical; -webkit-box-direction: reverse; -ms-flex-direction: column-reverse; flex-direction: column-reverse;',
					'right'  => '-webkit-box-orient: horizontal; -webkit-box-direction: reverse; -ms-flex-direction: row-reverse; flex-direction: row-reverse;',
				],
				'selectors'	=> [
					'{{WRAPPER}} .lcake-commentor-details' => '{{VALUE}}',
				],
				'condition'	=> [
					'lcake_testimonial_style'	=> 'style5',
				],
			]
		);

		$this->add_control(
			'lcake_testimonial_client_area_alignment',
			[
				'label' => esc_html__('Alignment', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'client_left'    => [
						'title' => esc_html__('Left', 'lc-addons-kit-for-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'client_center' => [
						'title' => esc_html__('Center', 'lc-addons-kit-for-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'client_right' => [
						'title' => esc_html__('Right', 'lc-addons-kit-for-elementor'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'condition' => [
					'lcake_testimonial_style' => ['style4', 'style5', 'style6']
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lcake_testimonial_client_image_border',
				'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-commentor-image > img',
				'condition' => [
					'lcake_testimonial_style' => ['style4', 'style5', 'style6']
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'lcake_testimonial_client_image_box_shadow',
				'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-commentor-image > img',
				'condition' => [
					'lcake_testimonial_style' => ['style4', 'style5', 'style6']
				]
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_image_size',
			[
				'label'   => esc_html__('Image Size', 'lc-addons-kit-for-elementor'),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-bio .lcake-commentor-image > img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lcake_testimonial_style' => ['style4', 'style5', 'style6']
				]
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_author_container_top',
			[
				'label' => esc_html__('Bottom', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -98,
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lcake-commentor-bio' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lcake_testimonial_style' => ['style4']
				]
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_image_margin_',
			[
				'label'			=> __('Margin', 'lc-addons-kit-for-elementor'),
				'type'			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'	=> ['px', '%', 'em'],
				'selectors'		=> [
					'{{WRAPPER}} .lcake-testimonial--avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'		=> [
					'lcake_testimonial_style' => ['style4', 'style5', 'style6'],
				],
			]
		);
		$this->end_controls_section();
		// dot style
		$this->start_controls_section(
			'lcake_testimonial_client_dot_tab',
			[
				'label' => esc_html__('Dot', 'lc-addons-kit-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lcake_testimonial_show_dot' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_dot_bottom',
			[
				'label' => esc_html__('Dot Top Spacing', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -50,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_testimonial_client_dot_width',
			[
				'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_testimonial_client_dot_height',
			[
				'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lcake_testimonial_client_dot_border',
				'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span',
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_dot_border_radius',
			[
				'label' => esc_html__('Border radius', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_dot_spacing',
			[
				'label' => esc_html__('Margin right', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_client_dot_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span',
			]
		);
		$this->add_control(
			'lcake_testimonial_client_dot_active_heading',
			[
				'label' => esc_html__('Active', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_client_dot_active_background',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active',
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_dot_active_width',
			[
				'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lcake_testimonial_client_dot_active_height',
			[
				'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lcake_testimonial_client_dot_active_border',
				'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active',
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_client_dot_active_scale',
			[
				'label' => esc_html__('Scale', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => .5,
						'max' => 3,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1.2,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active' => 'transform: scale({{SIZE}});',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'lcake_testimonial_nav_style_tab',
			[
				'label' => esc_html__('Nav', 'lc-addons-kit-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lcake_testimonial_show_arrow' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_nav_font_size',
			[
				'label' => esc_html__('Font Size', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 36,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-navigation-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_nav_right_icon',
			[
				'label' => esc_html__('Prev', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_nav_left_icon',
			[
				'label' => esc_html__('Next', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_nav_width',
			[
				'label' => esc_html__('Width', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-next' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_nav_height',
			[
				'label' => esc_html__('Height', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-next' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_nav_vertical_align',
			[
				'label' => esc_html__('Vertical Align', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'%' => [
						'min' => -500,
						'max' => 500,
					],
					'px' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-navigation-button' => ' -webkit-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->start_controls_tabs(
			'lcake_testimonial_nav_hover_normal_tabs'
		);

		$this->start_controls_tab(
			'lcake_testimonial_nav_normal_tab',
			[
				'label' => esc_html__('Normal', 'lc-addons-kit-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_nav_font_color_normal',
			[
				'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-next' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_nav_background_normal',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev, {{WRAPPER}} .lcake-testimonial-slider .swiper-button-next',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'lcake_testimonial_nav_box_shadow_normal',
				'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev, {{WRAPPER}} .lcake-testimonial-slider .swiper-button-next',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lcake_testimonial_nav_border_normal',
				'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev, {{WRAPPER}} .lcake-testimonial-slider .swiper-button-next',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_testimonial_nav_hover_tab',
			[
				'label' => esc_html__('Hover', 'lc-addons-kit-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'lcake_testimonial_nav_font_color_hover',
			[
				'label' => esc_html__('Color', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-next:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lcake_testimonial_nav_background_hover',
				'label' => esc_html__('Background', 'lc-addons-kit-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev:hover, {{WRAPPER}} .lcake-testimonial-slider .swiper-button-next:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'lcake_testimonial_nav_box_shadow_hover',
				'label' => esc_html__('Box Shadow', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev:hover, {{WRAPPER}} .lcake-testimonial-slider .swiper-button-next:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lcake_testimonial_nav_border_hover',
				'label' => esc_html__('Border', 'lc-addons-kit-for-elementor'),
				'selector' => '{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev:hover, {{WRAPPER}} .lcake-testimonial-slider .swiper-button-next:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'lcake_testimonial_nav_border_radius',
			[
				'label' => esc_html__('Border Radius', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'lcake_price_menu_arrow_padding',
			[
				'label' => esc_html__('Padding', 'lc-addons-kit-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lcake-testimonial-slider .swiper-navigation-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/*---------------------------
	 * Render
	 *--------------------------*/
	protected function render()
	{
		echo '<div class="lcake-main-wrapper" >';
		$this->render_raw();
		echo '</div>';
	}

	protected function render_raw()
	{

		$testimonials = [];
		$settings = $this->get_settings_for_display();
		extract($settings);

		// Alias mappings: ensure legacy lcake_* vars exist from lcake_* settings
		$lcake_testimonial_style = $settings['lcake_testimonial_style'] ?? ($settings['lcake_testimonial_style'] ?? 'style1');
		$lcake_testimonial_data = $settings['lcake_testimonial_data'] ?? ($settings['lcake_testimonial_data'] ?? []);
		$lcake_testimonial_slidetoshow = $settings['lcake_testimonial_slidetoshow'] ?? ($settings['lcake_testimonial_slidetoshow'] ?? 1);
		$lcake_testimonial_slidesToScroll = $settings['lcake_testimonial_slidesToScroll'] ?? ($settings['lcake_testimonial_slidesToScroll'] ?? 1);
		$lcake_testimonial_slidetoshow_tablet = $settings['lcake_testimonial_slidetoshow_tablet'] ?? ($settings['lcake_testimonial_slidetoshow_tablet'] ?? null);
		$lcake_testimonial_slidesToScroll_tablet = $settings['lcake_testimonial_slidesToScroll_tablet'] ?? ($settings['lcake_testimonial_slidesToScroll_tablet'] ?? null);
		$lcake_testimonial_slidetoshow_mobile = $settings['lcake_testimonial_slidetoshow_mobile'] ?? ($settings['lcake_testimonial_slidetoshow_mobile'] ?? null);
		$lcake_testimonial_slidesToScroll_mobile = $settings['lcake_testimonial_slidesToScroll_mobile'] ?? ($settings['lcake_testimonial_slidesToScroll_mobile'] ?? null);
		$lcake_testimonial_left_right_spacing = $settings['lcake_testimonial_left_right_spacing'] ?? ($settings['lcake_testimonial_left_right_spacing'] ?? ['size' => 15]);
		$lcake_testimonial_left_right_spacing_tablet = $settings['lcake_testimonial_left_right_spacing_tablet'] ?? ($settings['lcake_testimonial_left_right_spacing_tablet'] ?? ['size' => 10]);
		$lcake_testimonial_left_right_spacing_mobile = $settings['lcake_testimonial_left_right_spacing_mobile'] ?? ($settings['lcake_testimonial_left_right_spacing_mobile'] ?? ['size' => 10]);
		$lcake_testimonial_show_arrow = $settings['lcake_testimonial_show_arrow'] ?? ($settings['lcake_testimonial_show_arrow'] ?? '');
		$lcake_testimonial_show_dot = $settings['lcake_testimonial_show_dot'] ?? ($settings['lcake_testimonial_show_dot'] ?? '');
		$lcake_testimonial_pause_on_hover = $settings['lcake_testimonial_pause_on_hover'] ?? ($settings['lcake_testimonial_pause_on_hover'] ?? 'yes');
		$lcake_testimonial_autoplay = $settings['lcake_testimonial_autoplay'] ?? ($settings['lcake_testimonial_autoplay'] ?? 'no');
		$lcake_testimonial_speed = $settings['lcake_testimonial_speed'] ?? ($settings['lcake_testimonial_speed'] ?? 1000);
		$lcake_testimonial_loop = $settings['lcake_testimonial_loop'] ?? ($settings['lcake_testimonial_loop'] ?? '');
		$lcake_testimonial_wartermark_enable = $settings['lcake_testimonial_wartermark_enable'] ?? ($settings['lcake_testimonial_wartermark_enable'] ?? '');
		$lcake_testimonial_wartermark_custom_position = $settings['lcake_testimonial_wartermark_custom_position'] ?? ($settings['lcake_testimonial_wartermark_custom_position'] ?? '');
		$lcake_testimonial_wartermark_mask_show_badge = $settings['lcake_testimonial_wartermark_mask_show_badge'] ?? ($settings['lcake_testimonial_wartermark_mask_show_badge'] ?? '');
		$lcake_testimonial_title_separetor = $settings['lcake_testimonial_title_separetor'] ?? ($settings['lcake_testimonial_title_separetor'] ?? '');
		$lcake_testimonial_rating_enable = $settings['lcake_testimonial_rating_enable'] ?? ($settings['lcake_testimonial_rating_enable'] ?? '');
		$lcake_testimonial_client_area_alignment = $settings['lcake_testimonial_client_area_alignment'] ?? ($settings['lcake_testimonial_client_area_alignment'] ?? '');
		$lcake_testimonial_left_arrows = $settings['lcake_testimonial_left_arrows'] ?? ($settings['lcake_testimonial_left_arrows'] ?? []);
		$lcake_testimonial_right_arrows = $settings['lcake_testimonial_right_arrows'] ?? ($settings['lcake_testimonial_right_arrows'] ?? []);

		// Set default client image size
		$lcake_testimonial_client_image_size = isset($lcake_testimonial_client_image_size) ? $lcake_testimonial_client_image_size : ['size' => 70];

		$slides_to_show_count = $lcake_testimonial_slidetoshow ? $lcake_testimonial_slidetoshow : 1;
		$slides_to_scroll_count = $lcake_testimonial_slidesToScroll ? $lcake_testimonial_slidesToScroll : 1;

		// Config
		$config = [
			'rtl'				=> is_rtl(),
			'arrows'			=> $lcake_testimonial_show_arrow ? true : false,
			'dots'				=> $lcake_testimonial_show_dot ? true : false,
			'pauseOnHover'		=> $lcake_testimonial_pause_on_hover ? true : false,
			'autoplay'			=> $lcake_testimonial_autoplay ? true : false,
			'speed'				=> $lcake_testimonial_speed ? $lcake_testimonial_speed : 1000,
			'slidesPerGroup'	=> (int) $slides_to_scroll_count,
			'slidesPerView'		=> (int) $slides_to_show_count,
			'loop'				=> (!empty($lcake_testimonial_loop) && $lcake_testimonial_loop == 'yes') ? true : false,
			'spaceBetween' => isset($lcake_testimonial_left_right_spacing['size']) ? ($lcake_testimonial_left_right_spacing['size'] !== 0 ? $lcake_testimonial_left_right_spacing['size'] : 0) : 15,
			'breakpoints'  => [
				320 => [
					'slidesPerView'      => !empty($lcake_testimonial_slidetoshow_mobile) ? $lcake_testimonial_slidetoshow_mobile : 1,
					'slidesPerGroup'     => !empty($lcake_testimonial_slidesToScroll_mobile) ? $lcake_testimonial_slidesToScroll_mobile : 1,
					'spaceBetween'       => !empty($lcake_testimonial_left_right_spacing_mobile['size']) ? $lcake_testimonial_left_right_spacing_mobile['size'] : 10,
				],
				768 => [
					'slidesPerView'      => !empty($lcake_testimonial_slidetoshow_tablet) ? $lcake_testimonial_slidetoshow_tablet : 2,
					'slidesPerGroup'     => !empty($lcake_testimonial_slidesToScroll_tablet) ? $lcake_testimonial_slidesToScroll_tablet : 1,
					'spaceBetween'       => !empty($lcake_testimonial_left_right_spacing_tablet['size']) ? $lcake_testimonial_left_right_spacing_tablet['size'] : 10,
				],
				1024 => [
					'slidesPerView'      =>  $slides_to_show_count,
					'slidesPerGroup'     =>  $slides_to_scroll_count,
					'spaceBetween'		=> !empty($lcake_testimonial_left_right_spacing['size']) ? $lcake_testimonial_left_right_spacing['size'] : 0,
				]
			],

		];

		// HTML Attribute
		$this->add_render_attribute(
			'wrapper',
			[
				'data-config'	=> wp_json_encode($config),
			]
		);

		$style = isset($lcake_testimonial_style) ? sanitize_text_field($lcake_testimonial_style) : 'style1';
		// Swiper container
		$this->add_render_attribute(
			'swiper-container',
			[
				'class'	=> \LCAKE_Kit_Utils::swiper_class($style),
			]
		);


		$testimonials = isset($lcake_testimonial_data) ? $lcake_testimonial_data : [];
		$styles = [
			'style1',
			'style2',
			'style3',
			'style4',
			'style5',
			'style6',
		];

		if (in_array($style, $styles) && is_array($testimonials) && !empty($testimonials)) {
			require __DIR__ . '/testimonial-style/' . $style . '.php';
		}
	}
}
