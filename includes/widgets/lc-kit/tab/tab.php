<?php

/**
 * Tab Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Tab Widget.
 *
 * Elementor widget that displays a Tab.
 */
class LCAKE_Kit_Tab extends \Elementor\Widget_Base {


	public function get_name() {
		return 'lcake-kit-tab';
	}

	public function get_title() {
		return esc_html__( 'Tab', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_keywords() {
		return array( 'tab', 'tabs', 'toggle', 'accordion', 'content' );
	}

	public function get_script_depends() {
		return array( 'lcake-kit-tab-js' );
	}

	public function get_style_depends() {
		return array( 'lcake-kit-tab-css' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_tab',
			array(
				'label' => esc_html__( 'Tab', 'lc-addons-kit-for-elementor' ),
			)
		);
		$this->add_control(
			'lcake_tab_style',
			array(
				'label'   => esc_html__( 'Style', 'lc-addons-kit-for-elementor' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => array(
					'horizontal' => esc_html__( 'Horizontal', 'lc-addons-kit-for-elementor' ),
					'vertical'   => esc_html__( 'Vertical', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_nav_width',
			array(
				'label'      => esc_html__( 'Vertical Nav Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%', '' ),
				'default'    => array(
					'size' => 30,
					'unit' => '%',
				),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-wraper.vertical .lcake-tab-nav' => 'flex-basis: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_style' => 'vertical',
				),
			)
		);

		$this->add_control(
			'lcake_tab_caret_style_choose',
			array(
				'label'        => esc_html__( 'Show Caret', 'lc-addons-kit-for-elementor' ),
				'type'         => Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'lcake_tab_caret_style',
			array(
				'label'     => esc_html__( 'Choose Style', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::SELECT,
				'default'   => 'lcake_tab_border_bottm',
				'options'   => array(
					'lcake_tab_border_bottm' => esc_html__( 'Style 1', 'lc-addons-kit-for-elementor' ),
					'lcake_tooltip_style'    => esc_html__( 'Style 2', 'lc-addons-kit-for-elementor' ),
					'lcake_heartbit_style'   => esc_html__( 'Style 3', 'lc-addons-kit-for-elementor' ),
					'lcake_pregress_style'   => esc_html__( 'Style 4', 'lc-addons-kit-for-elementor' ),
					'lcake_ribbon_style'     => esc_html__( 'Style 5', 'lc-addons-kit-for-elementor' ),
				),
				'condition' => array(
					'lcake_tab_caret_style_choose' => 'yes',
				),
			)
		);

		$this->add_control(
			'lcake_tab_fill_full_width',
			array(
				'label'        => esc_html__( 'Full Width Nav', 'lc-addons-kit-for-elementor' ),
				'type'         => Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'lcake_tab_style' => 'horizontal',
				),
			)
		);

		$this->add_control(
			'lcake_tab_header_icon_pos_style',
			array(
				'label'   => esc_html__( 'Nav Icon Position', 'lc-addons-kit-for-elementor' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'left-pos',
				'options' => array(
					'right-pos'  => esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
					'left-pos'   => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
					'top-pos'    => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
					'bottom-pos' => esc_html__( 'Bottom', 'lc-addons-kit-for-elementor' ),
				),
			)
		);
		$this->add_responsive_control(
			'lcake_tab_icon_margin_left',
			array(
				'label'      => esc_html__( 'Icon Spacing', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link.right-pos .lcake-tab-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link.right-pos .lcake-icon-image' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_header_icon_pos_style' => 'right-pos',
				),
			)
		);
		$this->add_responsive_control(
			'lcake_tab_icon_margin_right',
			array(
				'label'      => esc_html__( 'Icon Spacing', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link.left-pos .lcake-tab-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link.left-pos .lcake-icon-image' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_header_icon_pos_style' => 'left-pos',
				),
			)
		);
		$this->add_responsive_control(
			'lcake_tab_icon_margin_top',
			array(
				'label'      => esc_html__( 'Icon Spacing', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => '%',
				),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link.bottom-pos .lcake-tab-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link.bottom-pos .lcake-icon-image' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_header_icon_pos_style' => 'bottom-pos',
				),
			)
		);
		$this->add_responsive_control(
			'lcake_tab_icon_margin_bottom',
			array(
				'label'      => esc_html__( 'Icon Spacing', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 0,
					'unit' => '%',
				),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link.top-pos .lcake-tab-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link.top-pos .lcake-icon-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_header_icon_pos_style' => 'top-pos',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_wraper_position',
			array(
				'label'     => esc_html__( 'Nav Alignment', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-tab-wraper.lcake-fitcontent-tab:not(.vertical)' => 'text-align: {{VALUE}};',
				),
				'default'   => 'left',
				'condition' => array(
					'lcake_tab_style'            => 'horizontal',
					'lcake_tab_fill_full_width!' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_content_position',
			array(
				'label'     => esc_html__( 'Nav Item Alignment', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link' => 'justify-content: {{VALUE}};',
				),
				'default'   => 'center',
			)
		);

		$this->add_control(
			'lcake_hash_change',
			array(
				'label'              => esc_html__( 'Enable URL Hash', 'lc-addons-kit-for-elementor' ),
				'type'               => Elementor\Controls_Manager::SWITCHER,
				'return_value'       => '1',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'lcake_tab_trigger_type',
			array(
				'label'   => esc_html__( 'Toggle Type', 'lc-addons-kit-for-elementor' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'click',
				'options' => array(
					'click'      => esc_html__( 'Click', 'lc-addons-kit-for-elementor' ),
					'mouseenter' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
				),

			)
		);

		$repeater = new Elementor\Repeater();
		$repeater->add_control(
			'lcake_tab_title',
			array(
				'label'       => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'        => Elementor\Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'lcake_tab_title_is_active',
			array(
				'label'     => esc_html__( 'Keep this tab open? ', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::SWITCHER,
				'default'   => 'no',
				'label_on'  => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off' => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
			)
		);

		$repeater->add_control(
			'lcake_tab_title_icon_type',
			array(
				'label'       => esc_html__( 'Icon Type', 'lc-addons-kit-for-elementor' ),
				'type'        => Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => array(
					'none'  => array(
						'title' => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-ban',
					),
					'icon'  => array(
						'title' => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-paint-brush',
					),
					'image' => array(
						'title' => esc_html__( 'Image', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-image',
					),
				),
				'default'     => 'icon',
			)
		);
		$repeater->add_control(
			'lcake_tab_title_icons',
			array(
				'label'            => esc_html__( 'Title Icon', 'lc-addons-kit-for-elementor' ),
				'type'             => Elementor\Controls_Manager::ICONS,
				'label_block'      => true,
				'fa4compatibility' => 'lcake_tab_title_icon',
				'default'          => array(
					'value'   => 'icon icon-earth',
					'library' => 'lcakeicons',
				),
				'condition'        => array(
					'lcake_tab_title_icon_type' => 'icon',
				),
			)
		);

		$repeater->add_control(
			'lcake_tab_title_image',
			array(
				'label'     => esc_html__( 'Choose Image', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::MEDIA,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => array(
					'url' => Elementor\Utils::get_placeholder_image_src(),
					'id'  => -1,
				),
				'condition' => array(
					'lcake_tab_title_icon_type' => 'image',
				),
			)
		);
		$repeater->add_control(
			'lcake_tab_content',
			array(
				'label'       => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'type'        => Elementor\Controls_Manager::WYSIWYG,
				'dynamic'     => array(
					'active' => true,
				),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'lcake_tab_hr1',
			array(
				'type'  => Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);
		$repeater->add_responsive_control(
			'lcake_tab_title_border_radius_group',
			array(
				'label'      => esc_html__( 'Title Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav {{CURRENT_ITEM}} .lcake-nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'lcake_tab_items',
			array(
				'label'       => esc_html__( 'Tab content', 'lc-addons-kit-for-elementor' ),
				'type'        => Elementor\Controls_Manager::REPEATER,
				'separator'   => 'before',
				'title_field' => '{{ lcake_tab_title }}',
				'default'     => array(
					array(
						'lcake_tab_title'           => 'Services',
						'lcake_tab_content'         => '<p>We design and build fast, accessible websites and web apps.</p><ul><li>UX research & UI design</li><li>Custom WordPress/Headless development</li><li>Performance & Core Web Vitals</li></ul>',
						'lcake_tab_title_is_active' => 'yes',
					),
					array(
						'lcake_tab_title'   => 'About Us',
						'lcake_tab_content' => '<p>We are a team of designers and engineers focused on craft and outcomes. Over 7+ years, we have helped startups and brands launch faster and improve conversions.</p>',
					),
					array(
						'lcake_tab_title'   => 'FAQs',
						'lcake_tab_content' => '<p><strong>How long does a project take?</strong><br>Most projects take 3–8 weeks depending on scope.</p><p><strong>Do you offer support after launch?</strong><br>Yes—maintenance and optimization plans are available.</p><p><strong>What’s your pricing model?</strong><br>Fixed‑scope packages and monthly retainers.</p>',
					),
				),
				'fields'      => $repeater->get_controls(),
			)
		);
		// tab schema
		$this->add_control(
			'lcake_tab_schema',
			array(
				'label'     => esc_html__( 'TAB Schema', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::SWITCHER,
				'separator' => 'before',
			)
		);
		$this->end_controls_section();

		// Wrapper Control

		$this->start_controls_section(
			'lcake_tab_section_wrapper_style',
			array(
				'label' => esc_html__( 'Wrapper', 'lc-addons-kit-for-elementor' ),
				'tab'   => Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'lcake_tab_wrapper_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-wraper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_tab_wrapper_bg_group',
				'selector' => '{{WRAPPER}} .lcake-tab-wraper',
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lcake_tab_wrapper_border_group',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-tab-wraper',
			)
		);
		$this->add_responsive_control(
			'lcake_tab_wrapper_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-wraper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_tab_wrapper_box_shadow_group',
				'label'    => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-tab-wraper',
			)
		);

		$this->end_controls_section();

		// Header setting
		$this->start_controls_section(
			'lcake_tab_header_section_setting',
			array(
				'label' => esc_html__( 'Nav Wrapper  ', 'lc-addons-kit-for-elementor' ),
				'tab'   => Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'lcake_tab_nav_wrapper_width',
			array(
				'label'        => esc_html__( 'Make Fluid', 'lc-addons-kit-for-elementor' ),
				'type'         => Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_tab_nav_background_group',
				'label'    => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .lcake-tab-nav',
			)
		);
		$this->add_responsive_control(
			'lcake_tab_nav_header_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'lcake_tab_nav_header_margin',
			array(
				'label'      => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lcake_tab_nav_border_group',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-tab-nav',

			)
		);
		$this->add_responsive_control(
			'lcake_tab_nav_border_radius_group',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_tab_nav_header_box_shadow_group',
				'label'    => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-tab-nav',
			)
		);
		$this->end_controls_section();

		// Header Items
		$this->start_controls_section(
			'lcake_tab_nav_items_section_setting',
			array(
				'label' => esc_html__( 'Nav Items  ', 'lc-addons-kit-for-elementor' ),
				'tab'   => Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lcake_tab_header_title_typography_group',
				'label'    => esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-tab-nav .lcake-nav-item .lcake-nav-link',
			)
		);

		$this->add_responsive_control(
			'lcake_simple_tab_title_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 5,
					),
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link .lcake-tab-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-tab-wraper .lcake-nav-link .lcake-tab-icon svg' => 'max-width: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_spacing_right',
			array(
				'label'     => esc_html__( 'Margin Right', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
					'unit' => 'px',
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-tab-wraper:not(.vertical) .lcake-nav-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .lcake-tab-wraper:not(.vertical) .lcake-nav-item:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
					'{{WRAPPER}} .lcake-tab-wraper.vertical .lcake-tab-nav' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'lcake_tab_header_spacing_bottom',
			array(
				'label'     => esc_html__( 'Margin Bottom', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
					'unit' => 'px',
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-tab-wraper.vertical .lcake-nav-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-tab-wraper:not(.vertical) .lcake-tab-nav' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'lcake_tab_nav_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '14',
					'right'    => '35',
					'bottom'   => '14',
					'left'     => '35',
					'unit'     => 'px',
					'isLinked' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->start_controls_tabs(
			'lcake_tab_header_style_tabs_normal'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);
		$this->add_control(
			'lcake_tab_title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::COLOR,
				'default'   => '#2575fc',
				'selectors' => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'lcake_tab_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-link span.lcake-tab-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-link span.lcake-tab-icon path'   => 'stroke: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_tab_title_background_group',
				'label'    => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .lcake-tab-nav .lcake-nav-link',
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Border::get_type(),
			array(
				'name'           => 'lcake_tab_title_border_group',
				'label'          => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector'       => '{{WRAPPER}} .lcake-tab-nav .lcake-nav-link',
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width'  => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => false,
						),
					),
					'color'  => array(
						'default' => '#2575fc',
					),
				),
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_tab_tab_title_box_shadow_group',
				'label'    => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-tab-nav .lcake-nav-item .lcake-nav-link',
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_tab_header_style_tabs_active',
			array(
				'label' => esc_html__( 'Active', 'lc-addons-kit-for-elementor' ),
			)
		);
		$this->add_control(
			'lcake_tab_active_title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-link.active' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'lcake_tab_icon_color_active',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-link.active span.lcake-tab-icon' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-link.active span.lcake-tab-icon path'    => 'stroke: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_tab_title_active_background_group',
				'label'    => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .lcake-tab-nav .lcake-nav-link.active',
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lcake_tab_title_border_active_group',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-tab-nav .lcake-nav-link.active',
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_tab_tab_title_box_shadow_active_group',
				'label'    => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-tab-nav .lcake-nav-link.active',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'lcake_tab_nav_item_border_radious',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-item a.lcake-nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// First Child design

		$this->add_responsive_control(
			'lcake_nav_item_first_child',
			array(
				'label'     => esc_html__( 'First and Last Child Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'lcake_tab_nav_item_first_child_border_radious',
			array(
				'label'      => esc_html__( 'First Child Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-item:first-child a.lcake-nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_nav_item_first_child_border',
			array(
				'label'      => esc_html__( 'First Child Border Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-item:first-child a.lcake-nav-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_nav_item_last_child_border_radious',
			array(
				'label'      => esc_html__( 'Last Child Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-item:last-child a.lcake-nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_nav_item_last_child_border',
			array(
				'label'      => esc_html__( 'Last Child Border Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav .lcake-nav-item:last-child a.lcake-nav-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->end_controls_section();

		// Caret setting
		$this->start_controls_section(
			'lcake_tab_header_caret_section_setting',
			array(
				'label'     => esc_html__( 'Caret  ', 'lc-addons-kit-for-elementor' ),
				'tab'       => Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'lcake_tab_caret_style_choose' => 'yes',
				),
			)
		);

		// lcake_tab_border_bottm
		$this->add_responsive_control(
			'lcake_tab_header_caret_tab_border_bottm_width',
			array(
				'label'      => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_tab_border_bottm .lcake-nav-item .lcake-nav-link::before' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_tab_border_bottm' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_tab_border_bottm_height',
			array(
				'label'      => esc_html__( 'Height', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 3,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_tab_border_bottm .lcake-nav-item .lcake-nav-link::before' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_tab_border_bottm' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_tab_border_bottm_background',
				'label'     => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'     => array( 'classic', 'gradient', 'video' ),
				'selector'  => '{{WRAPPER}} .lcake-tab-nav.lcake_tab_border_bottm .lcake-nav-item .lcake-nav-link::before',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_tab_border_bottm' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_tab_border_bottm_bottom',
			array(
				'label'      => esc_html__( 'Bottom Icon Position', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake_tab_border_bottm.lcake-tab-nav .lcake-nav-item .lcake-nav-link::before' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_tab_border_bottm' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_tab_border_bottm_left',
			array(
				'label'      => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_tab_border_bottm .lcake-nav-item .lcake-nav-link::before' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_tab_border_bottm' ),
				),
			)
		);

		// lcake_tooltip_style
		$this->add_responsive_control(
			'lcake_tab_header_caret_tooltip_style_width',
			array(
				'label'      => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake_tooltip_style.lcake-tab-nav .lcake-nav-item .lcake-nav-link::before' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_tooltip_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_tooltip_style_height',
			array(
				'label'      => esc_html__( 'Height', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake_tooltip_style.lcake-tab-nav .lcake-nav-item .lcake-nav-link::before' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_tooltip_style' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_tooltip_style_background',
				'label'     => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .lcake_tooltip_style.lcake-tab-nav .lcake-nav-item .lcake-nav-link::before',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_tooltip_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_tooltip_style_bottom',
			array(
				'label'      => esc_html__( 'Bottom', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => -12,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake_tooltip_style.lcake-tab-nav .lcake-nav-item .lcake-nav-link::before' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_tooltip_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_tooltip_style_left',
			array(
				'label'      => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_tooltip_style .lcake-nav-item .lcake-nav-link::before' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_tooltip_style' ),
				),
			)
		);

		// lcake_heartbit_style
		$this->add_responsive_control(
			'lcake_tab_header_caret_heartbit_style_width',
			array(
				'label'      => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 70,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::before' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_heartbit_style_height',
			array(
				'label'      => esc_html__( 'Height', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 1,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::before' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_bottom_heartbit_style_line',
			array(
				'label'      => esc_html__( 'Bottom Line', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'%'  => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => -1,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::before' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_heartbit_style_background',
				'label'     => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::before',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_control(
			'lcake_tab_header_caret_heartbit_style_hr',
			array(
				'type'      => Elementor\Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_background_heartbit_style_heart_symbol',
				'label'     => esc_html__( 'Hear Symbol Background', 'lc-addons-kit-for-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::after',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_heartbit_style_border_heart_symbol',
				'label'     => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector'  => '{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::after',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_heartbit_style_heartbeat_width',
			array(
				'label'      => esc_html__( 'Caret Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::after' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_heartbit_style_heartbeat_height',
			array(
				'label'      => esc_html__( 'Caret Height', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::after' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_heartbit_style_bottom',
			array(
				'label'      => esc_html__( 'Bottom Position', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => -5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::after' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_heartbit_style_left',
			array(
				'label'      => esc_html__( 'Left Position', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_heartbit_style .lcake-nav-item .lcake-nav-link::after' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_heartbit_style' ),
				),
			)
		);

		// lcake_pregress_style
		$this->add_responsive_control(
			'lcake_tab_header_caret_pregress_style_line_width',
			array(
				'label'      => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::before' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_pregress_style_line_height',
			array(
				'label'      => esc_html__( 'Height', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 3,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake_pregress_style.lcake-tab-nav .lcake-nav-item .lcake-nav-link::before' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_pregress_style_bottom_line',
			array(
				'label'      => esc_html__( 'Bottom', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'%'  => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => -3,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::before' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_pregress_style_left_line',
			array(
				'label'      => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'%'  => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::before' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_pregress_style_background',
				'label'     => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::before',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_control(
			'lcake_tab_header_caret_background_heart_pregress_style_heading',
			array(
				'type'      => Elementor\Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_background_pregress_style_symbol',
				'label'     => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'default'   => '#ffffff',
				'selector'  => '{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::after',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_border_pregress_style_symbol',
				'label'     => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector'  => '.lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::after',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_pregress_style_width',
			array(
				'label'      => esc_html__( 'Caret Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::after' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_pregress_style_height',
			array(
				'label'      => esc_html__( 'Caret Height', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::after' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_pregress_style_bottom',
			array(
				'label'      => esc_html__( 'Bottom Icon Position', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => -10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::after' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_pregress_style_left',
			array(
				'label'      => esc_html__( 'Left Position', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::after' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_border_pregress_style_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_pregress_style .lcake-nav-item .lcake-nav-link::after' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_pregress_style' ),
				),
			)
		);

		// lcake_ribbon_style
		$this->add_responsive_control(
			'lcake_tab_header_caret_ribbon_width',
			array(
				'label'      => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_ribbon_style .lcake-nav-item .lcake-nav-link::before' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_ribbon_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_ribbon_height',
			array(
				'label'      => esc_html__( 'Height', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_ribbon_style .lcake-nav-item .lcake-nav-link::before' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_ribbon_style' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_ribbon_style_background',
				'label'     => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .lcake-tab-nav.lcake_ribbon_style .lcake-nav-item .lcake-nav-link::before',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_ribbon_style' ),
				),
			)
		);

		$this->add_control(
			'lcake_tab_header_caret_background_ribbon_style_heading',
			array(
				'type'      => Elementor\Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_ribbon_style' ),
				),
			)
		);

		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'lcake_tab_header_caret_background_heart_symbol',
				'label'     => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .lcake-tab-nav.lcake_ribbon_style .lcake-nav-item .lcake-nav-link::after',
				'condition' => array(
					'lcake_tab_caret_style' => array( 'lcake_ribbon_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_ribbon_style_width',
			array(
				'label'      => esc_html__( 'Caret Width', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_ribbon_style .lcake-nav-item .lcake-nav-link::after' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_ribbon_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_ribbon_style_height',
			array(
				'label'      => esc_html__( 'Caret Height', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_ribbon_style .lcake-nav-item .lcake-nav-link::after' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_ribbon_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_ribbon_style_bottom',
			array(
				'label'      => esc_html__( 'Bottom Position', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => -20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_ribbon_style .lcake-nav-item .lcake-nav-link::after' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_ribbon_style' ),
				),
			)
		);

		$this->add_responsive_control(
			'lcake_tab_header_caret_ribbon_style_left',
			array(
				'label'      => esc_html__( 'Left Position', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-tab-nav.lcake_ribbon_style .lcake-nav-item .lcake-nav-link::after' => 'transform:translateX(-100%);left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'lcake_tab_caret_style' => array( 'lcake_ribbon_style' ),
				),
			)
		);

		$this->end_controls_section();

		// Body Style Section

		$this->start_controls_section(
			'lcake_tab_section_body_style',
			array(
				'label' => esc_html__( 'Body', 'lc-addons-kit-for-elementor' ),
				'tab'   => Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'lcake_tab_body_color',
			array(
				'label'     => esc_html__( 'Body Color', 'lc-addons-kit-for-elementor' ),
				'type'      => Elementor\Controls_Manager::COLOR,
				'default'   => '#656565',
				'selectors' => array(
					'{{WRAPPER}} .tab-content .tab-pane' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'lcake_tab_body_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '20',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .tab-content .tab-pane' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_tab_body_bg_group',
				'selector' => '{{WRAPPER}} .tab-content .tab-pane',
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lcake_tab_body_content_border_group',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .tab-content .tab-pane',
			)
		);
		$this->add_responsive_control(
			'lcake_tab_body_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .tab-content .tab-pane' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_tab_body_box_shadow_group',
				'label'    => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .tab-content .tab-pane',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		echo '<div class="lcake-main-wrapper" >';
		$this->template();
		echo '</div>';
	}

	protected function template() {

		$settings = $this->get_settings_for_display();

		extract( $settings );

		$nav_wrapper_class = 'nav nav-tabs lcake-tab-nav ';

		if ( $lcake_tab_caret_style_choose == 'yes' ) {
			$nav_wrapper_class .= ' ' . $lcake_tab_caret_style;
		}

		if ( $lcake_tab_caret_style_choose == 'yes' ) {
			$nav_wrapper_class .= ' ' . $lcake_tab_caret_style;
		}

		if ( $lcake_tab_fill_full_width == 'yes' ) {
			$nav_wrapper_class .= ' lcake-fullwidth-tab';
		}

		if ( $lcake_tab_nav_wrapper_width == 'yes' ) {
			$nav_wrapper_class .= ' tab-nav-fluid';
		}

		$tab_id = uniqid();

		$has_user_defined_active_tab = false;
		foreach ( $lcake_tab_items as $tab ) {
			if ( $tab['lcake_tab_title_is_active'] == 'yes' ) {
				$has_user_defined_active_tab = true;
			}
		}

		?>
		<div class="lcake-tab-wraper <?php echo esc_attr( $lcake_tab_style == 'vertical' ? 'vertical' : '' ); ?>
		<?php
		if ( $lcake_tab_fill_full_width != 'yes' ) :
			?>
			lcake-fitcontent-tab <?php endif; ?>">
			<ul class="<?php echo esc_attr( $nav_wrapper_class ); ?>">
				<?php
				foreach ( $lcake_tab_items as $i => $tab ) :
					$is_active = ( $tab['lcake_tab_title_is_active'] == 'yes' ) ? ' active show' : '';
					$is_active = ( $has_user_defined_active_tab == false && $i == 0 ) ? ' active show' : $is_active;

					// new icon
					$migrated = isset( $tab['__fa4_migrated']['lcake_tab_title_icons'] );
					// Check if its a new widget without previously selected icon using the old Icon control
					$is_new = empty( $tab['lcake_tab_title_icon'] );

					if ( $is_new || $migrated ) {
						ob_start();
						Elementor\Icons_Manager::render_icon( $tab['lcake_tab_title_icons'], array( 'aria-hidden' => 'true' ) );
						$rendered_icon = ob_get_clean();

						$icon_html = ! empty( $tab['lcake_tab_title_icons'] ) ? ( $tab['lcake_tab_title_icons']['library'] === 'svg' ? '<span class="lcake-tab-icon">' . $rendered_icon . '</span>' : '<span class="' . $tab['lcake_tab_title_icons']['value'] . ' lcake-tab-icon"></span>' ) : '';
					} else {
						$icon_html = '<span class="' . $tab['lcake_tab_title_icon'] . ' lcake-tab-icon"></span>';
					}

					$img_html = isset( $tab['lcake_tab_title_icon_type'] ) && ( $tab['lcake_tab_title_icon_type'] == 'image' && ! empty( $tab['lcake_tab_title_image']['url'] ) ) ?
						'<div class="lcake-icon-image">' . LCAKE_Kit_Utils::get_attachment_image_html(
							$tab,
							'lcake_tab_title_image',
							'full',
							array(
								'draggable' => 'false',
							)
						) . '</div>' : '';

					// URL Hash id
					$handler_id = ( ( $tab['lcake_tab_title'] ) != '' ? strtolower( preg_replace( '![^a-z0-9]+!i', '-', $tab['lcake_tab_title'] ) ) : ( 'tab-' . $tab['_id'] ) );
					?>
					<li class="lcake-nav-item elementor-repeater-item-<?php echo esc_attr( $tab['_id'] ); ?>">
						<a class="lcake-nav-link <?php echo esc_attr( $is_active ); ?> <?php echo esc_attr( $lcake_tab_header_icon_pos_style ); ?>" id="content-<?php echo esc_attr( $tab['_id'] . $tab_id ); ?>-tab" data-lcake-handler-id="<?php echo esc_html( $handler_id ); ?>" data-lcake-toggle="tab" data-target="#content-<?php echo esc_attr( $tab['_id'] . $tab_id ); ?>" href="#Content-<?php echo esc_attr( $tab['_id'] . $tab_id ); ?>"
							data-lcake-toggle-trigger="<?php echo esc_attr( $lcake_tab_trigger_type ); ?>"
							aria-describedby="Content-<?php echo esc_attr( $tab['_id'] . $tab_id ); ?>">
							<?php echo wp_kses( $icon_html . $img_html, LCAKE_Kit_Utils::get_kses_array() ); ?>
							<span class="lcake-tab-title"> <?php $this->print_unescaped_setting( 'lcake_tab_title', 'lcake_tab_items', $i ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="tab-content lcake-tab-content">
				<?php
				foreach ( $lcake_tab_items as $i => $tab ) :
					$is_active = ( $tab['lcake_tab_title_is_active'] == 'yes' ) ? ' active show' : '';
					$is_active = ( $has_user_defined_active_tab == false && $i == 0 ) ? ' active show' : $is_active;
					?>
					<div class="tab-pane lcake-tab-pane elementor-repeater-item-<?php echo esc_attr( $tab['_id'] ); ?> <?php echo esc_attr( $is_active ); ?>" id="content-<?php echo esc_attr( $tab['_id'] . $tab_id ); ?>" role="tabpanel"
						aria-labelledby="content-<?php echo esc_attr( $tab['_id'] . $tab_id ); ?>-tab">
						<div class="animated fadeIn">
							<?php $this->print_text_editor( $tab['lcake_tab_content'] ); ?>
						</div>
					</div>
				<?php endforeach; ?>

			</div>
			<?php
			if ( isset( $settings['lcake_tab_schema'] ) && 'yes' === $settings['lcake_tab_schema'] ) {
				$json = array(
					'@context'   => 'https://schema.org',
					'@type'      => 'FAQPage',
					'mainEntity' => array(),
				);

				foreach ( $settings['lcake_tab_items'] as $index => $item ) {
					$faq_tab_text         = ! empty( $item['lcake_tab_content'] ) ? $item['lcake_tab_content'] : '';
					$json['mainEntity'][] = array(
						'@type'          => 'Question',
						'name'           => esc_html( $item['lcake_tab_title'] ),
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => LCAKE_Kit_Utils::kses( $faq_tab_text ),
						),
					);
				}
				?>
				<script type="application/ld+json">
					<?php echo wp_json_encode( $json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?>
				</script>
				<?php
			}
			?>
		</div>
		<?php
	}
}
