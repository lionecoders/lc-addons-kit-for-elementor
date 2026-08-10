<?php

/**
 * LCAKE Kit Button Widget
 *
 * @package LCAKE_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LCAKE_Kit_Button extends \Elementor\Widget_Base {


	public function get_name() {
		return 'lcake-kit-button';
	}

	public function get_title() {
		return esc_html__( 'Button', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_keywords() {
		return array( 'button', 'link', 'cta' );
	}

	public function register_controls() {
		// === Content Section ===
		$this->start_controls_section(
			'lcake_button_content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
			)
		);

		// Label (with dynamic support)
		$this->add_control(
			'lcake_button_text',
			array(
				'label'       => esc_html__( 'Label', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Learn more', 'lc-addons-kit-for-elementor' ),
				'placeholder' => esc_html__( 'Learn more', 'lc-addons-kit-for-elementor' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		// URL (with dynamic support)
		$this->add_control(
			'lcake_button_link',
			array(
				'label'       => esc_html__( 'URL', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_url( 'https://your-link.com' ),
				'dynamic'     => array( 'active' => true ),
				'default'     => array( 'url' => '#' ),
			)
		);

		// Section Heading
		$this->add_control(
			'lcake_button_section_heading',
			array(
				'label'     => esc_html__( 'Settings', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		// Icon Toggle
		$this->add_control(
			'lcake_button_icon_switch',
			array(
				'label'     => esc_html__( 'Add Icon?', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off' => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
			)
		);

		// Icon Picker
		$this->add_control(
			'lcake_button_icon',
			array(
				'label'       => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => '',
					'library' => 'solid',
				),
				'condition'   => array(
					'lcake_button_icon_switch' => 'yes',
				),
			)
		);

		// Icon Position
		$this->add_control(
			'lcake_button_icon_position',
			array(
				'label'     => esc_html__( 'Icon Position', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => esc_html__( 'Before', 'lc-addons-kit-for-elementor' ),
					'right' => esc_html__( 'After', 'lc-addons-kit-for-elementor' ),
				),
				'condition' => array(
					'lcake_button_icon_switch' => 'yes',
				),
			)
		);

		// Responsive Alignment
		$this->add_responsive_control(
			'lcake_button_align',
			array(
				'label'     => esc_html__( 'Alignment', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} .lcake-kit-button-wrapper' => 'justify-content: {{VALUE}};',
				),
			)
		);

		// Custom Class
		$this->add_control(
			'lcake_button_class',
			array(
				'label'       => esc_html__( 'Class', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'placeholder' => esc_html__( 'Custom class name', 'lc-addons-kit-for-elementor' ),
			)
		);

		// Custom ID
		$this->add_control(
			'lcake_button_id',
			array(
				'label'       => esc_html__( 'ID', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'placeholder' => esc_html__( 'Custom ID', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lcake_button_badge',
			array(
				'label'       => esc_html__( 'Badge', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Optional badge text', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lcake_btn_style_section',
			array(
				'label' => esc_html__( 'Button', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'lcake_btn_width',
			array(
				'label'     => esc_html__( 'Width (%)', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .lcake-kit-button' => 'width: {{SIZE}}%;',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_btn_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-kit-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lcake_btn_typography',
				'label'    => esc_html__( 'Typography', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-kit-button',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'lcake_btn_text_shadow',
				'selector' => '{{WRAPPER}} .lcake-kit-button',
			)
		);

		$this->add_control(
			'lcake_btn_transition_duration',
			array(
				'label'      => esc_html__( 'Transition Duration (s)', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 's' ),
				'range'      => array(
					's' => array(
						'min'  => 0,
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'default'    => array(
					'unit' => 's',
					'size' => 0.3,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-kit-button' => 'transition: all {{SIZE}}{{UNIT}} ease;',
				),
			)
		);

		// Start Tabs for Normal & Hover States
		$this->start_controls_tabs( 'lcake_btn_tabs_style' );

		// Normal Tab
		$this->start_controls_tab(
			'lcake_btn_tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lcake_btn_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-kit-button' => 'color: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_btn_bg_color',
				'selector' => '{{WRAPPER}} .lcake-kit-button',
			)
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'lcake_btn_tab_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lcake_btn_hover_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-kit-button:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'lcake_btn_bg_hover_color',
				'selector' => '{{WRAPPER}} .lcake-kit-button:hover',
			)
		);

		$this->add_control(
			'lcake_btn_hover_animation',
			array(
				'label' => esc_html__( 'Hover Animation', 'lc-addons-kit-for-elementor' ),
				'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
			)
		);

		$this->end_controls_tab(); // End Hover Tab
		$this->end_controls_tabs(); // End Tabs

		$this->end_controls_section();

		// Border Style Section
		$this->start_controls_section(
			'lcake_btn_border_style_tabs',
			array(
				'label' => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'lcake_btn_border_style',
			array(
				'label'     => esc_html__( 'Border Type', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'none'   => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
					'solid'  => esc_html__( 'Solid', 'lc-addons-kit-for-elementor' ),
					'double' => esc_html__( 'Double', 'lc-addons-kit-for-elementor' ),
					'dotted' => esc_html__( 'Dotted', 'lc-addons-kit-for-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'lc-addons-kit-for-elementor' ),
					'groove' => esc_html__( 'Groove', 'lc-addons-kit-for-elementor' ),
				),
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} .lcake-kit-button' => 'border-style: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_btn_border_width',
			array(
				'label'     => esc_html__( 'Border Width', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'condition' => array(
					'lcake_btn_border_style!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-kit-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'lcake_btn_border_tabs' );

		$this->start_controls_tab(
			'lcake_btn_border_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lcake_btn_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-kit-button' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'lcake_btn_border_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lcake_btn_hover_border_color',
			array(
				'label'     => esc_html__( 'Hover Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-kit-button:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'lcake_btn_border_hover_text_color',
			array(
				'label'     => esc_html__( 'Hover Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-kit-button:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Border Radius Section
		$this->add_responsive_control(
			'lcake_btn_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-kit-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Shadow Style Section
		$this->start_controls_section(
			'lcake_btn_shadow_style_tabs',
			array(
				'label' => esc_html__( 'Shadow', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_btn_box_shadow_group',
				'selector' => '{{WRAPPER}} .lcake-kit-button',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'lcake_btn_hover_box_shadow_group',
				'label'    => esc_html__( 'Hover Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-kit-button:hover',
			)
		);

		$this->end_controls_section();

		// icon Style Section
		$this->start_controls_section(
			'lcake_btn_icon_style',
			array(
				'label'     => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'lcake_button_icon_switch' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_btn_icon_font_size',
			array(
				'label'      => esc_html__( 'Font Size', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => 1,
						'max' => 100,
					),
					'em'  => array(
						'min' => 0.1,
						'max' => 10,
					),
					'rem' => array(
						'min' => 0.1,
						'max' => 10,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 14,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-kit-button .lcake-kit-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-kit-button .lcake-kit-button-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_btn_icon_margin_right',
			array(
				'label'      => esc_html__( 'Add space after icon', 'lc-addons-kit-for-elementor' ),
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
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-kit-button-icon:first-child' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .lcake-kit-button-icon:first-child' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				),
				'condition'  => array(
					'lcake_button_icon_position' => 'left',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_btn_icon_margin_left',
			array(
				'label'      => esc_html__( 'Add space before icon', 'lc-addons-kit-for-elementor' ),
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
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-kit-button-icon:last-child' => 'margin-left: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .lcake-kit-button-icon:last-child' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				),
				'condition'  => array(
					'lcake_button_icon_position' => 'right',
				),
			)
		);

		$this->add_responsive_control(
			'lcake_btn_icon_vertical_align',
			array(
				'label'      => esc_html__( 'Move Icon Vertically', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min' => -20,
						'max' => 20,
					),
					'em'  => array(
						'min' => -5,
						'max' => 5,
					),
					'rem' => array(
						'min' => -5,
						'max' => 5,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-kit-button-icon' => 'transform: translateY({{SIZE}}{{UNIT}});',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$custom_class = ! empty( $settings['lcake_button_class'] ) ? sanitize_html_class( $settings['lcake_button_class'] ) : '';
		$custom_id    = ! empty( $settings['lcake_button_id'] ) ? sanitize_text_field( $settings['lcake_button_id'] ) : '';
		$button_text  = ! empty( $settings['lcake_button_text'] ) ? esc_html( $settings['lcake_button_text'] ) : '';
		$position     = $settings['lcake_button_icon_position'] ?? 'left';
		$has_url      = ! empty( $settings['lcake_button_link']['url'] );

		$hover_animation = ! empty( $settings['lcake_btn_hover_animation'] ) ? 'elementor-animation-' . $settings['lcake_btn_hover_animation'] : '';

		$this->add_render_attribute(
			'button',
			array(
				'class' => array_filter(
					array(
						'lcake-kit-button',
						'elementor-button',
						$hover_animation,
						$custom_class,
					)
				),
			)
		);

		if ( $custom_id ) {
			$this->add_render_attribute( 'button', 'id', $custom_id );
		}

		if ( $button_text ) {
			$this->add_render_attribute( 'button', 'aria-label', $button_text );
		}

		if ( $has_url ) {
			$this->add_render_attribute( 'button', 'href', esc_url( $settings['lcake_button_link']['url'] ) );

			if ( ! empty( $settings['lcake_button_link']['is_external'] ) ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
				// add noopener noreferrer by default for external
				$existing_rel = $this->get_render_attribute_string( 'button' ); // not used for printing, just to check
				$rel_values   = array();
				// gather rel values manually (we'll set below)
				$rel_values[] = 'noopener';
				$rel_values[] = 'noreferrer';
			}

			if ( ! empty( $settings['lcake_button_link']['nofollow'] ) ) {
				$rel_values[] = 'nofollow';
			}

			if ( ! empty( $rel_values ) ) {
				// ensure unique values
				$rel_values = array_unique( $rel_values );
				$this->add_render_attribute( 'button', 'rel', implode( ' ', $rel_values ) );
			}
		}

		$icon_html = '';
		if ( ! empty( $settings['lcake_button_icon_switch'] ) && $settings['lcake_button_icon_switch'] === 'yes' && ! empty( $settings['lcake_button_icon']['value'] ) ) {
			\Elementor\Icons_Manager::enqueue_shim();
			ob_start();
			\Elementor\Icons_Manager::render_icon(
				$settings['lcake_button_icon'],
				array(
					'aria-hidden' => 'true',
					'class'       => 'lcake-kit-button-icon elementor-button-icon',
				),
				'inline'
			);
			$icon_html = ob_get_clean();

			if ( stripos( $icon_html, '<svg' ) !== false ) {
				$icon_html = preg_replace( '/\s(?:width|height)=["\'][^"\']*["\']/', '', $icon_html );
				if ( preg_match( '/<svg\b[^>]*\bstyle=["\']([^"\']*)["\']/i', $icon_html, $m ) ) {
					$new_style  = preg_replace( array( '/width:\s*[^;]+;?/i', '/height:\s*[^;]+;?/i' ), array( 'width:1em;', 'height:1em;' ), $m[1] );
					$new_style .= ( substr( trim( $new_style ), -1 ) !== ';' ? ';' : '' ) . 'vertical-align:middle;';
					$icon_html  = preg_replace( '/(<svg\b[^>]*\bstyle=["\'])([^"\']*)(["\'])/i', '$1' . $new_style . '$3', $icon_html, 1 );
				} else {
					$icon_html = preg_replace( '/<svg\b([^>]*)>/i', '<svg$1 style="width:1em;height:1em;vertical-align:middle;">', $icon_html, 1 );
				}
			}
		}

		$badge_html = ! empty( $settings['lcake_button_badge'] )
			? sprintf( '<span class="lcake-button-badge">%s</span>', esc_html( $settings['lcake_button_badge'] ) )
			: '';

		// Button inner content
		$content_parts = array();
		if ( $icon_html && $position === 'left' ) {
			$content_parts[] = $icon_html;
		}
		if ( $button_text ) {
			$content_parts[] = $button_text;
		}
		if ( $badge_html ) {
			$content_parts[] = $badge_html;
		}
		if ( $icon_html && $position === 'right' ) {
			$content_parts[] = $icon_html;
		}
		$button_inner = implode( '', $content_parts );

		?>
		<div class="lcake-kit-wid-con">
			<div class="lcake-kit-button-wrapper">
				<?php if ( $has_url ) : ?>
					<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
						<?php echo ( $button_inner ); ?>
					</a>
				<?php else : ?>
					<button type="button" <?php echo $this->get_render_attribute_string( 'button' ); ?>>
						<?php echo ( $button_inner ); ?>
					</button>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
