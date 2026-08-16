<?php
/**
 * SVG Draw Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SVG Draw Widget.
 *
 * Elementor widget that displays a SVG Draw.
 */
class LCAKE_Kit_Svg_Draw extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-svg-draw';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'SVG Draw', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-svg lcake-mveous-badge';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-svg-draw-css' );
	}

	public function get_script_depends() {
		return array( 'lcake-kit-svg-draw-js' );
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
			'svg_source',
			array(
				'label'       => esc_html__( 'SVG Image', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'media_types' => array( 'svg' ),
			)
		);

		$this->add_control(
			'draw_duration',
			array(
				'label'   => esc_html__( 'Draw Duration (ms)', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 2000,
			)
		);

		$this->add_control(
			'trigger',
			array(
				'label'   => esc_html__( 'Trigger', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'viewport',
				'options' => array(
					'viewport' => esc_html__( 'On Scroll Into View', 'lc-addons-kit-for-elementor' ),
					'load'     => esc_html__( 'On Page Load', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'stroke_color',
			array(
				'label'     => esc_html__( 'Stroke Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-svg-draw svg path, {{WRAPPER}} .lcake-svg-draw svg polyline, {{WRAPPER}} .lcake-svg-draw svg circle, {{WRAPPER}} .lcake-svg-draw svg line' => 'stroke: {{VALUE}}; fill: none;' ),
			)
		);

		$this->add_control(
			'stroke_width',
			array(
				'label'     => esc_html__( 'Stroke Width', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'default'   => array(
					'size' => 3,
					'unit' => 'px',
				),
				'selectors' => array( '{{WRAPPER}} .lcake-svg-draw svg path, {{WRAPPER}} .lcake-svg-draw svg polyline, {{WRAPPER}} .lcake-svg-draw svg circle, {{WRAPPER}} .lcake-svg-draw svg line' => 'stroke-width: {{SIZE}};' ),
			)
		);

		$this->add_responsive_control(
			'width',
			array(
				'label'     => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 50,
						'max' => 800,
					),
				),
				'default'   => array(
					'size' => 200,
					'unit' => 'px',
				),
				'selectors' => array( '{{WRAPPER}} .lcake-svg-draw svg' => 'width: {{SIZE}}{{UNIT}};' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$svg_id   = ! empty( $settings['svg_source']['id'] ) ? (int) $settings['svg_source']['id'] : 0;

		if ( ! $svg_id ) {
			return;
		}

		$file_path = get_attached_file( $svg_id );
		if ( ! $file_path || ! file_exists( $file_path ) || 'svg' !== strtolower( pathinfo( $file_path, PATHINFO_EXTENSION ) ) ) {
			return;
		}

		$svg_content = file_get_contents( $file_path );
		?>
		<div class="lcake-svg-draw" data-trigger="<?php echo esc_attr( $settings['trigger'] ); ?>" data-duration="<?php echo esc_attr( $settings['draw_duration'] ); ?>">
			<?php echo LCAKE_Kit_Utils::kses( $svg_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- output is sanitized via wp_kses() inside LCAKE_Kit_Utils::kses(). ?>
		</div>
		<?php
	}
}
