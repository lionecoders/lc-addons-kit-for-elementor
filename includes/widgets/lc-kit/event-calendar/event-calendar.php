<?php
/**
 * Event Calendar Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LCAKE_Kit_Event_Calendar extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-event-calendar';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Event Calendar', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-calendar';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-event-calendar-css' );
	}

	public function get_script_depends() {
		return array( 'lcake-kit-event-calendar-js' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'event_date',
			array(
				'label'          => esc_html__( 'Date', 'lc-addons-kit-for-elementor' ),
				'type'           => \Elementor\Controls_Manager::DATE_TIME,
				'picker_options' => array( 'enableTime' => false ),
			)
		);

		$repeater->add_control(
			'event_title',
			array(
				'label'   => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Event', 'lc-addons-kit-for-elementor' ),
			)
		);

		$repeater->add_control(
			'event_description',
			array(
				'label'       => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => '',
				'placeholder' => esc_html__( 'Event description...', 'lc-addons-kit-for-elementor' ),
			)
		);

		$repeater->add_control(
			'event_link',
			array(
				'label'   => esc_html__( 'Link', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => array( 'url' => '' ),
			)
		);

		$this->add_control(
			'events',
			array(
				'label'       => esc_html__( 'Events', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ event_title }}} — {{{ event_date }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_container',
			array(
				'label' => esc_html__( 'Calendar Container', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'container_width',
			array(
				'label'      => esc_html__( 'Max Width', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 200,
						'max' => 1000,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 380,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-event-calendar' => 'max-width: {{SIZE}}{{UNIT}}; width: 100%;',
				),
			)
		);

		$this->add_control(
			'container_background',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .lcake-event-calendar',
			)
		);

		$this->add_control(
			'container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-event-calendar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-event-calendar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .lcake-event-calendar',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'Calendar Header', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'header_title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'header_title_typography',
				'selector' => '{{WRAPPER}} .lcake-event-calendar-title',
			)
		);

		$this->add_control(
			'heading_nav_buttons',
			array(
				'label'     => esc_html__( 'Navigation Buttons', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_nav_buttons' );

		$this->start_controls_tab(
			'tab_nav_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'nav_button_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f3f4f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-nav' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_button_color',
			array(
				'label'     => esc_html__( 'Icon/Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#374151',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-nav' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_nav_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'nav_button_bg_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#e5e7eb',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-nav:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_button_color_hover',
			array(
				'label'     => esc_html__( 'Icon/Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-nav:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'nav_button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-event-calendar-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_weekdays',
			array(
				'label' => esc_html__( 'Weekdays', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'weekdays_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#9ca3af',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-weekdays span' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'weekdays_typography',
				'selector' => '{{WRAPPER}} .lcake-event-calendar-weekdays span',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_days',
			array(
				'label' => esc_html__( 'Calendar Days', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'days_typography',
				'selector' => '{{WRAPPER}} .lcake-event-calendar-day',
			)
		);

		$this->add_control(
			'days_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-event-calendar-day' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_days_style' );

		$this->start_controls_tab(
			'tab_days_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'days_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#374151',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day:not(.is-empty):not(.has-event)' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'days_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day:not(.is-empty):not(.has-event)' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_days_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'days_color_hover',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day:not(.is-empty):not(.has-event):hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'days_bg_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day:not(.is-empty):not(.has-event):hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_today_style',
			array(
				'label'     => esc_html__( 'Today Style', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'today_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day.is-today' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'today_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day.is-today' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_events',
			array(
				'label' => esc_html__( 'Events Highlight & List', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_event_marker',
			array(
				'label' => esc_html__( 'Event Day Marker (Calendar)', 'lc-addons-kit-for-elementor' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->start_controls_tabs( 'tabs_event_marker' );

		$this->start_controls_tab(
			'tab_event_marker_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'event_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day.has-event' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'event_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day.has-event' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_event_marker_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'event_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day.has-event:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'event_text_color_hover',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-day.has-event:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_event_list',
			array(
				'label'     => esc_html__( 'Event List (Below Calendar)', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'event_list_title_color',
			array(
				'label'     => esc_html__( 'Event Title Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-list a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'event_list_title_hover_color',
			array(
				'label'     => esc_html__( 'Event Title Hover Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-list a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'event_list_title_typography',
				'selector' => '{{WRAPPER}} .lcake-event-calendar-list a',
			)
		);

		$this->add_control(
			'event_list_date_color',
			array(
				'label'     => esc_html__( 'Event Date Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#9ca3af',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-list span' => 'color: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'event_list_date_typography',
				'selector' => '{{WRAPPER}} .lcake-event-calendar-list span',
			)
		);

		$this->add_control(
			'event_list_desc_color',
			array(
				'label'     => esc_html__( 'Event Description Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4b5563',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-desc' => 'color: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'event_list_desc_typography',
				'selector' => '{{WRAPPER}} .lcake-event-calendar-desc',
			)
		);

		$this->add_control(
			'event_list_divider_color',
			array(
				'label'     => esc_html__( 'List Border/Divider Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f3f4f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-event-calendar-list' => 'border-color: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$events   = array();

		foreach ( $settings['events'] ?? array() as $event ) {
			if ( empty( $event['event_date'] ) ) {
				continue;
			}
			$events[] = array(
				'date'        => $event['event_date'],
				'title'       => $event['event_title'],
				'description' => $event['event_description'] ?? '',
				'link'        => $event['event_link']['url'] ?? '',
			);
		}
		?>
		<div class="lcake-event-calendar" data-events="<?php echo esc_attr( wp_json_encode( $events ) ); ?>">
			<div class="lcake-event-calendar-header">
				<button type="button" class="lcake-event-calendar-nav lcake-event-calendar-prev" aria-label="<?php echo esc_attr__( 'Previous Month', 'lc-addons-kit-for-elementor' ); ?>">&#10094;</button>
				<span class="lcake-event-calendar-title"></span>
				<button type="button" class="lcake-event-calendar-nav lcake-event-calendar-next" aria-label="<?php echo esc_attr__( 'Next Month', 'lc-addons-kit-for-elementor' ); ?>">&#10095;</button>
			</div>
			<div class="lcake-event-calendar-weekdays"></div>
			<div class="lcake-event-calendar-grid"></div>
			<ul class="lcake-event-calendar-list"></ul>
		</div>
		<?php
	}
}
