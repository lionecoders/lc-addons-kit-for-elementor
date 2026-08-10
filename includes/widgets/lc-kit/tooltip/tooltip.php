<?php
/**
 * Tooltip Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tooltip Widget.
 *
 * Elementor widget that displays a Tooltip.
 */
class LCAKE_Kit_Tooltip extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-tooltip';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Tooltip', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-help-o';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-tooltip-css' );
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
			'trigger_type',
			array(
				'label'   => esc_html__( 'Trigger Type', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'text',
				'options' => array(
					'text' => esc_html__( 'Text', 'lc-addons-kit-for-elementor' ),
					'icon' => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'trigger_text',
			array(
				'label'     => esc_html__( 'Trigger Text', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Hover over me', 'lc-addons-kit-for-elementor' ),
				'condition' => array( 'trigger_type' => 'text' ),
			)
		);

		$this->add_control(
			'trigger_icon',
			array(
				'label'     => esc_html__( 'Trigger Icon', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-info-circle',
					'library' => 'fa-solid',
				),
				'condition' => array( 'trigger_type' => 'icon' ),
			)
		);

		$this->add_control(
			'tooltip_content',
			array(
				'label'   => esc_html__( 'Tooltip Content', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is the tooltip content.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'position',
			array(
				'label'        => esc_html__( 'Position', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => 'top',
				'options'      => array(
					'top'    => esc_html__( 'Top', 'lc-addons-kit-for-elementor' ),
					'bottom' => esc_html__( 'Bottom', 'lc-addons-kit-for-elementor' ),
					'left'   => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
					'right'  => esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
				),
				'prefix_class' => 'lcake-tooltip--pos-',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_trigger',
			array(
				'label' => esc_html__( 'Trigger', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'trigger_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-tooltip-trigger' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .lcake-tooltip-trigger svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'trigger_typography',
				'selector' => '{{WRAPPER}} .lcake-tooltip-trigger',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tooltip',
			array(
				'label' => esc_html__( 'Tooltip Box', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tooltip_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .lcake-tooltip-content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .lcake-tooltip-content::before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tooltip_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-tooltip-content' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'tooltip_width',
			array(
				'label'     => esc_html__( 'Width', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 100,
						'max' => 400,
					),
				),
				'default'   => array(
					'size' => 200,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-tooltip-content' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<span class="lcake-tooltip">
			<span class="lcake-tooltip-trigger" tabindex="0">
				<?php if ( 'icon' === $settings['trigger_type'] ) : ?>
					<?php \Elementor\Icons_Manager::render_icon( $settings['trigger_icon'], array( 'aria-hidden' => 'true' ) ); ?>
				<?php else : ?>
					<?php echo esc_html( $settings['trigger_text'] ); ?>
				<?php endif; ?>
			</span>
			<span class="lcake-tooltip-content"><?php echo wp_kses_post( $settings['tooltip_content'] ); ?></span>
		</span>
		<?php
	}
}
