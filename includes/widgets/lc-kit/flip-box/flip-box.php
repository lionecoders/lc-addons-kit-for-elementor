<?php
/**
 * Flip Box Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Flip Box Widget.
 *
 * Elementor widget that displays a Flip Box.
 */
class LCAKE_Kit_Flip_Box extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-flip-box';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Flip Box', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-flip-box';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-flip-box-css' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_front',
			array(
				'label' => esc_html__( 'Front Side', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'front_icon',
			array(
				'label'   => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'front_title',
			array(
				'label'       => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Front Title', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'front_description',
			array(
				'label'   => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Hover over this box to reveal more information.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'front_button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->add_control(
			'front_button_link',
			array(
				'label'       => esc_html__( 'Button Link', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lc-addons-kit-for-elementor' ),
				'default'     => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_back',
			array(
				'label' => esc_html__( 'Back Side', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'back_icon',
			array(
				'label'   => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => '',
					'library' => '',
				),
			)
		);

		$this->add_control(
			'back_title',
			array(
				'label'       => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Back Title', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'back_description',
			array(
				'label'   => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'back_button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Learn More', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'back_button_link',
			array(
				'label'       => esc_html__( 'Button Link', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lc-addons-kit-for-elementor' ),
				'default'     => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'flip_direction',
			array(
				'label'        => esc_html__( 'Flip Direction', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => 'left',
				'options'      => array(
					'left' => esc_html__( 'Left to Right', 'lc-addons-kit-for-elementor' ),
					'top'  => esc_html__( 'Top to Bottom', 'lc-addons-kit-for-elementor' ),
				),
				'prefix_class' => 'lcake-flip-box--',
			)
		);

		$this->add_responsive_control(
			'box_height',
			array(
				'label'      => esc_html__( 'Height', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 150,
						'max' => 600,
					),
				),
				'default'    => array(
					'size' => 280,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-flip-box' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_box',
			array(
				'label' => esc_html__( 'Box Style', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'front_background',
			array(
				'label'     => esc_html__( 'Front Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-front' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'back_background',
			array(
				'label'     => esc_html__( 'Back Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-back' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-flip-box-front, {{WRAPPER}} .lcake-flip-box-back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .lcake-flip-box-front, {{WRAPPER}} .lcake-flip-box-back',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_front_content',
			array(
				'label' => esc_html__( 'Front Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'front_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-flip-box-front i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-flip-box-front svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'front_icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 150,
					),
				),
				'default'   => array(
					'size' => 50,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-flip-box-front i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-flip-box-front svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'front_title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-front .lcake-flip-box-title' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'front_description_color',
			array(
				'label'     => esc_html__( 'Description Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6b7280',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-front .lcake-flip-box-description' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'front_button_color',
			array(
				'label'     => esc_html__( 'Button Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-front .lcake-flip-box-button' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'front_button_background',
			array(
				'label'     => esc_html__( 'Button Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-front .lcake-flip-box-button' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_back_content',
			array(
				'label' => esc_html__( 'Back Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'back_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-flip-box-back i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-flip-box-back svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'back_icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 150,
					),
				),
				'default'   => array(
					'size' => 50,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-flip-box-back i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-flip-box-back svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'back_title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-back .lcake-flip-box-title' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'back_description_color',
			array(
				'label'     => esc_html__( 'Description Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.85)',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-back .lcake-flip-box-description' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'back_button_color',
			array(
				'label'     => esc_html__( 'Button Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-back .lcake-flip-box-button' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'back_button_background',
			array(
				'label'     => esc_html__( 'Button Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-flip-box-back .lcake-flip-box-button' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$front_link = $settings['front_button_link'] ?? array();
		$back_link  = $settings['back_button_link'] ?? array();

		if ( ! empty( $front_link['url'] ) ) {
			$this->add_link_attributes( 'front_button_link', $front_link );
		}
		$this->add_render_attribute( 'front_button_link', 'class', 'lcake-flip-box-button' );

		if ( ! empty( $back_link['url'] ) ) {
			$this->add_link_attributes( 'back_button_link', $back_link );
		}
		$this->add_render_attribute( 'back_button_link', 'class', 'lcake-flip-box-button' );
		?>
		<div class="lcake-flip-box">
			<div class="lcake-flip-box-inner">
				<div class="lcake-flip-box-front">
					<?php if ( ! empty( $settings['front_icon']['value'] ) ) : ?>
						<div class="lcake-flip-box-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['front_icon'], array( 'aria-hidden' => 'true' ) ); ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['front_title'] ) ) : ?>
						<h3 class="lcake-flip-box-title"><?php echo wp_kses_post( $settings['front_title'] ); ?></h3>
					<?php endif; ?>
					<?php if ( ! empty( $settings['front_description'] ) ) : ?>
						<div class="lcake-flip-box-description"><?php echo wp_kses_post( $settings['front_description'] ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['front_button_text'] ) ) : ?>
						<a <?php echo $this->get_render_attribute_string( 'front_button_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor pre-sanitizes render attribute strings. ?>>
							<?php echo esc_html( $settings['front_button_text'] ); ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="lcake-flip-box-back">
					<?php if ( ! empty( $settings['back_icon']['value'] ) ) : ?>
						<div class="lcake-flip-box-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['back_icon'], array( 'aria-hidden' => 'true' ) ); ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['back_title'] ) ) : ?>
						<h3 class="lcake-flip-box-title"><?php echo wp_kses_post( $settings['back_title'] ); ?></h3>
					<?php endif; ?>
					<?php if ( ! empty( $settings['back_description'] ) ) : ?>
						<div class="lcake-flip-box-description"><?php echo wp_kses_post( $settings['back_description'] ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['back_button_text'] ) ) : ?>
						<a <?php echo $this->get_render_attribute_string( 'back_button_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor pre-sanitizes render attribute strings. ?>>
							<?php echo esc_html( $settings['back_button_text'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}
