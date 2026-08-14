<?php
/**
 * Call To Action Box Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CTA Box Widget.
 *
 * Elementor widget that displays a CTA Box.
 */
class LCAKE_Kit_Cta_Box extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-cta-box';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'CTA Box', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-cta-box-css' );
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
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'row',
				'options' => array(
					'row'    => esc_html__( 'Text Left, Button Right', 'lc-addons-kit-for-elementor' ),
					'column' => esc_html__( 'Stacked / Centered', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ready to get started?', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Join thousands of happy customers using our product today.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Get Started', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'button_link',
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

		$this->add_control(
			'button_icon',
			array(
				'label'   => esc_html__( 'Button Icon', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_box',
			array(
				'label' => esc_html__( 'Box', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'box_background',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-cta-box' => 'background-color: {{VALUE}};',
				),
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
					'{{WRAPPER}} .lcake-cta-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-cta-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .lcake-cta-box',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-cta-box-title' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .lcake-cta-box-title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			array(
				'label' => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.85)',
				'selectors' => array( '{{WRAPPER}} .lcake-cta-box-description' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .lcake-cta-box-description',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			array(
				'label' => esc_html__( 'Button', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-cta-box-button' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'button_background',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-cta-box-button' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'button_hover_background',
			array(
				'label'     => esc_html__( 'Hover Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f3f4f6',
				'selectors' => array( '{{WRAPPER}} .lcake-cta-box-button:hover' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .lcake-cta-box-button',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$title       = $settings['title'] ?? '';
		$description = $settings['description'] ?? '';
		$button_text = $settings['button_text'] ?? '';
		$button_link = $settings['button_link'] ?? array();
		$layout      = $settings['layout'] ?? 'row';

		if ( ! empty( $button_link['url'] ) ) {
			$this->add_link_attributes( 'button_link', $button_link );
		}

		$this->add_render_attribute( 'button_link', 'class', 'lcake-cta-box-button' );
		?>
		<div class="lcake-cta-box lcake-cta-box--<?php echo esc_attr( $layout ); ?>">
			<div class="lcake-cta-box-content">
				<?php if ( ! empty( $title ) ) : ?>
					<h3 class="lcake-cta-box-title"><?php echo wp_kses_post( $title ); ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( $description ) ) : ?>
					<div class="lcake-cta-box-description"><?php echo wp_kses_post( $description ); ?></div>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $button_text ) ) : ?>
				<a <?php echo $this->get_render_attribute_string( 'button_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor pre-sanitizes render attribute strings. ?>> 
					<span><?php echo esc_html( $button_text ); ?></span>
					<?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], array( 'aria-hidden' => 'true' ) ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}
}
