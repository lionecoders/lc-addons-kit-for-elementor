<?php
/**
 * Heading Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Heading Widget.
 *
 * Elementor widget that displays a Heading.
 */
class LCAKE_Kit_Heading extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-heading';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-heading-css' );
	}

	public function get_title() {
		return esc_html__( 'Heading', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-t-letter lcake-mveous-badge';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_keywords() {
		return array( 'heading', 'text', 'title', 'modern' );
	}

	protected function register_controls() {
		// CONTENT TAB
		$this->start_controls_section(
			'lcake_section_content',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'lcake_heading_text',
			array(
				'label'       => esc_html__( 'Heading Text', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Build Beautiful Experiences', 'lc-addons-kit-for-elementor' ),
				'placeholder' => esc_html__( 'Enter your heading', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'lcake_heading_tag',
			array(
				'label'   => esc_html__( 'HTML Tag', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h2',
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
			)
		);

		$this->add_responsive_control(
			'lcake_heading_alignment',
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
					'{{WRAPPER}} .lcake-heading' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// STYLE TAB
		$this->start_controls_section(
			'lcake_section_style',
			array(
				'label' => esc_html__( 'Heading Style', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'lcake_heading_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .lcake-heading .lcake-heading-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'lcake_heading_gradient_effect',
			array(
				'label'        => esc_html__( 'Enable Gradient Text', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'lcake_heading_gradient_color_left',
			array(
				'label'     => esc_html__( 'Gradient Left Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4f46e5',
				'condition' => array(
					'lcake_heading_gradient_effect' => 'yes',
				),
			)
		);

		$this->add_control(
			'lcake_heading_gradient_color_right',
			array(
				'label'     => esc_html__( 'Gradient Right Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ec4899',
				'condition' => array(
					'lcake_heading_gradient_effect' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-heading .lcake-heading-title.lcake-heading-gradient' => 'background: linear-gradient(to right, {{lcake_heading_gradient_color_left.VALUE}}, {{VALUE}}); -webkit-background-clip: text; -webkit-text-fill-color: transparent;',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'lcake_heading_typography',
				'selector' => '{{WRAPPER}} .lcake-heading .lcake-heading-title',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'lcake_heading_text_shadow',
				'selector' => '{{WRAPPER}} .lcake-heading .lcake-heading-title',
			)
		);

		$this->add_responsive_control(
			'lcake_heading_margin',
			array(
				'label'      => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$heading_text = $settings['lcake_heading_text'];
		$heading_tag  = ! empty( $settings['lcake_heading_tag'] ) ? $settings['lcake_heading_tag'] : 'h2';

		if ( empty( $heading_text ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'lcake-heading' );

		$title_classes = array( 'lcake-heading-title' );
		if ( $settings['lcake_heading_gradient_effect'] === 'yes' ) {
			$title_classes[] = 'lcake-heading-gradient';
		}
		$this->add_render_attribute( 'title', 'class', $title_classes );

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor pre-sanitizes render attribute strings.
			echo '<' . tag_escape( $heading_tag ) . ' ' . $this->get_render_attribute_string( 'title' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor pre-sanitizes render attribute strings.
				echo wp_kses_post( $heading_text );
			echo '</' . tag_escape( $heading_tag ) . '>';
		echo '</div>';
	}

	protected function content_template() {
		?>
		<#
		var heading_tag = settings.lcake_heading_tag ? settings.lcake_heading_tag : 'h2';
		var title_class = 'lcake-heading-title';
		if (settings.lcake_heading_gradient_effect === 'yes') {
			title_class += ' lcake-heading-gradient';
		}
		#>
		<div class="lcake-heading">
			<{{{ heading_tag }}} class="{{ title_class }}">
				{{{ settings.lcake_heading_text }}}
			</{{{ heading_tag }}}>
		</div>
		<?php
	}
}
