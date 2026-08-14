<?php
/**
 * Lottie Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Lottie Widget.
 *
 * Elementor widget that displays a Lottie.
 */
class LCAKE_Kit_Lottie extends \Elementor\Widget_Base {


	public function get_name() {
		return 'lcake-kit-lottie';
	}

	public function get_title() {
		return esc_html__( 'Lottie', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-animation';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_keywords() {
		return array( 'lottie', 'animation', 'json', 'svg', 'motion' );
	}

	public function get_style_depends() {
		return array( 'lcake-kit-lottie-css' );
	}

	public function get_script_depends() {
		return array( 'lottie', 'lcake-kit-lottie-js' ); // request Elementor's lottie + our custom init
	}

	protected function register_controls() {
		$this->add_content_controls();
		$this->add_style_controls();
	}

	protected function add_content_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'lottie_url',
			array(
				'label'       => esc_html__( 'External URL', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://assets.lottiefiles.com/...', 'lc-addons-kit-for-elementor' ),
				'description' => esc_html__( 'Enter the Absolute URL to the JSON file.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lottie_file',
			array(
				'label'       => esc_html__( 'Media Library', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'media_type'  => 'application/json',
				'description' => esc_html__( 'Upload a local Lottie JSON file.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'        => esc_html__( 'Loop', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Speed', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min'  => 0.1,
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'default' => array(
					'size' => 1,
				),
			)
		);

		$this->add_control(
			'direction',
			array(
				'label'   => esc_html__( 'Direction', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1'  => esc_html__( 'Forward', 'lc-addons-kit-for-elementor' ),
					'-1' => esc_html__( 'Reverse', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'show_controls',
			array(
				'label'        => esc_html__( 'Show Controls', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->end_controls_section();
	}

	protected function add_style_controls() {
		$this->start_controls_section(
			'section_style_lottie',
			array(
				'label' => esc_html__( 'Lottie Box', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'align',
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
					'{{WRAPPER}} .lcake-lottie-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'width',
			array(
				'label'      => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'vw' ),
				'range'      => array(
					'px' => array(
						'min'  => 50,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 10,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 300,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-lottie-container' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-lottie-container' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'lottie_border',
				'selector' => '{{WRAPPER}} .lcake-lottie-container',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-lottie-container',
			)
		);

		$this->add_control(
			'border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-lottie-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Control Panel Style
		$this->start_controls_section(
			'section_style_controls',
			array(
				'label'     => esc_html__( 'Player Controls', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_controls' => 'yes',
				),
			)
		);

		$this->add_control(
			'controls_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(17, 24, 39, 0.8)',
				'selectors' => array(
					'{{WRAPPER}} .lcake-lottie-controls' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'controls_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-lottie-controls button svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'controls_hover_color',
			array(
				'label'     => esc_html__( 'Icon Hover Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-lottie-controls button:hover svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$lottie_data = '';

		if ( ! empty( $settings['lottie_url']['url'] ) ) {
			$lottie_data = $settings['lottie_url']['url'];
		} elseif ( ! empty( $settings['lottie_file']['url'] ) ) {
			$lottie_data = $settings['lottie_file']['url'];
		}

		if ( empty( $lottie_data ) ) {
			// Render placeholder or empty
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'lcake-lottie-wrapper' );

		$config = array(
			'container_id'   => 'lcake-lottie-' . $this->get_id(),
			'path'           => esc_url( $lottie_data ),
			'autoplay'       => $settings['autoplay'] === 'yes',
			'loop'           => $settings['loop'] === 'yes',
			'speed'          => $settings['speed']['size'] ?? 1,
			'direction'      => intval( $settings['direction'] ?? 1 ),
			'pause_on_hover' => $settings['pause_on_hover'] === 'yes',
		);

		// Output lottie container with config dataset
		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor pre-sanitizes render attribute strings.

		echo '<div class="lcake-lottie-container" id="' . esc_attr( $config['container_id'] ) . '" data-lottie-config="' . esc_attr( json_encode( $config ) ) . '"></div>';

		// Custom Player Controls
		if ( $settings['show_controls'] === 'yes' ) {
			echo '<div class="lcake-lottie-controls" data-target="' . esc_attr( $config['container_id'] ) . '">';
			echo '<button class="lcake-lottie-play" aria-label="Play"><svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></button>';
			echo '<button class="lcake-lottie-pause" aria-label="Pause"><svg viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg></button>';
			echo '<button class="lcake-lottie-stop" aria-label="Stop"><svg viewBox="0 0 24 24"><path d="M6 6h12v12H6z"/></svg></button>';
			echo '<button class="lcake-lottie-restart" aria-label="Restart"><svg viewBox="0 0 24 24"><path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/></svg></button>';
			echo '</div>';
		}

		echo '</div>';
	}
}
