<?php
/**
 * Funfact Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Funfact Widget.
 *
 * Elementor widget that displays a Funfact.
 */
class LCAKE_Kit_Funfact extends \Elementor\Widget_Base {

	// The original snippet used a trait, we don't need it if not available

	public $base;

	public function get_style_depends() {
		return array( 'odometer' );
	}

	public function get_script_depends() {
		return array( 'odometer', 'lcake-kit-funfact-js' );
	}

	public function get_name() {
		return 'lcake-kit-funfact';
	}

	public function get_title() {
		return esc_html__( 'Funfact', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-number-field';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_keywords() {
		return array( 'funfact', 'counter', 'statistics', 'number', 'animation' );
	}

	public function get_help_url() {
		return '';
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	public function has_widget_inner_wrapper(): bool {
		return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'lcake_funfact_section_icon',
			array(
				'label' => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'lcake_funfact_icon_type',
			array(
				'label'   => esc_html__( 'Icon Type', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'icon'       => array(
						'title' => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-star',
					),
					'image_icon' => array(
						'title' => esc_html__( 'Image', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-image',
					),
					'none'       => array(
						'title' => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-stop-circle',
					),
				),
				'default' => 'icon',
				'toggle'  => true,
			)
		);

		$this->add_control(
			'lcake_funfact_icons__switch',
			array(
				'label'     => esc_html__( 'Enable Icon', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off' => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'condition' => array(
					'lcake_funfact_icon_type' => 'icon',
				),
			)
		);

		$this->add_control(
			'lcake_funfact_icons',
			array(
				'label'            => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type'             => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'lcake_funfact_icon',
				'default'          => array(
					'value'   => 'fas fa-shopping-cart', /* Using shopping cart as flipkart/flipcart might be missing in some setups */
					'library' => 'fa-solid',
				),
				'condition'        => array(
					'lcake_funfact_icon_type'     => 'icon',
					'lcake_funfact_icons__switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'lcake_funfact_view',
			array(
				'label'     => esc_html__( 'View', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'default'   => esc_html__( 'Default', 'lc-addons-kit-for-elementor' ),
					'fill-icon' => esc_html__( 'Stacked', 'lc-addons-kit-for-elementor' ),
					'framed'    => esc_html__( 'Framed', 'lc-addons-kit-for-elementor' ),
				),
				'default'   => 'default',
				'condition' => array(
					'lcake_funfact_icons[value]!' => '',
					'lcake_funfact_icon_type'     => 'icon',
				),
			)
		);

		$this->add_control(
			'lcake_funfact_icon_image',
			array(
				'label'     => esc_html__( 'Choose Image', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
					'id'  => -1,
				),
				'condition' => array(
					'lcake_funfact_icon_type' => 'image_icon',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'lcake_funfact_thumbnail',
				'default'   => 'thumbnail',
				'separator' => 'none',
				'condition' => array(
					'lcake_funfact_icon_type' => 'image_icon',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lcake_funfact_content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'lcake_funfact_number_prefix',
			array(
				'label'       => esc_html__( 'Number Prefix', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => '',
				'placeholder' => esc_html__( '$', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lcake_funfact_number',
			array(
				'label'       => esc_html__( 'Number Count', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => '254',
				'placeholder' => esc_html__( 'Enter number', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lcake_funfact_number_suffix',
			array(
				'label'       => esc_html__( 'Number Suffix', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => 'M',
				'placeholder' => esc_html__( 'M+', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lcake_funfact_title_text',
			array(
				'label'       => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'This is the heading', 'lc-addons-kit-for-elementor' ),
				'placeholder' => esc_html__( 'Enter your title', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'lcake_funfact_super',
			array(
				'label'   => esc_html__( 'Enable Super Text', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'lcake_funfact_super_text',
			array(
				'label'       => esc_html__( 'Super Text', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => '+',
				'placeholder' => esc_html__( '+', 'lc-addons-kit-for-elementor' ),
				'condition'   => array( 'lcake_funfact_super' => 'yes' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lcake_funfact_settings_items',
			array(
				'label' => esc_html__( 'Settings', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'lcake_funfact_style',
			array(
				'label'   => esc_html__( 'Animation Style', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'static',
				'options' => array(
					'static'  => esc_html__( 'Static', 'lc-addons-kit-for-elementor' ),
					'sliding' => esc_html__( 'Sliding', 'lc-addons-kit-for-elementor' ),
				),
				// Original had odometer setup dynamically via assets, preserving structure
				'assets'  => array(
					'style'   => array(
						array(
							'name'       => 'odometer',
							'conditions' => array(
								'terms' => array(
									array(
										'name'     => 'lcake_funfact_style',
										'operator' => '===',
										'value'    => 'sliding',
									),
								),
							),
						),
					),
					'scripts' => array(
						array(
							'name'       => 'odometer',
							'conditions' => array(
								'terms' => array(
									array(
										'name'     => 'lcake_funfact_style',
										'operator' => '===',
										'value'    => 'sliding',
									),
								),
							),
						),
					),
				),
			)
		);

		$this->add_control(
			'lcake_funfact_animation_duration',
			array(
				'label'   => esc_html__( 'Animation Duration (ms)', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 500,
				'max'     => 5000,
				'step'    => 100,
				'default' => 3500,
			)
		);

		$this->add_control(
			'lcake_funfact_icon_position',
			array(
				'label'                => esc_html__( 'Icon Position', 'lc-addons-kit-for-elementor' ),
				'type'                 => \Elementor\Controls_Manager::SELECT,
				'default'              => 'position_top',
				'options'              => array(
					'position_top'   => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
					'position_left'  => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
					'position_right' => esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
				),
				'condition'            => array(
					'lcake_funfact_icon_type' => array( 'icon', 'image_icon' ),
				),
				'selectors'            => array(
					'{{WRAPPER}} .lcake-funfact-inner' => 'display: flex; flex-direction: {{VALUE}}; align-items: center; justify-content: center;',
					'{{WRAPPER}} .lcake-funfact-inner.position_left .funfact-icon' => 'margin-bottom: 0; margin-right: 15px;',
					'{{WRAPPER}} .lcake-funfact-inner.position_right .funfact-icon' => 'margin-bottom: 0; margin-left: 15px;',
				),
				'selectors_dictionary' => array(
					'position_top'   => 'column',
					'position_left'  => 'row',
					'position_right' => 'row-reverse',
				),
			)
		);

		$this->add_control(
			'lcake_funfact_title_size',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default' => 'h3',
			)
		);

		$this->add_control(
			'lcake_funfact_separetor_one',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_control(
			'lcake_funfact_hover_border_bottom',
			array(
				'label'   => esc_html__( 'Enable Bottom Hover Border', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'lcake_funfact_hover_border_bottom_color',
			array(
				'label'     => esc_html__( 'Bottom Hover Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact.style-border-bottom:before' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'lcake_funfact_hover_border_bottom' => 'yes',
				),
			)
		);

		$this->add_control(
			'lcake_funfact_hover_border_bottom_direction',
			array(
				'label'     => esc_html__( 'Hover Direction', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'hover_from_left'  => array(
						'title' => esc_html__( 'From Left', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-caret-right',
					),
					'hover_from_right' => array(
						'title' => esc_html__( 'From Right', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-caret-left',
					),
				),
				'default'   => 'hover_from_right',
				'toggle'    => true,
				'condition' => array(
					'lcake_funfact_hover_border_bottom' => 'yes',
				),
			)
		);

		$this->add_control(
			'lcake_funfact_hover_border_bottom_direction_hr',
			array(
				'type'      => \Elementor\Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => array(
					'lcake_funfact_hover_border_bottom' => 'yes',
				),
			)
		);

		$this->add_control(
			'lcake_funfact_enable_vertical_border',
			array(
				'label'   => esc_html__( 'Enable Vertical Divider', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'lcake_funfact_enable_vertical_border_position',
			array(
				'label'     => esc_html__( 'Horizontal Position', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'border_left_side'  => array(
						'title' => esc_html__( 'From Left', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-caret-right',
					),
					'border_right_side' => array(
						'title' => esc_html__( 'From Right', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-caret-left',
					),
				),
				'default'   => 'border_right_side',
				'toggle'    => true,
				'condition' => array(
					'lcake_funfact_enable_vertical_border' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		// start Image style section for image
		$this->start_controls_section(
			'lcake_funfact_style_section_image',
			array(
				'label'      => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'conditions' => array(
					'terms' => array(
						array(
							'relation' => 'OR',
							'name'     => 'lcake_funfact_icons__switch',
							'operator' => 'in',
							'value'    => array(
								'yes',
							),
							'terms'    => array(
								array(
									'name'     => 'lcake_funfact_icon_type',
									'operator' => 'in',
									'value'    => array(
										'image_icon',
									),
								),
							),
						),
					),
				),
			)
		);
		$this->add_responsive_control(
			'lcake_funfact_icon_image_space',
			array(
				'label'     => esc_html__( 'Margin Bottom', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .funfact-icon img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->start_controls_tabs(
			'lcake_funfact_style_tabs_image'
		);

		$this->start_controls_tab(
			'lcake_funfact_style_img_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lcake_funfact_imge_border_group',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-funfact .funfact-icon img',
			)
		);
		$this->add_responsive_control(
			'lcake_funfact_icon_image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact .funfact-icon img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_funfact_iamge_box_shadow_group',
				'label'    => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-funfact .funfact-icon img',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_funfact_style_img_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lcake_funfact_imge_border_hover_group',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-funfact .funfact-icon img:hover',
			)
		);
		$this->add_responsive_control(
			'lcake_funfact_icon_image_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact .funfact-icon img:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_funfact_image_box_shadow_hv_group',
				'label'    => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-funfact .funfact-icon img:hover',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_icon_image_hover_animation',
			array(
				'label'    => esc_html__( 'Animation', 'lc-addons-kit-for-elementor' ),
				'type'     => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'selector' => '{{WRAPPER}} .lcake-funfact .funfact-icon img:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		// image style section

		// Icon Style Start
		$this->start_controls_section(
			'lcake_funfact_section_style_icon',
			array(
				'label'     => esc_html__( 'Icons', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'lcake_funfact_icons__switch' => 'yes',
					'lcake_funfact_icon_type'     => 'icon',

				),
			)
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'lcake_funfact_icon_colors_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_icon_primary_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .lcake-funfact-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-funfact .funfact-icon svg'    => 'color: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_icon_secondary_color_normal',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact svg' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lcake_funfact_border_group',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact svg',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_icon_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_funfact_icon_colors_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_hover_primary_color',
			array(
				'label'     => esc_html__( 'Primary Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact:hover .lcake-funfact-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-funfact:hover svg path'                  => 'stroke: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_hover_secondary_color',
			array(
				'label'     => esc_html__( 'Secondary Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact:hover .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact:hover svg' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'lcake_funfact_border_icon_group',
				'label'     => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector'  => '{{WRAPPER}} .lcake-funfact:hover .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact:hover svg',
				'condition' => array(
					'lcake_funfact_view!' => 'Stacked',
				),
			)
		);
		$this->add_responsive_control(
			'lcake_funfact_icon_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact:hover .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'lcake_funfact_icon_size',
			array(
				'label'     => esc_html__( 'Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 300,
					),
				),
				'default'   => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .funfact-icon svg'   => 'width: {{SIZE}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_icon_space',
			array(
				'label'     => esc_html__( 'Margin Bottom', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => -20,
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 15,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact svg' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_icon_padding',
			array(
				'label'     => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact svg' => 'padding: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'lcake_funfact_rotate',
			array(
				'label'     => esc_html__( 'Rotate', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0,
					'unit' => 'deg',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_funfact_icon_box_shadow_group',
				'selector' => '{{WRAPPER}} .lcake-funfact-icon, {{WRAPPER}} .lcake-funfact svg',
			)
		);

		$this->end_controls_section();
		// end icon style section

		// Content style start
		$this->start_controls_section(
			'lcake_funfact_section_style_content',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_text_align',
			array(
				'label'     => esc_html__( 'Alignment', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
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
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact' => 'justify-content: {{VALUE}}; display: flex;',
				),
				'toggle'    => true,
			)
		);

		$this->add_control(
			'lcake_funfact_heading_number',
			array(
				'label'     => esc_html__( 'Number Count', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_description_color',
			array(
				'label'     => esc_html__( 'Number Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .funfact-content .number-percentage-wraper' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lcake_funfact_number_typography',
				'label'    => esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-funfact .funfact-content .number-percentage-wraper',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_number_count_bottom_space',
			array(
				'label'     => esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .funfact-content .number-percentage-wraper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_number_count_right_space',
			array(
				'label'     => esc_html__( 'Right Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .funfact-content .number-percentage' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'lcake_funfact_heading_title',
			array(
				'label'     => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_title_bottom_space',
			array(
				'label'     => esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .funfact-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_title_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .funfact-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lcake_funfact_title_typography',
				'selector' => '{{WRAPPER}} .lcake-funfact .funfact-title',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_info_box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'      => '15',
					'right'    => '15',
					'bottom'   => '15',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => true,
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_content_margin',
			array(
				'label'      => esc_html__( 'Content Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .funfact-content ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
		// Content style end

		$this->start_controls_section(
			'lcake_funfact_super_controls',
			array(
				'label'     => esc_html__( 'Super', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'lcake_funfact_super' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_super_color',
			array(
				'label'     => esc_html__( 'Number Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .super' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lcake_funfact_super_typography',
				'label'    => esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-funfact .super',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_super_position_top',
			array(
				'label'      => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => -5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact .super' => 'top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_super_position_left_right',
			array(
				'label'      => esc_html__( 'Horizontal Space', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => -5,
						'max'  => 20,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact .super' => 'left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_super_vertical_position',
			array(
				'label'                => esc_html__( 'Vertical Position', 'lc-addons-kit-for-elementor' ),
				'type'                 => \Elementor\Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-v-align-top',
					),
					'middle' => array(
						'title' => esc_html__( 'Middle', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'default'              => 'top',
				'selectors_dictionary' => array(
					'top'    => 'super',
					'middle' => 'baseline',
					'bottom' => 'sub',
				),
				'selectors'            => array(
					'{{WRAPPER}} .lcake-funfact .super' => 'vertical-align: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		// Background style start
		$this->start_controls_section(
			'lcake_funfact_section_background_style',
			array(
				'label' => esc_html__( 'Container', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_funfact_bg',
				'label'    => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .lcake-funfact',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_bg_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact .lcake-funfact-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_funfact_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-funfact',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lc_kit_funfact_border',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-funfact',
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_border_radious',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'lcake_funfact_show_overly',
			array(
				'label'        => esc_html__( 'Enable Overlay', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);
		$this->add_responsive_control(
			'lcake_funfact_bg_ovelry_color',
			array(
				'label'     => esc_html__( 'Overlay Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-funfact .lcake-funfact-overlay' => 'background: {{VALUE}}',
				),
				'condition' => array(
					'lcake_funfact_show_overly' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lcake_funfact_divider_tab',
			array(
				'label'     => esc_html__( 'Divider', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'lcake_funfact_enable_vertical_border' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_divider_width',
			array(
				'label'      => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 3,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact .vertical-bar' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_funfact_divider_height',
			array(
				'label'      => esc_html__( 'Height', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-funfact .vertical-bar' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_funfact_divider_background',
				'label'    => esc_html__( 'Background', 'lc-addons-kit-for-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .lcake-funfact .vertical-bar',
			)
		);

		$this->add_control(
			'lcake_funfact_enable_border_verticaly_position',
			array(
				'label'   => esc_html__( 'Vertical Alignment', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'position_top'    => array(
						'title' => esc_html__( 'From Top', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-caret-up',
					),
					'position_center' => array(
						'title' => esc_html__( 'From Center', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-align-center',
					),
					'position_bottom' => array(
						'title' => esc_html__( 'From Down', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'fa fa-caret-down',
					),
				),
				'default' => 'position_center',
				'toggle'  => true,
			)
		);

		$this->end_controls_section();
	}


	protected function render() {
		echo '<div class="lcake-wid-con" >';
		$this->render_raw();
		echo '</div>';
	}


	protected function render_raw() {
		$settings = $this->get_settings_for_display();

		$text_align = isset( $settings['lcake_funfact_text_align'] ) ? $settings['lcake_funfact_text_align'] : 'center';

		$hover_border_bottom_direction = '';
		$vertically_devider_position   = '';
		$divider_funfact               = '';

		$enable_ovelry_color  = '';
		$modern_design        = '';
		$enable_border_bottom = '';

		if ( isset( $settings['lcake_funfact_show_overly'] ) && $settings['lcake_funfact_show_overly'] == 'yes' ) {
			$enable_ovelry_color = '<div class="elementor-background-overlay lcake-funfact-overlay"></div>';
		}
		if ( isset( $settings['lcake_funfact_hover_border_bottom'] ) && $settings['lcake_funfact_hover_border_bottom'] == 'yes' ) {
			$enable_border_bottom          = 'style-border-bottom';
			$hover_border_bottom_direction = isset( $settings['lcake_funfact_hover_border_bottom_direction'] ) ? $settings['lcake_funfact_hover_border_bottom_direction'] : '';
		}

		if ( isset( $settings['lcake_funfact_enable_vertical_border'] ) && $settings['lcake_funfact_enable_vertical_border'] == 'yes' ) {
			$divider_funfact             = 'divider_funfact';
			$vertically_devider_position = isset( $settings['lcake_funfact_enable_vertical_border_position'] ) ? $settings['lcake_funfact_enable_vertical_border_position'] : '';
		}

		// info box style

		$this->add_render_attribute( 'funfact_wrapper', 'class', 'lcake-funfact' . ' text-' . $text_align . ' ' . $enable_border_bottom . ' ' . $modern_design . ' ' . $hover_border_bottom_direction . ' ' . $divider_funfact . ' ' . $vertically_devider_position );

		// for image box
		$image_html = '';
		if ( ! empty( $settings['lcake_funfact_icon_image']['url'] ) ) {

			$this->add_render_attribute( 'image', 'src', $settings['lcake_funfact_icon_image']['url'] );
			$this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['lcake_funfact_icon_image'] ) );

			$image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'lcake_funfact_thumbnail', 'lcake_funfact_icon_image' );

		}

		?>

		<div <?php echo $this->get_render_attribute_string( 'funfact_wrapper' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor pre-sanitizes render attribute strings. ?>>
			<?php if ( isset( $settings['lcake_funfact_enable_vertical_border'] ) && $settings['lcake_funfact_enable_vertical_border'] == 'yes' ) : ?>
				<div class="vertical-bar <?php echo esc_attr( isset( $settings['lcake_funfact_enable_vertical_border_position'] ) ? $settings['lcake_funfact_enable_vertical_border_position'] : '' ); ?>"></div>
			<?php endif; ?>

			<div class="lcake-funfact-inner <?php echo ! empty( $settings['lcake_funfact_icon_position'] ) ? esc_attr( $settings['lcake_funfact_icon_position'] ) : ''; ?>">
				<?php if ( ( ( isset( $settings['lcake_funfact_icon_type'] ) ? $settings['lcake_funfact_icon_type'] : '' ) == 'image_icon' ) || ( ( isset( $settings['lcake_funfact_icon_type'] ) ? $settings['lcake_funfact_icon_type'] : '' ) == 'icon' ) ) : ?>
					<div class="funfact-icon">
						<?php
						if ( isset( $settings['lcake_funfact_icon_type'] ) && $settings['lcake_funfact_icon_type'] == 'image_icon' ) :
							echo wp_kses_post( $image_html );
						endif;

						if ( isset( $settings['lcake_funfact_icon_type'] ) && $settings['lcake_funfact_icon_type'] == 'icon' && isset( $settings['lcake_funfact_icons'] ) ) :
							\Elementor\Icons_Manager::render_icon(
								$settings['lcake_funfact_icons'],
								array(
									'aria-hidden' => 'true',
									'class'       => 'lcake-funfact-icon',
								)
							);
						endif;
						?>
					</div>
				<?php endif; ?>

				<div class="funfact-content">
					<div class="number-percentage-wraper">
						<?php echo esc_html( isset( $settings['lcake_funfact_number_prefix'] ) ? $settings['lcake_funfact_number_prefix'] : '' ); ?>
						<span class="number-percentage"
								data-value="<?php echo esc_attr( isset( $settings['lcake_funfact_number'] ) ? $settings['lcake_funfact_number'] : '' ); ?>"
								data-animation-duration="<?php echo esc_attr( isset( $settings['lcake_funfact_animation_duration'] ) ? $settings['lcake_funfact_animation_duration'] : '' ); ?>"
								data-style="<?php echo esc_attr( isset( $settings['lcake_funfact_style'] ) ? $settings['lcake_funfact_style'] : '' ); ?>">0</span>
						<?php echo esc_html( isset( $settings['lcake_funfact_number_suffix'] ) ? $settings['lcake_funfact_number_suffix'] : '' ); ?>
						<?php if ( isset( $settings['lcake_funfact_super'] ) && $settings['lcake_funfact_super'] == 'yes' ) : ?>
							<span class="super"><?php echo wp_kses_post( isset( $settings['lcake_funfact_super_text'] ) ? $settings['lcake_funfact_super_text'] : '' ); ?></span>
						<?php endif; ?>
					</div>

					<?php
						// Validate Title Tag
						$title_tag = \Elementor\Utils::validate_html_tag( isset( $settings['lcake_funfact_title_size'] ) ? $settings['lcake_funfact_title_size'] : 'h3' );

						echo '<' . esc_attr( $title_tag ) . ' class="funfact-title">';
						echo esc_html( isset( $settings['lcake_funfact_title_text'] ) ? $settings['lcake_funfact_title_text'] : '' );
						echo '</' . esc_attr( $title_tag ) . '>';
					?>
					<?php echo wp_kses_post( $enable_ovelry_color ); ?>
			</div>
		</div>
		</div>


		<?php
	}
}
