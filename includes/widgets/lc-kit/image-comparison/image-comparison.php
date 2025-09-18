<?php
/**
 * Image Comparison Widget
 * 
 * @package LCAKE_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Image_Comparison extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-image-comparison';
    }

    public function get_title() {
        return esc_html__('Image Comparison', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-image-before-after';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_keywords() {
        return ['image', 'comparison', 'before', 'after', 'slider', 'overlay'];
    }

    public function get_script_depends() {
        return ['lcake-kit-image-comparison','lcake-kit-twentytwenty','lcake-kit-jquery-event-move'];
    }

    public function get_style_depends() {
        return ['lcake-kit-image-comparison','lcake-kit-twentytwenty'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'lcake_img_comparison_section_items',
            [
                'label' => esc_html__( 'Items', 'lc-addons-kit-for-elementor' ),
            ]
        );


        $this->add_control(
            'lcake_img_comparison_container_style',
            [
                'label' => esc_html__( 'Container Style', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => esc_html__( 'Horizontal', 'lc-addons-kit-for-elementor' ),
                    'vertical' => esc_html__( 'Vertical', 'lc-addons-kit-for-elementor' ),
                ],
                'default' => 'vertical',
            ]
        );
        $this->add_control(
            'lcake_img_comparison_before_heading_section',
            [
                'label' => esc_html__( 'Before', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'lcake_img_comparison_image_before',
            [
                'label' => esc_html__( 'Choose Image', 'lc-addons-kit-for-elementor' ),
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
        $this->add_control(
            'lcake_img_comparison_label_before',
            [
                'label' => esc_html__( 'Label', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => 'Before',
            ]
        );
        $this->add_control(
            'lcake_img_comparison_after_heading_section',
            [
                'label' => esc_html__( 'After', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'lcake_img_comparison_image_after',
            [
                'label' => esc_html__( 'Choose Image', 'lc-addons-kit-for-elementor' ),
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
        $this->add_control(
            'lcake_img_comparison_label_after',
            [
                'label' => esc_html__( 'Label', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => 'After',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'lcake_img_comparison_section_settings',
            [
                'label' => esc_html__( 'Settings', 'lc-addons-kit-for-elementor' ),
            ]
        );
        $this->add_control(
			'lcake_img_comparison_offset',
			[
				'label' => esc_html__( 'Offset', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
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
                'description' => esc_html__('How much of the before image is visible when the page loads', 'lc-addons-kit-for-elementor'),
			]
		);
        $this->add_control(
            'lcake_img_comparison_overlay',
            [
                'label' => esc_html__( 'Remove overlay?', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                'label_off' => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
                'return_value' => true,
                'default' => false,
                'description' => esc_html__('Do not show the overlay with before and after', 'lc-addons-kit-for-elementor'),
            ]
        );
        $this->add_control(
            'lcake_img_comparison_move_slider_on_hover',
            [
                'label' => esc_html__( 'Move slider on hover?', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                'label_off' => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
                'return_value' => true,
                'default' => false,
                'description' => esc_html__('Move slider on mouse hover?', 'lc-addons-kit-for-elementor'),
            ]
        );
        $this->add_control(
            'lcake_img_comparison_click_to_move',
            [
                'label' => esc_html__( 'Click to move?', 'lc-addons-kit-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
                'label_off' => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
                'return_value' => true,
                'default' => false,
                'description' => esc_html__('Allow a user to click (or tap) anywhere on the image to move the slider to that location.', 'lc-addons-kit-for-elementor'),
            ]
        );
        $this->end_controls_section();

        /**
		 * General Style Section
		 */
		$this->start_controls_section(
			'lcake_img_comparison_general_style',
			array(
				'label'      => esc_html__( 'General', 'lc-addons-kit-for-elementor' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'        => 'lcake_img_comparison_container_border',
				'label'       => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} .lcake-image-comparison',
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_container_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'lcake_img_comparison_container_box_shadow',
				'exclude' => array('box_shadow_position'), // PHPCS:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
				'selector' => '{{WRAPPER}} .lcake-image-comparison',
			)
		);

		$this->end_controls_section();

		/**
		 * Label Style Section
		 */
		$this->start_controls_section(
			'lcake_img_comparison_label_style',
			array(
				'label'      => esc_html__( 'Label', 'lc-addons-kit-for-elementor' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => ['lcake_img_comparison_overlay!' => 'true'],
			)
		);

		$this->start_controls_tabs( 'lcake_img_comparison_tabs_label_styles' );

		$this->start_controls_tab(
			'lcake_img_comparison_tab_label_before',
			array(
				'label' => esc_html__( 'Before', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_before_label_color',
			array(
				'label' => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-before-label:before' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-after-label:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lcake_img_comparison_before_label_typography_group',
				'selector' => '{{WRAPPER}} .lcake-image-comparison .twentytwenty-before-label:before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_img_comparison_before_label_background_group',
				'selector' => '{{WRAPPER}} .lcake-image-comparison .twentytwenty-before-label:before',
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_before_label_margin',
			array(
				'label'      => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-before-label:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_before_label_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-before-label:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_img_comparison_tab_label_after',
			array(
				'label' => esc_html__( 'After', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_after_label_color',
			array(
				'label' => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-after-label:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lcake_img_comparison_after_label_typography_group',
				'selector' => '{{WRAPPER}} .lcake-image-comparison .twentytwenty-after-label:before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_img_comparison_after_label_background_group',
				'selector' => '{{WRAPPER}} .lcake-image-comparison .twentytwenty-after-label:before',
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_after_label_margin',
			array(
				'label'      => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-after-label:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_after_label_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-after-label:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Handle Style Section
		 */
		$this->start_controls_section(
			'lcake_img_comparison_handle_style',
			array(
				'label'      => esc_html__( 'Handle', 'lc-addons-kit-for-elementor' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_handle_control_width',
			array(
				'label'      => esc_html__( 'Control Width', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle'  => 'width: {{SIZE}}{{UNIT}}; margin-left: calc( {{SIZE}}{{UNIT}} / -2 );',
				)
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_handle_control_height',
			array(
				'label'      => esc_html__( 'Height', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle' => 'height: {{SIZE}}{{UNIT}};margin-top: calc( {{SIZE}}{{UNIT}} / -2 );',
				)
			)
		);

		$this->start_controls_tabs( 'lcake_img_comparison_tabs_handle_styles' );

		$this->start_controls_tab(
			'lcake_img_comparison_tab_handle_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_img_comparison_handle_control_background_group',
				'selector' => '{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle',
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_handle_arrow_color',
			array(
				'label' => esc_html__( 'Arrow Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default'     => '#000',
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle .twentytwenty-left-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}}',
				),
				'condition' => [
					'lcake_img_comparison_container_style' => 'horizontal'
				]
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_handle_arrow_color_vertical',
			array(
				'label' => esc_html__( 'Arrow Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default'     => '#000',
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle .twentytwenty-up-arrow' => 'border-bottom-color: {{VALUE}}',
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle .twentytwenty-down-arrow' => 'border-top-color: {{VALUE}}',
				),
				'condition' => [
					'lcake_img_comparison_container_style' => 'vertical'
				]
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'lcake_img_comparison_handle_control_box_shadow_group',
				'selector' => '{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_img_comparison_tab_handle_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_img_comparison_handle_control_background_hover_group',
				'selector' => '{{WRAPPER}} .lcake-image-comparison:hover .twentytwenty-handle',
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_handle_arrow_color_hover',
			array(
				'label' => esc_html__( 'Arrow Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,

				'selectors' => array(
					'{{WRAPPER}} .lcake-image-comparison:hover .twentytwenty-handle .twentytwenty-left-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .lcake-image-comparison:hover .twentytwenty-handle .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}}',
				),
				'condition' => [
					'lcake_img_comparison_container_style' => 'horizontal'
				]
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_handle_arrow_color_hover_vertical',
			array(
				'label' => esc_html__( 'Arrow Color', 'lc-addons-kit-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,

				'selectors' => array(
					'{{WRAPPER}} .lcake-image-comparison:hover .twentytwenty-handle .twentytwenty-up-arrow' => 'border-bottom-color: {{VALUE}}',
					'{{WRAPPER}} .lcake-image-comparison:hover .twentytwenty-handle .twentytwenty-down-arrow' => 'border-top-color: {{VALUE}}',
				),
				'condition' => [
					'lcake_img_comparison_container_style' => 'vertical'
				]
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'lcake_img_comparison_handle_control_box_shadow_hover_group',
				'selector' => '{{WRAPPER}} .lcake-image-comparison:hover .twentytwenty-handle',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'lcake_img_comparison_handle_divider_margin',
			array(
				'label'      => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_handle_divider_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'lcake_img_comparison_heading_handle_divider_style',
			array(
				'label'     => esc_html__( 'Handle Divider', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_handle_divider_width',
			array(
				'label'      => esc_html__( 'Divider Thickness', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:after' => 'height: {{SIZE}}{{UNIT}};',
				)
			)
		);

		$this->add_responsive_control(
			'lcake_img_comparison_handle_divider_color',
			array(
				'label'   => esc_html__( 'Divider Color', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-image-comparison .twentytwenty-handle:before, {{WRAPPER}} .lcake-image-comparison .twentytwenty-handle:after' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

    }

    protected function render() {
        echo '<div class="lcake-main-wrapper">';
            $this->render_raw();
        echo '</div>';
    }
    
    protected function render_raw() {
        $settings = $this->get_settings_for_display();
    
        // Wrapper class based on orientation
        if ($settings['lcake_img_comparison_container_style'] == 'vertical') {
            $this->add_render_attribute('image_comparison_wrapper', 'class', 'lcake-image-comparison image-comparison-container-vertical');
        } else {
            $this->add_render_attribute('image_comparison_wrapper', 'class', 'lcake-image-comparison image-comparison-container');
        }
    
        // Sanitize labels
        $label_after  = LCAKE_Kit_Utils::remove_special_chars($settings['lcake_img_comparison_label_after']);
        $label_before = LCAKE_Kit_Utils::remove_special_chars($settings['lcake_img_comparison_label_before']);
    
        // Add data attributes for JS
        $offset_pct = isset($settings['lcake_img_comparison_offset']['size']) ? floatval($settings['lcake_img_comparison_offset']['size']) / 100 : 0.5;
        $overlay    = !empty($settings['lcake_img_comparison_overlay']) ? 'true' : 'false';
        $hoverMove  = !empty($settings['lcake_img_comparison_move_slider_on_hover']) ? 'true' : 'false';
        $clickMove  = !empty($settings['lcake_img_comparison_click_to_move']) ? 'true' : 'false';

        $this->add_render_attribute(
            'image_comparison_wrapper',
            [
                'data-offset'               => esc_attr($offset_pct),
                'data-overlay'              => esc_attr($overlay),
                'data-label_after'          => esc_attr($label_after),
                'data-label_before'         => esc_attr($label_before),
                'data-move_slider_on_hover' => esc_attr($hoverMove),
                'data-click_to_move'        => esc_attr($clickMove),
            ]
        );
    
        // Collect both images
        $image_html = '';
        if (!empty($settings['lcake_img_comparison_image_before']['url'])) {
            $image_html .= \Elementor\Group_Control_Image_Size::get_attachment_image_html(
                $settings,
                'thumbnail',
                'lcake_img_comparison_image_before'
            );
        }
    
        if (!empty($settings['lcake_img_comparison_image_after']['url'])) {
            $image_html .= \Elementor\Group_Control_Image_Size::get_attachment_image_html(
                $settings,
                'thumbnail',
                'lcake_img_comparison_image_after'
            );
        }
        ?>
    
        <div <?php $this->print_render_attribute_string('image_comparison_wrapper'); ?>>
            <?php echo wp_kses($image_html, \LCAKE_Kit_Utils::get_kses_array()); ?>
        </div>
    
        <?php
    }    

} 