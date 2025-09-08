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

class LC_Kit_Testimonial extends \Elementor\Widget_Base
{

	/*---------------------------
	 * Meta
	 *--------------------------*/
	public function get_name()
	{
		return 'lc_kit_testimonial';
	}

	public function get_title()
	{
		return __('LC Testimonial', 'lc-elementor-addons-kit');
	}

	public function get_icon()
	{
		return 'eicon-testimonial';
	}

	/**
	 * Adjust this to your registered categories.
	 * Fallback to "general" if your custom category doesn't exist.
	 */
	public function get_categories()
	{
		return array('lc-page-kit', 'general');
	}

	public function get_keywords()
	{
		return array('testimonial', 'review', 'quote', 'feedback', 'client', 'rating');
	}

	/**
	 * If you have global styles, return their handles here.
	 * For a truly standalone file, we inject a tiny default CSS in render().
	 */
	public function get_style_depends()
	{
		return array(); // e.g. return array( 'lc-kit-widgets' );
	}

	/*---------------------------
	 * Controls
	 *--------------------------*/
	protected function register_controls()
	{

		$this->start_controls_section(
			'lc_testimonial_layout_section_tab_style',
			[
				'label' => esc_html__('Layout', 'elementskit-lite'),
			]
		);


		// Card style

		$this->add_control(
			'lc_testimonial_style',
			[
				'label' => esc_html__('Choose Style', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'style1' => 'Style 1',
					'style2' => 'Style 2',
					'style3' => 'Style 3',
					'style4' => 'Style 4',
					'style5' => 'Style 5',
					'style6' => 'Style 6',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lc_testimonial_section_tab_style',
			[
				'label' => esc_html__('Testimonial', 'elementskit-lite'),
			]
		);

		// enable warter mark icon
		$this->add_control(
			'lc_testimonial_wartermark_enable',
			[
				'label' => esc_html__('Enable Quote Icon', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'lc_testimonial_style' => ['style2', 'style4', 'style5', 'style6']
				]
			]
		);

		$this->add_control(
			'lc_testimonial_wartermarks',
			[
				'label' => esc_html__('Quote Icon', 'elementskit-lite'),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'lc_testimonial_wartermark',
				'default' => [
					'value' => 'icon icon-quote',
					'library' => 'lcicons',
				],
				'condition' => [
					'lc_testimonial_wartermark_enable' => 'yes',
					'lc_testimonial_style' => ['style2', 'style4', 'style5', 'style6'],
				],
			]
		);

		// water mark position
		$this->add_control(
			'lc_testimonial_wartermark_position',
			[
				'label' => esc_html__('Quote Icon Position', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'bottom',
				'separator'    => 'before',
				'options' => [
					'top'  => esc_html__('Top', 'elementskit-lite'),
					'bottom' => esc_html__('Bottom', 'elementskit-lite'),
				],
				'condition' => [
					'lc_testimonial_wartermark_enable' => 'yes',
					'lc_testimonial_style' => ['style5']
				],
				'selectors_dictionary' => [
					'top' => 'position: unset;',
					'bottom' => 'bottom: 30px; right: 30px;',
				],
				'selectors' => [
					'{{WRAPPER}} .lc_testimonial_style_5 .lc-watermark-icon' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lc_testimonial_wartermark_mask_show_badge',
			[
				'label' => esc_html__('Show Quote Icon Badge', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'elementskit-lite'),
				'label_off' => esc_html__('Hide', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator'    => 'before',
				'condition' => [
					'lc_testimonial_wartermark_enable' => 'yes',
					'lc_testimonial_style' => ['style6']
				]
			]
		);

		$this->add_control(
			'lc_testimonial_wartermark_custom_position',
			[
				'label' => esc_html__('Custom Position', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'elementskit-lite'),
				'label_off' => esc_html__('Hide', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => 'no',
				'separator'	=> 'before',
				'condition' => [
					'lc_testimonial_wartermark_enable' => 'yes',
					'lc_testimonial_style'			 => 'style2',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_wartermark_custom_position_offset_x',
			[
				'label' => esc_html__('Left', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc_watermark_icon_custom_position' => 'left: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'lc_testimonial_wartermark_enable'		  => 'yes',
					'lc_testimonial_wartermark_custom_position' => 'yes',
					'lc_testimonial_style'			 		  => 'style2',
				]
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_wartermark_custom_position_offset_y',
			[
				'label' => esc_html__('top', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc_watermark_icon_custom_position' => 'top: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'lc_testimonial_wartermark_enable' 		  => 'yes',
					'lc_testimonial_wartermark_custom_position' => 'yes',
					'lc_testimonial_style'			 		  => 'style2',
				]
			]
		);

		$this->add_control(
			'lc_testimonial_before_rating',
			[
				'type' 		=> \Elementor\Controls_Manager::DIVIDER,
				'condition'	=> [
					'lc_testimonial_style!' => ['style1', 'style3'],
				],
			]
		);

		// enable rating
		$this->add_control(
			'lc_testimonial_rating_enable',
			[
				'label' => esc_html__('Enable Rating', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'lc_testimonial_style' => ['style3', 'style4', 'style5', 'style6']
				]
			]
		);

		// enable title separetor
		$this->add_control(
			'lc_testimonial_title_separetor',
			[
				'label'     => esc_html__('Show Separator', 'elementskit-lite'),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'default'   => 'yes',
				'condition' => [
					'lc_testimonial_style' => ['style1', 'style2'],
				]
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'client_name',
			[
				'label' => esc_html__('Client Name', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__('Testimonial #1', 'elementskit-lite'),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'designation',
			[
				'label' => esc_html__('Designation', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => esc_html__('Designation', 'elementskit-lite'),
			]
		);

		$repeater->add_control(
			'review',
			[
				'label' => esc_html__('Testimonial Review', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => esc_html__('Review Text', 'elementskit-lite'),
			]
		);

		$repeater->add_control(
			'rating',
			[
				'label' => esc_html__('Testimonial Rating', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '5',
				'options'   => [
					'5'     => esc_html__('5', 'elementskit-lite'),
					'4'     => esc_html__('4', 'elementskit-lite'),
					'3'     => esc_html__('3', 'elementskit-lite'),
					'2'     => esc_html__('2', 'elementskit-lite'),
					'1'     => esc_html__('1', 'elementskit-lite'),
				],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'			=> esc_html__('Link', 'elementskit-lite'),
				'type'			=> \Elementor\Controls_Manager::URL,
				'dynamic'		=> [
					'active' => true,
				],
				'placeholder'	=> esc_url('https://wpmet.com', 'elementskit-lite'),
			]
		);

		$repeater->add_control(
			'client_photo',
			[
				'label' => esc_html__('Client Avatar', 'elementskit-lite'),
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
				'label' => esc_html__('Logo', 'elementskit-lite'),
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
				'label' => esc_html__('Display different logo on hover?', 'elementskit-lite'),
				'description' => esc_html__('This option only work for style 1 & 2', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'default' => 'no',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'client_logo_active',
			[
				'label' => esc_html__('Logo Active', 'elementskit-lite'),
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
			'lc_testimonial_active',
			[
				'label' => esc_html__('Active Testimonial?', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_background_group',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic'],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
			]
		);
		$this->add_control(
			'lc_testimonial_data',
			[
				'label' => esc_html__('Testimonial', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'default' => [
					['client_name' => esc_html__('Testimonial #1', 'elementskit-lite')],
					['client_name' => esc_html__('Testimonial #2', 'elementskit-lite')],
					['client_name' => esc_html__('Testimonial #3', 'elementskit-lite')],
				],

				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ client_name }}}',
			]
		);



		$this->end_controls_section();

		// setting section

		$this->start_controls_section(
			'lc_testimonial_layout_settings',
			[
				'label' => esc_html__('Settings', 'elementskit-lite'),
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_left_right_spacing',
			[
				'label' => esc_html__('Spacing Left Right', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider' => '--lc_testimonial_left_right_spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_top_bottom_spacing',
			[
				'label' => esc_html__('Padding', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-testimonial-slider .swiper-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_slidetoshow',
			[
				'label' => esc_html__('Slides To Show', 'elementskit-lite'),
				'type' =>  \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 1,
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lc-testimonial-slider' => '--lc_testimonial_slidetoshow:  {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_slidesToScroll',
			[
				'label' => esc_html__('Slides To Scroll', 'elementskit-lite'),
				'type' =>  \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'lc_testimonial_speed',
			[
				'label' => esc_html__('Speed', 'elementskit-lite'),
				'type' =>  \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10000,
				'step' => 1,
				'default' => 1000,
			]
		);

		$this->add_control(
			'lc_testimonial_autoplay',
			[
				'label' => esc_html__('Autoplay', 'elementskit-lite'),
				'type' =>  \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'lc_testimonial_show_arrow',
			[
				'label' => esc_html__('Show Arrow', 'elementskit-lite'),
				'type' =>   \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lc_testimonial_show_dot',
			[
				'label' => esc_html__('Show Dots', 'elementskit-lite'),
				'type' =>   \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lc_testimonial_left_arrows',
			[
				'label' => esc_html__('Left Arrow Icon', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'lc_testimonial_left_arrow',
				'default' => [
					'value' => 'icon icon-left-arrow2',
					'library' => 'lcicons',
				],
				'condition' => [
					'lc_testimonial_show_arrow' => 'yes',
				]
			]
		);

		$this->add_control(
			'lc_testimonial_right_arrows',
			[
				'label' => esc_html__('Right Arrow Icon', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'lc_testimonial_right_arrow',
				'default' => [
					'value' => 'icon icon-right-arrow2',
					'library' => 'lcicons',
				],
				'condition' => [
					'lc_testimonial_show_arrow' => 'yes',
				]
			]
		);

		$this->add_control(
			'lc_testimonial_loop',
			[
				'label' => esc_html__('Enable Loop?', 'elementskit-lite'),
				'type' =>   \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lc_testimonial_pause_on_hover',
			[
				'label' => esc_html__('Pause on Hover', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lc_testimonial_section_layout',
			[
				'label'	 => esc_html__('Layout', 'elementskit-lite'),
				'tab'	 => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_layout_margin',
			[
				'label'         => esc_html__('Column Gap', 'elementskit-lite'),
				'type'          => \Elementor\Controls_Manager::SLIDER,
				'size_units'    => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-single-testimonial-slider,
						{{WRAPPER}} .lc-testimonial-item,
						{{WRAPPER}} .lc-testimonial-card' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'lc_testimonial_layout_padding',
			[
				'label' => esc_html__('Padding', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .lc-commentor-content, {{WRAPPER}} .lc-single-testimonial-slider, {{WRAPPER}} .lc-testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_parent_container_margin',
			[
				'label' => esc_html__('Margin', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-testimonial-slider-block-style' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'lc_testimonial_style' => ['style4']
				]
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_layout_border_radius',
			[
				'label' => esc_html__('Border Radius', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-commentor-content, {{WRAPPER}} .lc-single-testimonial-slider, {{WRAPPER}} .lc-testimonial-card' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('lc_testimonial_wrapper_tabs');
		$this->start_controls_tab(
			'lc_testimonial_wrapper_tab_normal',
			[
				'label' => esc_html__('Normal', 'elementskit-lite'),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_layout_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-commentor-content, {{WRAPPER}} .lc-single-testimonial-slider, {{WRAPPER}} .lc-testimonial-card',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lc_testimonial_layout_border',
				'label' => esc_html__('Border', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-single-testimonial-slider, {{WRAPPER}} .lc-testimonial-card',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'lc_testimonial_layout_shadow',
				'selector'  => '{{WRAPPER}} .lc-commentor-content, {{WRAPPER}} .lc-single-testimonial-slider, {{WRAPPER}} .lc-testimonial-card',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'lc_testimonial_wrapper_tab_hover',
			[
				'label' => esc_html__('Hover', 'elementskit-lite'),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_layout_active_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-single-testimonial-slider:before, {{WRAPPER}} .lc-testimonial-card:before',
			]
		);

		$this->add_control(
			'lc_testimonial_layout_active_border_color',
			[
				'label' => esc_html__('Border Color', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lc-single-testimonial-slider:hover, {{WRAPPER}} .lc-testimonial-card:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'lc_testimonial_layout_hover_shadow',
				'selector'  => '{{WRAPPER}} .lc-commentor-content:hover, {{WRAPPER}} .lc-single-testimonial-slider:hover, {{WRAPPER}} .lc-testimonial-card:hover',
			]
		);

		$this->add_control(
			'lc_testimonial_hover_effect',
			[
				'label'		=> esc_html__('Hover Effect', 'elementskit-lite'),
				'type'		=> \Elementor\Controls_Manager::SELECT,
				'options'	=> [
					'slide'		=> esc_html__('Slide', 'elementskit-lite'),
					'fade' 		=> esc_html__('Fade', 'elementskit-lite'),
				],
				'default'	=> 'slide',
				'prefix_class'	=> 'lc-testimonial-',
				'condition'	=> [
					'lc_testimonial_style!'								=> 'style3',
					'lc_testimonial_layout_active_background_background!' => '',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'lc_testimonial_wrapper_tab_active',
			[
				'label' => esc_html__('Active', 'elementskit-lite'),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_active_layout_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active, {{WRAPPER}} .lc-testimonial-card.testimonial-active',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'lc_testimonial_active_layout_shadow',
				'selector'  => '{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active, {{WRAPPER}} .lc-testimonial-card.testimonial-active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'lc_testimonial_section_wraper_style',
			[
				'label'	 => esc_html__('Wrapper Content Style', 'elementskit-lite'),
				'tab'	 => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'lc_testimonial_section_wraper_vertical_alignment',
			[
				'label' => esc_html__('Vertical Alignment', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start'    => [
						'title' => esc_html__('Top', 'elementskit-lite'),
						'icon' => 'eicon-sort-up',
					],
					'center' => [
						'title' => esc_html__('Center', 'elementskit-lite'),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__('Bottom', 'elementskit-lite'),
						'icon' => 'eicon-sort-down',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lc-testimonial-col' => 'align-self: {{VALUE}};'
				],
				'default' => 'center',
				'condition' => [
					'lc_testimonial_style' => 'style1',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_section_wraper_horizontal_alignment',
			[
				'label' => esc_html__('Horizontal Alignment', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__('Left', 'elementskit-lite'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'elementskit-lite'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'elementskit-lite'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lc-commentor-content' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .lc-testimonial-card' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .lc-profile-info' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .lc-commentor-bio' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}',
					'{{WRAPPER}} .lc_testimonial_style_5 .lc-commentor-header' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_section_wraper_padding',
			[
				'label' => esc_html__('Padding', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-commentor-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lc_testimonial_section_wraper_use_height',
			[
				'label' => esc_html__('Use Fixed Height', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'elementskit-lite'),
				'label_off' => esc_html__('No', 'elementskit-lite'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_section_height',
			[
				'label' => esc_html__('Height', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-commentor-content' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lc_testimonial_section_wraper_use_height' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		// description
		$this->start_controls_section(
			'lc_testimonial_content_description',
			[
				'label' => esc_html__('Description', 'elementskit-lite'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lc_testimonial_description_color',
			[
				'label' => esc_html__('Color', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lc-single-testimonial-slider .lc-commentor-content > p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lc-testimonial-card .lc-commentor-content > p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lc_testimonial_description_active_color',
			[
				'label' => esc_html__('Hover & Active Color', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lc-single-testimonial-slider:hover .lc-commentor-content > p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-commentor-content > p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lc-testimonial-card:hover .lc-commentor-content > p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'lc_testimonial_description_typography',
				'label' => esc_html__('Typography', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-single-testimonial-slider .lc-commentor-content > p, {{WRAPPER}} .lc-testimonial-card .lc-commentor-content > p',
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_description_margin',
			[
				'label' => esc_html__('Margin', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-single-testimonial-slider .lc-commentor-content > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lc-testimonial-card .lc-commentor-content > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Testimonial Review Rating

		$this->start_controls_section(
			'lc_testimonial_section_testimonial_ratting_style',
			[
				'label'	 => esc_html__('Rating', 'elementskit-lite'),
				'tab'	 => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lc_testimonial_style' => ['style3', 'style4', 'style5', 'style6'],
					'lc_testimonial_rating_enable' => 'yes'
				]
			]
		);

		// Testimonial Review ratting Color
		$this->add_control(
			'lc_testimonial_review_ratting_color',
			[
				'label'		 => esc_html__('Color', 'elementskit-lite'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'default'	 => '#fec42d',
				'selectors'	 => [
					'{{WRAPPER}} .lc-stars > li > a, {{WRAPPER}} .lc-stars > li > span' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lc_testimonial_rating_hover_color',
			[
				'label'		=> esc_html__('Hover & Active Color', 'elementskit-lite'),
				'type'		=> \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lc-single-testimonial-slider:hover .lc-stars > li > a, 
					{{WRAPPER}} .lc-single-testimonial-slider:hover .lc-stars > li > span, 
					{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-stars > li > a, 
					{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-stars > li > span, 
					{{WRAPPER}} .lc-testimonial-card:hover .lc-stars > li > a, 
					{{WRAPPER}} .lc-testimonial-card:hover .lc-stars > li > span' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_review_ratting_font_size',
			[
				'label'         => esc_html__('Font Size', 'elementskit-lite'),
				'type'          => \Elementor\Controls_Manager::SLIDER,
				'size_units'    => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-stars > li > a, {{WRAPPER}} .lc-stars > li > span' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_review_ratting_right_spacing',
			[
				'label' => esc_html__('Items Margin Right', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-stars > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_review_ratting_padding',
			[
				'label' => esc_html__('Review Padding', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-stars' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lc_testimonial_review_ratting_spacing',
			[
				'label' => esc_html__('Review Margin', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-stars' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'lc_testimonial_section_wathermark_style',
			[
				'label'	 => esc_html__('Quote Icon', 'elementskit-lite'),
				'tab'	 => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lc_testimonial_wartermark_enable' => 'yes',
					'lc_testimonial_style!'			 => ['style1', 'style3'],
				]
			]
		);

		$this->start_controls_tabs(
			'lc_testimonial_client_watermark_color_tabs'
		);

		$this->start_controls_tab(
			'lc_testimonial_client_watermark_normal_color_tab',
			[
				'label' => esc_html__('Normal', 'elementskit-lite'),
			]
		);

		// Testimonial wathermark Color
		$this->add_responsive_control(
			'lc_testimonial_section_wathermark_color',
			[
				'label'		 => esc_html__('Color', 'elementskit-lite'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lc-single-testimonial-slider .lc-watermark-icon > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-testimonial-slider-block-style .lc-commentor-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-testimonial-slider-block-style-two .lc-icon-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-testimonial-slider-block-style-three .lc-icon-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-watermark-icon svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_section_wathermark_icon_badge_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-commentor-content > i, {{WRAPPER}} .lc-icon-content > i,{{WRAPPER}} .lc-watermark-icon > i, {{WRAPPER}} .lc-watermark-icon svg',
				'condition' => [
					'lc_testimonial_style!' => 'style6'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lc_testimonial_client_watermark_active_color_tab',
			[
				'label' => esc_html__('Hover', 'elementskit-lite'),
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_section_wathermark_active_color',
			[
				'label'      => esc_html__('Color', 'elementskit-lite'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .lc-single-testimonial-slider:hover .lc-watermark-icon > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-testimonial-slider-block-style:hover .lc-commentor-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-testimonial-slider-block-style-two:hover .lc-icon-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-testimonial-slider-block-style-three:hover .lc-icon-content > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-single-testimonial-slider:hover .lc-watermark-icon svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active:hover .lc-watermark-icon > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active:hover .lc-watermark-icon svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',


				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_section_wathermark_icon_badge_hover_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}.lc-single-testimonial-slider:hover .lc-commentor-content > i, {{WRAPPER}} .lc-single-testimonial-slider:hover .lc-icon-content > i,{{WRAPPER}} .lc-single-testimonial-slider:hover .lc-watermark-icon > i, {{WRAPPER}} .lc-single-testimonial-slider:hover .lc-watermark-icon svg,
				
				{{WRAPPER}}.lc-single-testimonial-slider.testimonial-active:hover .lc-commentor-content > i, {{WRAPPER}} .lc-single-testimonial-slider.testimonial-active:hover .lc-icon-content > i,{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active:hover .lc-watermark-icon > i, {{WRAPPER}} .lc-single-testimonial-slider.testimonial-active:hover .lc-watermark-icon svg
				',
				'condition' => [
					'lc_testimonial_style!' => 'style6'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lc_testimonial_client_watermark_hover_color_tab',
			[
				'label' => esc_html__('Active', 'elementskit-lite'),
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_section_wathermark_hover_color',
			[
				'label'      => esc_html__('Color', 'elementskit-lite'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-watermark-icon > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-watermark-icon svg path'	=> 'stroke: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_section_wathermark_icon_badge_active_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-commentor-content > i, {{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-icon-content > i, {{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-watermark-icon > i, {{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-watermark-icon svg',
				'condition' => [
					'lc_testimonial_style!' => 'style6'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'lc_testimonial_client_watermark_color_tab_end',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		// Testimonial wathermark icon size
		$this->add_responsive_control(
			'lc_testimonial_section_wathermark_typography',
			[
				'label' => esc_html__('Icon Size', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-watermark-icon > i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lc-watermark-icon > svg'	=> 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lc_testimonial_section_wathermark_margin_bottom',
			[
				'label' => esc_html__('Margin Bottom', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider-block-style .lc-commentor-content > i' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lc-testimonial-slider-block-style-three .lc-icon-content > i' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lc-watermark-icon'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lc_testimonial_section_wathermark_icon_padding',
			[
				'label' => esc_html__('Padding', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-commentor-content > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lc-icon-content > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lc-watermark-icon > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lc-watermark-icon svg'	=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_section_wathermark_icon_radius',
			[
				'label' => esc_html__('Border Radius', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-commentor-content > i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lc-icon-content > i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lc-watermark-icon > i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .lc-watermark-icon svg'	=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'lc_testimonial_style!' => 'style6'
				],
			]
		);

		$this->add_control(
			'lc_testimonial_section_wathermark_badge_devider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
				'condition' => [
					'lc_testimonial_wartermark_mask_show_badge' => 'yes'
				]
			]
		);

		// watermark badge
		$this->add_responsive_control(
			'lc_testimonial_section_wathermark_badge_radius',
			[
				'label' => esc_html__('Border Radius', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider-block-style-three .lc-icon-content.commentor-badge::before' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lc_testimonial_wartermark_mask_show_badge' => 'yes'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_section_wathermark_badge_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-testimonial-slider-block-style-three .lc-icon-content.commentor-badge::before',
				'condition' => [
					'lc_testimonial_wartermark_mask_show_badge' => 'yes'
				]
			]
		);
		$this->end_controls_section();
		// title separetor
		$this->start_controls_section(
			'lc_testimonial_title_separetor_tab',
			[
				'label' => esc_html__('Title Separetor', 'elementskit-lite'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lc_testimonial_title_separetor' => 'yes',
					'lc_testimonial_style' => ['style1', 'style2'],
				]
			]
		);

		$this->start_controls_tabs(
			'lc_testimonial_client_title_separetor_color_tabs'
		);

		$this->start_controls_tab(
			'lc_testimonial_client_title_separetor_normal_color_tab',
			[
				'label' => esc_html__('Normal', 'elementskit-lite'),
			]
		);
		$this->add_control(
			'lc_testimonial_title_separator_color',
			[
				'label'      => esc_html__('Separator Color', 'elementskit-lite'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .lc-single-testimonial-slider .lc-border-hr' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lc_testimonial_client_title_separetor_active_color_tab',
			[
				'label' => esc_html__('Hover', 'elementskit-lite'),
			]
		);

		$this->add_control(
			'lc_testimonial_title_separator_active_color',
			[
				'label'      => esc_html__('Separator Color', 'elementskit-lite'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .lc-single-testimonial-slider:hover .lc-border-hr' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'lc_testimonial_client_title_separetor_color_tab_end',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_title_separator_width',
			[
				'label' => esc_html__('Width', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-single-testimonial-slider .lc-border-hr' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_title_separator_height',
			[
				'label' => esc_html__('Height', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-single-testimonial-slider .lc-border-hr' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_title_separator_margin',
			[
				'label' => esc_html__('Margin', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .lc-single-testimonial-slider .lc-border-hr' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// client style
		$this->start_controls_section(
			'lc_testimonial_client_content_section',
			[
				'label' => esc_html__('Client', 'elementskit-lite'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// client name heading
		$this->add_control(
			'lc_testimonial_client_name_heading',
			[
				'label' => esc_html__('Client Name', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		// Client Name Color
		$this->add_control(
			'lc_testimonial_client_name_normal_color',
			[
				'label'		 => esc_html__('Color', 'elementskit-lite'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lc-profile-info .lc-author-name' => 'color: {{VALUE}};'
				],
			]
		);

		// Client Name Color
		$this->add_control(
			'lc_testimonial_client_name_active_color',
			[
				'label'		 => esc_html__('Hover & Active Color', 'elementskit-lite'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lc-single-testimonial-slider:hover .lc-author-name' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-author-name' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		 => 'lc_testimonial_client_name_typography',
				'selector'	 => '{{WRAPPER}} .lc-profile-info .lc-author-name',
			]
		);

		// client name margin bottom
		$this->add_responsive_control(
			'lc_testimonial_client_name_spacing_bottom',
			[
				'label' => esc_html__('Margin Bottom', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-profile-info .lc-author-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// client designation heading
		$this->add_control(
			'lc_testimonial_client_designation_heading',
			[
				'label' => esc_html__('Client Designation', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Designation Color
		$this->add_control(
			'lc_testimonial_designation_normal_color',
			[
				'label'		 => esc_html__('Color', 'elementskit-lite'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lc-profile-info .lc-author-des' => 'color: {{VALUE}};'
				],
			]
		);

		// Designation Hover Color
		$this->add_control(
			'lc_testimonial_designation_active_color',
			[
				'label'		 => esc_html__('Hover & Active Color', 'elementskit-lite'),
				'type'		 => \Elementor\Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .lc-single-testimonial-slider:hover .lc-author-des' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lc-single-testimonial-slider.testimonial-active .lc-author-des' => 'color: {{VALUE}};'
				],
			]
		);

		// Designation typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'		 => 'lc_testimonial_designation_typography',
				'selector'	 => '{{WRAPPER}} .lc-profile-info .lc-author-des',
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_spacing',
			[
				'label' => esc_html__('Margin', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-commentor-bio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// client logo heading
		$this->add_control(
			'lc_testimonial_client_logo_heading',
			[
				'label' => esc_html__('Client Logo', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'lc_testimonial_style' => ['style1', 'style2']
				]
			]
		);

		// client logo margin bottom
		$this->add_responsive_control(
			'lc_testimonial_client_logo_margin_bottom',
			[
				'label' => esc_html__('Margin Bottom', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-commentor-content .lc-client-logo' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lc_testimonial_style' => ['style1', 'style2']
				]
			]
		);

		/**
		 * Heading: Client Image
		 */
		$this->add_control(
			'lc_testimonial_client_image_heading',
			[
				'label' => esc_html__('Client Image', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'lc_testimonial_style' => ['style1', 'style4', 'style5', 'style6']
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_client_image_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-profile-image-card::before',
				'condition' => [
					'lc_testimonial_style' => ['style1']
				]
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_img_pos',
			[
				'label'		=> esc_html__('Image Position', 'elementskit-lite'),
				'type'		=> \Elementor\Controls_Manager::CHOOSE,
				'options'	=> [
					'left' => [
						'title'	=> esc_html__('Left', 'elementskit-lite'),
						'icon'	=> 'eicon-caret-left',
					],
					'top' => [
						'title'	=> esc_html__('Top', 'elementskit-lite'),
						'icon'	=> 'eicon-caret-up',
					],
					'bottom' => [
						'title'	=> esc_html__('Bottom', 'elementskit-lite'),
						'icon'	=> 'eicon-caret-down',
					],
					'right' => [
						'title'	=> esc_html__('Right', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-commentor-details' => '{{VALUE}}',
				],
				'condition'	=> [
					'lc_testimonial_style'	=> 'style5',
				],
			]
		);

		$this->add_control(
			'lc_testimonial_client_area_alignment',
			[
				'label' => esc_html__('Alignment', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'client_left'    => [
						'title' => esc_html__('Left', 'elementskit-lite'),
						'icon' => 'eicon-text-align-left',
					],
					'client_center' => [
						'title' => esc_html__('Center', 'elementskit-lite'),
						'icon' => 'eicon-text-align-center',
					],
					'client_right' => [
						'title' => esc_html__('Right', 'elementskit-lite'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'condition' => [
					'lc_testimonial_style' => ['style4', 'style5', 'style6']
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lc_testimonial_client_image_border',
				'label' => esc_html__('Border', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-commentor-image > img',
				'condition' => [
					'lc_testimonial_style' => ['style4', 'style5', 'style6']
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'lc_testimonial_client_image_box_shadow',
				'label' => esc_html__('Box Shadow', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-commentor-image > img',
				'condition' => [
					'lc_testimonial_style' => ['style4', 'style5', 'style6']
				]
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_image_size',
			[
				'label'   => esc_html__('Image Size', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-commentor-bio .lc-commentor-image > img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lc_testimonial_style' => ['style4', 'style5', 'style6']
				]
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_author_container_top',
			[
				'label' => esc_html__('Bottom', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-commentor-bio' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'lc_testimonial_style' => ['style4']
				]
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_image_margin_',
			[
				'label'			=> __('Margin', 'elementskit-lite'),
				'type'			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'	=> ['px', '%', 'em'],
				'selectors'		=> [
					'{{WRAPPER}} .lc-testimonial--avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'		=> [
					'lc_testimonial_style' => ['style4', 'style5', 'style6'],
				],
			]
		);
		$this->end_controls_section();
		// dot style
		$this->start_controls_section(
			'lc_testimonial_client_dot_tab',
			[
				'label' => esc_html__('Dot', 'elementskit-lite'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lc_testimonial_show_dot' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_dot_bottom',
			[
				'label' => esc_html__('Dot Top Spacing', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lc_testimonial_client_dot_width',
			[
				'label' => esc_html__('Width', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lc_testimonial_client_dot_height',
			[
				'label' => esc_html__('Height', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lc_testimonial_client_dot_border',
				'label' => esc_html__('Border', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span',
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_dot_border_radius',
			[
				'label' => esc_html__('Border radius', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_dot_spacing',
			[
				'label' => esc_html__('Margin right', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_client_dot_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span',
			]
		);
		$this->add_control(
			'lc_testimonial_client_dot_active_heading',
			[
				'label' => esc_html__('Active', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_client_dot_active_background',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active',
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_dot_active_width',
			[
				'label' => esc_html__('Width', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lc_testimonial_client_dot_active_height',
			[
				'label' => esc_html__('Height', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lc_testimonial_client_dot_active_border',
				'label' => esc_html__('Border', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active',
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_client_dot_active_scale',
			[
				'label' => esc_html__('Scale', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-pagination span.swiper-pagination-bullet-active' => 'transform: scale({{SIZE}});',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'lc_testimonial_nav_style_tab',
			[
				'label' => esc_html__('Nav', 'elementskit-lite'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'lc_testimonial_show_arrow' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_nav_font_size',
			[
				'label' => esc_html__('Font Size', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-navigation-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_nav_right_icon',
			[
				'label' => esc_html__('Prev', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_nav_left_icon',
			[
				'label' => esc_html__('Next', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_nav_width',
			[
				'label' => esc_html__('Width', 'elementskit-lite'),
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
									'{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .lc-testimonial-slider .swiper-button-next' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_nav_height',
			[
				'label' => esc_html__('Height', 'elementskit-lite'),
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
									'{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev' => 'height: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .lc-testimonial-slider .swiper-button-next' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_nav_vertical_align',
			[
				'label' => esc_html__('Vertical Align', 'elementskit-lite'),
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
					'{{WRAPPER}} .lc-testimonial-slider .swiper-navigation-button' => ' -webkit-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->start_controls_tabs(
			'lc_testimonial_nav_hover_normal_tabs'
		);

		$this->start_controls_tab(
			'lc_testimonial_nav_normal_tab',
			[
				'label' => esc_html__('Normal', 'elementskit-lite'),
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_nav_font_color_normal',
			[
				'label' => esc_html__('Color', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
									'{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev' => 'color: {{VALUE}}',
				'{{WRAPPER}} .lc-testimonial-slider .swiper-button-next' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_nav_background_normal',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev, {{WRAPPER}} .lc-testimonial-slider .swiper-button-next',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'lc_testimonial_nav_box_shadow_normal',
				'label' => esc_html__('Box Shadow', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev, {{WRAPPER}} .lc-testimonial-slider .swiper-button-next',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lc_testimonial_nav_border_normal',
				'label' => esc_html__('Border', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev, {{WRAPPER}} .lc-testimonial-slider .swiper-button-next',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lc_testimonial_nav_hover_tab',
			[
				'label' => esc_html__('Hover', 'elementskit-lite'),
			]
		);

		$this->add_responsive_control(
			'lc_testimonial_nav_font_color_hover',
			[
				'label' => esc_html__('Color', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
									'{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev:hover' => 'color: {{VALUE}}',
				'{{WRAPPER}} .lc-testimonial-slider .swiper-button-next:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'lc_testimonial_nav_background_hover',
				'label' => esc_html__('Background', 'elementskit-lite'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev:hover, {{WRAPPER}} .lc-testimonial-slider .swiper-button-next:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'lc_testimonial_nav_box_shadow_hover',
				'label' => esc_html__('Box Shadow', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev:hover, {{WRAPPER}} .lc-testimonial-slider .swiper-button-next:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'lc_testimonial_nav_border_hover',
				'label' => esc_html__('Border', 'elementskit-lite'),
				'selector' => '{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev:hover, {{WRAPPER}} .lc-testimonial-slider .swiper-button-next:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'lc_testimonial_nav_border_radius',
			[
				'label' => esc_html__('Border Radius', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
									'{{WRAPPER}} .lc-testimonial-slider .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'{{WRAPPER}} .lc-testimonial-slider .swiper-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'lc_price_menu_arrow_padding',
			[
				'label' => esc_html__('Padding', 'elementskit-lite'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .lc-testimonial-slider .swiper-navigation-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		echo '<div class="lc-main-wrapper" >';
		$this->render_raw();
		echo '</div>';
	}

	protected function render_raw()
	{

		wp_enqueue_style('lc-swiper-css');
		wp_enqueue_script('lc-swiper-js');
		wp_enqueue_script('lc-btsp-js');
		wp_enqueue_style('lc-btsp-css');
		wp_enqueue_script('lc-kit-testimonial-js');
		wp_enqueue_style('lc-kit-testimonial-css');

		$testimonials = [];
		$settings = $this->get_settings_for_display();
		extract($settings);

		// Alias mappings: ensure legacy ekit_* vars exist from lc_* settings
		$ekit_testimonial_style = $settings['ekit_testimonial_style'] ?? ($settings['lc_testimonial_style'] ?? 'style1');
		$ekit_testimonial_data = $settings['ekit_testimonial_data'] ?? ($settings['lc_testimonial_data'] ?? []);
		$ekit_testimonial_slidetoshow = $settings['ekit_testimonial_slidetoshow'] ?? ($settings['lc_testimonial_slidetoshow'] ?? 1);
		$ekit_testimonial_slidesToScroll = $settings['ekit_testimonial_slidesToScroll'] ?? ($settings['lc_testimonial_slidesToScroll'] ?? 1);
		$ekit_testimonial_slidetoshow_tablet = $settings['ekit_testimonial_slidetoshow_tablet'] ?? ($settings['lc_testimonial_slidetoshow_tablet'] ?? null);
		$ekit_testimonial_slidesToScroll_tablet = $settings['ekit_testimonial_slidesToScroll_tablet'] ?? ($settings['lc_testimonial_slidesToScroll_tablet'] ?? null);
		$ekit_testimonial_slidetoshow_mobile = $settings['ekit_testimonial_slidetoshow_mobile'] ?? ($settings['lc_testimonial_slidetoshow_mobile'] ?? null);
		$ekit_testimonial_slidesToScroll_mobile = $settings['ekit_testimonial_slidesToScroll_mobile'] ?? ($settings['lc_testimonial_slidesToScroll_mobile'] ?? null);
		$ekit_testimonial_left_right_spacing = $settings['ekit_testimonial_left_right_spacing'] ?? ($settings['lc_testimonial_left_right_spacing'] ?? ['size' => 15]);
		$ekit_testimonial_left_right_spacing_tablet = $settings['ekit_testimonial_left_right_spacing_tablet'] ?? ($settings['lc_testimonial_left_right_spacing_tablet'] ?? ['size' => 10]);
		$ekit_testimonial_left_right_spacing_mobile = $settings['ekit_testimonial_left_right_spacing_mobile'] ?? ($settings['lc_testimonial_left_right_spacing_mobile'] ?? ['size' => 10]);
		$ekit_testimonial_show_arrow = $settings['ekit_testimonial_show_arrow'] ?? ($settings['lc_testimonial_show_arrow'] ?? '');
		$ekit_testimonial_show_dot = $settings['ekit_testimonial_show_dot'] ?? ($settings['lc_testimonial_show_dot'] ?? '');
		$ekit_testimonial_pause_on_hover = $settings['ekit_testimonial_pause_on_hover'] ?? ($settings['lc_testimonial_pause_on_hover'] ?? 'yes');
		$ekit_testimonial_autoplay = $settings['ekit_testimonial_autoplay'] ?? ($settings['lc_testimonial_autoplay'] ?? 'no');
		$ekit_testimonial_speed = $settings['ekit_testimonial_speed'] ?? ($settings['lc_testimonial_speed'] ?? 1000);
		$ekit_testimonial_loop = $settings['ekit_testimonial_loop'] ?? ($settings['lc_testimonial_loop'] ?? '');
		$ekit_testimonial_wartermark_enable = $settings['ekit_testimonial_wartermark_enable'] ?? ($settings['lc_testimonial_wartermark_enable'] ?? '');
		$ekit_testimonial_wartermark_custom_position = $settings['ekit_testimonial_wartermark_custom_position'] ?? ($settings['lc_testimonial_wartermark_custom_position'] ?? '');
		$ekit_testimonial_wartermark_mask_show_badge = $settings['ekit_testimonial_wartermark_mask_show_badge'] ?? ($settings['lc_testimonial_wartermark_mask_show_badge'] ?? '');
		$ekit_testimonial_title_separetor = $settings['ekit_testimonial_title_separetor'] ?? ($settings['lc_testimonial_title_separetor'] ?? '');
		$ekit_testimonial_rating_enable = $settings['ekit_testimonial_rating_enable'] ?? ($settings['lc_testimonial_rating_enable'] ?? '');
		$ekit_testimonial_client_area_alignment = $settings['ekit_testimonial_client_area_alignment'] ?? ($settings['lc_testimonial_client_area_alignment'] ?? '');
		$ekit_testimonial_left_arrows = $settings['ekit_testimonial_left_arrows'] ?? ($settings['lc_testimonial_left_arrows'] ?? []);
		$ekit_testimonial_right_arrows = $settings['ekit_testimonial_right_arrows'] ?? ($settings['lc_testimonial_right_arrows'] ?? []);

		// Set default client image size
		$ekit_testimonial_client_image_size = isset($ekit_testimonial_client_image_size) ? $ekit_testimonial_client_image_size : ['size' => 70];

		$slides_to_show_count = $ekit_testimonial_slidetoshow ? $ekit_testimonial_slidetoshow : 1;
		$slides_to_scroll_count = $ekit_testimonial_slidesToScroll ? $ekit_testimonial_slidesToScroll : 1;

		// Config
		$config = [
			'rtl'				=> is_rtl(),
			'arrows'			=> $lc_testimonial_show_arrow ? true : false,
			'dots'				=> $lc_testimonial_show_dot ? true : false,
			'pauseOnHover'		=> $lc_testimonial_pause_on_hover ? true : false,
			'autoplay'			=> $lc_testimonial_autoplay ? true : false,
			'speed'				=> $lc_testimonial_speed ? $lc_testimonial_speed : 1000,
			'slidesPerGroup'	=> (int) $slides_to_scroll_count,
			'slidesPerView'		=> (int) $slides_to_show_count,
			'loop'				=> (!empty($lc_testimonial_loop) && $lc_testimonial_loop == 'yes') ? true : false,
			'spaceBetween' => isset($lc_testimonial_left_right_spacing['size']) ? ($lc_testimonial_left_right_spacing['size'] !== 0 ? $lc_testimonial_left_right_spacing['size'] : 0) : 15,
			'breakpoints'  => [
				320 => [
					'slidesPerView'      => !empty($lc_testimonial_slidetoshow_mobile) ? $lc_testimonial_slidetoshow_mobile : 1,
					'slidesPerGroup'     => !empty($lc_testimonial_slidesToScroll_mobile) ? $lc_testimonial_slidesToScroll_mobile : 1,
					'spaceBetween'       => !empty($lc_testimonial_left_right_spacing_mobile['size']) ? $lc_testimonial_left_right_spacing_mobile['size'] : 10,
				],
				768 => [
					'slidesPerView'      => !empty($lc_testimonial_slidetoshow_tablet) ? $lc_testimonial_slidetoshow_tablet : 2,
					'slidesPerGroup'     => !empty($lc_testimonial_slidesToScroll_tablet) ? $lc_testimonial_slidesToScroll_tablet : 1,
					'spaceBetween'       => !empty($lc_testimonial_left_right_spacing_tablet['size']) ? $lc_testimonial_left_right_spacing_tablet['size'] : 10,
				],
				1024 => [
					'slidesPerView'      =>  $slides_to_show_count,
					'slidesPerGroup'     =>  $slides_to_scroll_count,
					'spaceBetween'		=> !empty($lc_testimonial_left_right_spacing['size']) ? $lc_testimonial_left_right_spacing['size'] : 0,
				]
			],

		];

		// Debug: Log the config being generated
		error_log('LC Testimonial Config: ' . wp_json_encode($config));
		
		// HTML Attribute
		$this->add_render_attribute(
			'wrapper',
			[
				'data-config'	=> wp_json_encode($config),
			]
		);

		$style = isset($ekit_testimonial_style) ? sanitize_text_field($ekit_testimonial_style) : 'style1';
		// Swiper container
		$this->add_render_attribute(
			'swiper-container',
			[
				'class'	=> \LC_Kit_Utils::swiper_class($style),
			]
		);


		$testimonials = isset($ekit_testimonial_data) ? $ekit_testimonial_data : [];
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
