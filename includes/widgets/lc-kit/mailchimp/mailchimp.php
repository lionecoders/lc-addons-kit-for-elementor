<?php
/**
 * MailChimp Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mailchimp Newsletter Widget.
 *
 * Elementor widget that integrates with Mailchimp Newsletter.
 */
class LCAKE_Kit_Mailchimp extends \Elementor\Widget_Base {


	public function get_name() {
		return 'lcake-kit-mailchimp';
	}

	public function get_title() {
		return esc_html__( 'Mailchimp Newsletter', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-mail';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_keywords() {
		return array( 'mailchimp', 'email', 'newsletter', 'subscribe', 'form' );
	}

	public function get_style_depends() {
		return array( 'lcake-kit-mailchimp-css' );
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
			'title',
			array(
				'label'       => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Subscribe to our newsletter', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Get the latest news and updates delivered to your inbox.', 'lc-addons-kit-for-elementor' ),
				'rows'    => 3,
			)
		);

		$this->add_control(
			'api_key',
			array(
				'label'       => esc_html__( 'MailChimp API Key', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your MailChimp API key', 'lc-addons-kit-for-elementor' ),
				'description' => esc_html__( 'You can find your API key in your MailChimp account under Account > Extras > API Keys.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'list_id',
			array(
				'label'       => esc_html__( 'Audience ID', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your Mailchimp Audience ID', 'lc-addons-kit-for-elementor' ),
				'description' => esc_html__( 'You can find your Audience ID in your Mailchimp account under Audience dashboard > Manage Audience > Settings > Audience name and defaults.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'email_placeholder',
			array(
				'label'   => esc_html__( 'Email Placeholder', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Enter your email address', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Subscribe', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'show_name_field',
			array(
				'label'        => esc_html__( 'Show Name Field', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'name_placeholder',
			array(
				'label'     => esc_html__( 'Name Placeholder', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Enter your name', 'lc-addons-kit-for-elementor' ),
				'condition' => array(
					'show_name_field' => 'yes',
				),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'     => esc_html__( 'Layout', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'inline',
				'options'   => array(
					'inline'  => esc_html__( 'Inline', 'lc-addons-kit-for-elementor' ),
					'stacked' => esc_html__( 'Stacked', 'lc-addons-kit-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-mailchimp--inline .lcake-mailchimp-form' => 'display: flex; flex-direction: row; align-items: center; flex-wrap: wrap;',
					'{{WRAPPER}} .lcake-mailchimp--inline .lcake-mailchimp-input' => 'flex: 1; min-width: 200px;',
					'{{WRAPPER}} .lcake-mailchimp--inline .lcake-mailchimp-name' => 'flex: 1; min-width: 200px;',
					'{{WRAPPER}} .lcake-mailchimp--inline .lcake-mailchimp-email' => 'flex: 1; min-width: 200px;',
					'{{WRAPPER}} .lcake-mailchimp--inline .lcake-mailchimp-button' => 'flex: 0 0 auto;',
					'{{WRAPPER}} .lcake-mailchimp--stacked .lcake-mailchimp-form' => 'display: flex; flex-direction: column;',
					'{{WRAPPER}} .lcake-mailchimp--stacked .lcake-mailchimp-input' => 'width: 100%;',
					'{{WRAPPER}} .lcake-mailchimp--stacked .lcake-mailchimp-button' => 'width: 100%;',
				),
			)
		);

		$this->add_responsive_control(
			'items_gap',
			array(
				'label'      => esc_html__( 'Items Gap', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-form' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function add_style_controls() {
		$this->start_controls_section(
			'section_style_form',
			array(
				'label' => esc_html__( 'Form', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'form_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f9f9f9',
				'selectors' => array(
					'{{WRAPPER}} .lcake-mailchimp-form' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'form_border',
				'selector' => '{{WRAPPER}} .lcake-mailchimp-form',
			)
		);

		$this->add_control(
			'form_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '8',
					'right'    => '8',
					'bottom'   => '8',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'form_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '30',
					'right'    => '30',
					'bottom'   => '30',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .lcake-mailchimp-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .lcake-mailchimp-title',
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '15',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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
				'default'   => '#666666',
				'selectors' => array(
					'{{WRAPPER}} .lcake-mailchimp-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .lcake-mailchimp-description',
			)
		);

		$this->add_responsive_control(
			'description_margin',
			array(
				'label'      => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '25',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_inputs',
			array(
				'label' => esc_html__( 'Input Fields', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'input_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-mailchimp-input' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'input_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .lcake-mailchimp-input' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'selector' => '{{WRAPPER}} .lcake-mailchimp-input',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'input_border',
				'selector' => '{{WRAPPER}} .lcake-mailchimp-input',
			)
		);

		$this->add_control(
			'input_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '4',
					'right'    => '4',
					'bottom'   => '4',
					'left'     => '4',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '12',
					'right'    => '15',
					'bottom'   => '12',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_margin',
			array(
				'label'      => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '15',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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
			'button_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#007bff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-mailchimp-button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-mailchimp-button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .lcake-mailchimp-button',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .lcake-mailchimp-button',
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'      => '4',
					'right'    => '4',
					'bottom'   => '4',
					'left'     => '4',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '12',
					'right'    => '25',
					'bottom'   => '12',
					'left'     => '25',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-mailchimp-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'lcake-mailchimp-wrapper' );
		$this->add_render_attribute( 'wrapper', 'class', 'lcake-mailchimp--' . $settings['layout'] );

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor pre-sanitizes render attribute strings.

		if ( ! empty( $settings['title'] ) ) {
			echo '<h3 class="lcake-mailchimp-title">' . esc_html( $settings['title'] ) . '</h3>';
		}

		if ( ! empty( $settings['description'] ) ) {
			echo '<div class="lcake-mailchimp-description">' . esc_html( $settings['description'] ) . '</div>';
		}

		echo '<form class="lcake-mailchimp-form" method="post">';
		echo '<input type="hidden" name="lcake_mailchimp_api_key" value="' . esc_attr( $settings['api_key'] ) . '">';
		echo '<input type="hidden" name="lcake_mailchimp_list_id" value="' . esc_attr( $settings['list_id'] ) . '">';
		echo '<input type="hidden" name="lcake_mailchimp_nonce" value="' . esc_attr( wp_create_nonce( 'lcake_mailchimp_nonce' ) ) . '">';

		if ( $settings['show_name_field'] === 'yes' ) {
			echo '<input type="text" name="lcake_mailchimp_name" class="lcake-mailchimp-input lcake-mailchimp-name" placeholder="' . esc_attr( $settings['name_placeholder'] ) . '" required>';
		}

		echo '<input type="email" name="lcake_mailchimp_email" class="lcake-mailchimp-input lcake-mailchimp-email" placeholder="' . esc_attr( $settings['email_placeholder'] ) . '" required>';
		echo '<button type="submit" class="lcake-mailchimp-button">' . esc_html( $settings['button_text'] ) . '</button>';

		echo '<div class="lcake-mailchimp-message"></div>';
		echo '</form>';

		echo '</div>';
	}
}
