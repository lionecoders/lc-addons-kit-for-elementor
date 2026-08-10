<?php
/**
 * Post Timeline Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Timeline Widget.
 *
 * Elementor widget that displays a Post Timeline.
 */
class LCAKE_Kit_Post_Timeline extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-post-timeline';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Post Timeline', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-post-timeline-css' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'timeline_layout',
			array(
				'label'   => esc_html__( 'Layout', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'alternating',
				'options' => array(
					'left'        => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
					'alternating' => esc_html__( 'Alternating', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'timeline_source',
			array(
				'label'   => esc_html__( 'Source', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => array(
					'custom' => esc_html__( 'Custom Items', 'lc-addons-kit-for-elementor' ),
					'posts'  => esc_html__( 'Dynamic Posts', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-flag',
					'library' => 'fa-solid',
				),
			)
		);

		$repeater->add_control(
			'date',
			array(
				'label'   => esc_html__( 'Date', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Jan 2024', 'lc-addons-kit-for-elementor' ),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Milestone Title', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'timeline_items',
			array(
				'label'       => esc_html__( 'Timeline Items', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'date'  => 'Jan 2023',
						'title' => esc_html__( 'Company Founded', 'lc-addons-kit-for-elementor' ),
					),
					array(
						'date'  => 'Jun 2023',
						'title' => esc_html__( 'First Product Launch', 'lc-addons-kit-for-elementor' ),
					),
					array(
						'date'  => 'Dec 2023',
						'title' => esc_html__( '1000 Customers', 'lc-addons-kit-for-elementor' ),
					),
				),
				'title_field' => '{{{ title }}}',
				'condition'   => array(
					'timeline_source' => 'custom',
				),
			)
		);

		$post_types        = get_post_types( array( 'public' => true ), 'objects' );
		$post_type_options = array();
		foreach ( $post_types as $post_type ) {
			if ( 'attachment' === $post_type->name ) {
				continue;
			}
			$post_type_options[ $post_type->name ] = $post_type->label;
		}

		$this->add_control(
			'post_type',
			array(
				'label'     => esc_html__( 'Post Type', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'post',
				'options'   => $post_type_options,
				'condition' => array(
					'timeline_source' => 'posts',
				),
			)
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'     => esc_html__( 'Posts Count', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 6,
				'min'       => 1,
				'max'       => 50,
				'condition' => array(
					'timeline_source' => 'posts',
				),
			)
		);

		$this->add_control(
			'order_by',
			array(
				'label'     => esc_html__( 'Order By', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'date',
				'options'   => array(
					'date'  => esc_html__( 'Date', 'lc-addons-kit-for-elementor' ),
					'title' => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
					'rand'  => esc_html__( 'Random', 'lc-addons-kit-for-elementor' ),
				),
				'condition' => array(
					'timeline_source' => 'posts',
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'label'     => esc_html__( 'Order', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'DESC',
				'options'   => array(
					'DESC' => esc_html__( 'Descending', 'lc-addons-kit-for-elementor' ),
					'ASC'  => esc_html__( 'Ascending', 'lc-addons-kit-for-elementor' ),
				),
				'condition' => array(
					'timeline_source' => 'posts',
				),
			)
		);

		$this->add_control(
			'posts_icon',
			array(
				'label'     => esc_html__( 'Post Icon', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-flag',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'timeline_source' => 'posts',
				),
			)
		);

		$this->add_control(
			'show_excerpt',
			array(
				'label'     => esc_html__( 'Show Excerpt', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'timeline_source' => 'posts',
				),
			)
		);

		$this->add_control(
			'excerpt_length',
			array(
				'label'     => esc_html__( 'Excerpt Length (words)', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 20,
				'condition' => array(
					'timeline_source' => 'posts',
					'show_excerpt'    => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_line',
			array(
				'label' => esc_html__( 'Line', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'line_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#e5e7eb',
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline' => '--lcake-timeline-line: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'line_width',
			array(
				'label'     => esc_html__( 'Line Thickness', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'default'   => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline::before' => 'border-left-width: {{SIZE}}{{UNIT}}; left: calc(20px - {{SIZE}}{{UNIT}} / 2);',
				),
			)
		);

		$this->add_control(
			'line_style',
			array(
				'label'     => esc_html__( 'Line Style', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'solid'  => esc_html__( 'Solid', 'lc-addons-kit-for-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'lc-addons-kit-for-elementor' ),
					'dotted' => esc_html__( 'Dotted', 'lc-addons-kit-for-elementor' ),
					'double' => esc_html__( 'Double', 'lc-addons-kit-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline::before' => 'border-left-style: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_badge',
			array(
				'label' => esc_html__( 'Badge', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'badge_size',
			array(
				'label'     => esc_html__( 'Circle Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 20,
						'max' => 80,
					),
				),
				'default'   => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; left: calc(-30px - {{SIZE}}{{UNIT}} / 2);',
				),
			)
		);

		$this->start_controls_tabs( 'badge_color_states' );

		$this->start_controls_tab(
			'badge_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'badge_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-icon' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'badge_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-post-timeline-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'badge_border_color',
			array(
				'label'     => esc_html__( 'Gap Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-icon' => 'box-shadow: 0 0 0 {{badge_border_width.SIZE}}px {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'badge_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'badge_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-icon' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'badge_hover_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'badge_hover_border_color',
			array(
				'label'     => esc_html__( 'Gap Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-icon' => 'box-shadow: 0 0 0 {{badge_border_width.SIZE}}px {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'badge_icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 40,
					),
				),
				'default'   => array(
					'size' => 15,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-post-timeline-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'badge_border_width',
			array(
				'label'     => esc_html__( 'Gap Border Width', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'default'   => array(
					'size' => 6,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-icon' => 'box-shadow: 0 0 0 {{SIZE}}px {{badge_border_color.VALUE}};',
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-icon' => 'box-shadow: 0 0 0 {{SIZE}}px {{badge_hover_border_color.VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-post-timeline-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => esc_html__( 'Card', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'card_color_states' );

		$this->start_controls_tab(
			'card_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'card_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-content' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .lcake-post-timeline-content',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'card_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-content' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_hover_shadow',
				'selector' => '{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-content',
			)
		);

		$this->add_control(
			'card_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-content' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-post-timeline-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-post-timeline-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-post-timeline-content',
			)
		);

		$this->add_responsive_control(
			'card_hover_translate_x',
			array(
				'label'     => esc_html__( 'Hover Translate X (px)', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'default'   => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-content' => 'transform: translateX({{SIZE}}px);',
				),
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'     => esc_html__( 'Spacing Between Items', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 36,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_date',
			array(
				'label' => esc_html__( 'Date', 'lc-addons-kit-for-elementor' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->start_controls_tabs( 'date_color_states' );

		$this->start_controls_tab(
			'date_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'date_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-date' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'date_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'date_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-date' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'date_typography',
				'selector' => '{{WRAPPER}} .lcake-post-timeline-date',
			)
		);

		$this->add_responsive_control(
			'date_margin_bottom',
			array(
				'label'     => esc_html__( 'Spacing Below Date', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'   => array(
					'size' => 6,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-date' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading_title',
			array(
				'label'     => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'title_color_states' );

		$this->start_controls_tab(
			'title_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .lcake-post-timeline-title',
			)
		);

		$this->add_responsive_control(
			'title_margin_bottom',
			array(
				'label'     => esc_html__( 'Spacing Below Title', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'   => array(
					'size' => 8,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_hover_underline',
			array(
				'label'     => esc_html__( 'Title Hover Underline', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'      => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
					'underline' => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-title a:hover' => 'text-decoration: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'heading_description',
			array(
				'label'     => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'desc_color_states' );

		$this->start_controls_tab(
			'desc_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6b7280',
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'desc_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'desc_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-post-timeline-item:hover .lcake-post-timeline-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .lcake-post-timeline-description',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$source       = $settings['timeline_source'] ?? 'custom';
		$layout_class = 'lcake-post-timeline--' . ( $settings['timeline_layout'] ?? 'alternating' );

		if ( 'posts' === $source ) {
			$query = new \WP_Query(
				array(
					'post_type'           => $settings['post_type'],
					'posts_per_page'      => (int) $settings['posts_per_page'],
					'orderby'             => $settings['order_by'],
					'order'               => $settings['order'],
					'ignore_sticky_posts' => true,
				)
			);

			if ( ! $query->have_posts() ) {
				return;
			}
			?>
			<div class="lcake-post-timeline <?php echo esc_attr( $layout_class ); ?>">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					?>
					<div class="lcake-post-timeline-item">
						<div class="lcake-post-timeline-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['posts_icon'], array( 'aria-hidden' => 'true' ) ); ?>
						</div>
						<div class="lcake-post-timeline-content">
							<span class="lcake-post-timeline-date"><?php echo esc_html( get_the_date() ); ?></span>
							<h4 class="lcake-post-timeline-title">
								<a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
							</h4>
							<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
								<p class="lcake-post-timeline-description">
									<?php echo esc_html( wp_trim_words( get_the_excerpt(), (int) $settings['excerpt_length'], '...' ) ); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<?php
			wp_reset_postdata();
		} else {
			$items = $settings['timeline_items'] ?? array();
			if ( empty( $items ) ) {
				return;
			}
			?>
			<div class="lcake-post-timeline <?php echo esc_attr( $layout_class ); ?>">
				<?php foreach ( $items as $item ) : ?>
					<div class="lcake-post-timeline-item">
						<div class="lcake-post-timeline-icon">
							<?php \Elementor\Icons_Manager::render_icon( $item['icon'], array( 'aria-hidden' => 'true' ) ); ?>
						</div>
						<div class="lcake-post-timeline-content">
							<?php if ( ! empty( $item['date'] ) ) : ?>
								<span class="lcake-post-timeline-date"><?php echo esc_html( $item['date'] ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $item['title'] ) ) : ?>
								<h4 class="lcake-post-timeline-title"><?php echo esc_html( $item['title'] ); ?></h4>
							<?php endif; ?>
							<?php if ( ! empty( $item['description'] ) ) : ?>
								<p class="lcake-post-timeline-description"><?php echo wp_kses_post( $item['description'] ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php
		}
	}
}
