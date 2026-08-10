<?php
/**
 * Sticky Video Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LCAKE_Kit_Sticky_Video extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-sticky-video';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Sticky Video', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-youtube';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-sticky-video-css' );
	}

	public function get_script_depends() {
		return array( 'lcake-kit-sticky-video-js' );
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
			'video_url',
			array(
				'label'         => esc_html__( 'Video URL', 'lc-addons-kit-for-elementor' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://youtube.com/watch?v=...', 'lc-addons-kit-for-elementor' ),
				'default'       => array( 'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' ),
				'show_external' => false,
			)
		);

		$this->add_control(
			'stick_position',
			array(
				'label'        => esc_html__( 'Docked Position', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => 'bottom-right',
				'options'      => array(
					'bottom-right' => esc_html__( 'Bottom Right', 'lc-addons-kit-for-elementor' ),
					'bottom-left'  => esc_html__( 'Bottom Left', 'lc-addons-kit-for-elementor' ),
				),
				'prefix_class' => 'lcake-sticky-video--',
			)
		);

		$this->add_control(
			'show_close',
			array(
				'label'   => esc_html__( 'Show Close Button', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();

		// --- Video Container ---
		$this->start_controls_section(
			'section_style_container',
			array(
				'label' => esc_html__( 'Video Container', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'video_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '16',
					'bottom'   => '16',
					'left'     => '16',
					'right'    => '16',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-sticky-video-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'video_border',
				'label'    => esc_html__( 'Border', 'lc-addons-kit-for-elementor' ),
				'selector' => '{{WRAPPER}} .lcake-sticky-video-inner',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'video_shadow',
				'selector' => '{{WRAPPER}} .lcake-sticky-video-inner',
			)
		);

		$this->end_controls_section();

		// --- Docked Mode ---
		$this->start_controls_section(
			'section_style_docked',
			array(
				'label' => esc_html__( 'Docked Mode', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'docked_width',
			array(
				'label'     => esc_html__( 'Docked Width', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 200,
						'max' => 600,
					),
				),
				'default'   => array(
					'size' => 320,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-sticky-video.is-docked' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'docked_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-sticky-video.is-docked .lcake-sticky-video-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'docked_shadow',
				'selector' => '{{WRAPPER}} .lcake-sticky-video.is-docked .lcake-sticky-video-inner',
			)
		);

		$this->add_responsive_control(
			'docked_offset_y',
			array(
				'label'     => esc_html__( 'Bottom Spacing (px)', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 150,
					),
				),
				'default'   => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-sticky-video.is-docked' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'docked_offset_x',
			array(
				'label'     => esc_html__( 'Side Spacing (px)', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 150,
					),
				),
				'default'   => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}}.lcake-sticky-video--bottom-right .lcake-sticky-video.is-docked' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
					'{{WRAPPER}}.lcake-sticky-video--bottom-left .lcake-sticky-video.is-docked' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->end_controls_section();

		// --- Close Button ---
		$this->start_controls_section(
			'section_style_close',
			array(
				'label'     => esc_html__( 'Close Button', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_close' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'close_button_states' );

		$this->start_controls_tab(
			'close_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'close_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.6)',
				'selectors' => array(
					'{{WRAPPER}} .lcake-sticky-video-close' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'close_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-sticky-video-close' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'close_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'close_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-sticky-video-close:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'close_hover_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-sticky-video-close:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'close_size',
			array(
				'label'     => esc_html__( 'Button Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 20,
						'max' => 60,
					),
				),
				'default'   => array(
					'size' => 26,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-sticky-video-close' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: calc({{SIZE}}{{UNIT}} * 0.7);',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'close_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '50',
					'bottom'   => '50',
					'left'     => '50',
					'right'    => '50',
					'unit'     => '%',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-sticky-video-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$url      = $settings['video_url']['url'] ?? '';

		if ( empty( $url ) ) {
			return;
		}

		$embed_html = wp_oembed_get( $url );
		if ( ! $embed_html ) {
			$embed_html = sprintf( '<iframe src="%s" frameborder="0" allowfullscreen></iframe>', esc_url( $url ) );
		}
		?>
		<div class="lcake-sticky-video" data-show-close="<?php echo esc_attr( $settings['show_close'] ); ?>">
			<div class="lcake-sticky-video-inner">
				<?php echo LCAKE_Kit_Utils::kses( $embed_html ); ?>
				<?php if ( 'yes' === $settings['show_close'] ) : ?>
					<button type="button" class="lcake-sticky-video-close" aria-label="<?php echo esc_attr__( 'Close', 'lc-addons-kit-for-elementor' ); ?>">&times;</button>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
