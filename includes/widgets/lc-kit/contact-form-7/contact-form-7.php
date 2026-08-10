<?php
/**
 * Contact Form 7 Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LCAKE_Kit_Contact_Form_7 extends \Elementor\Widget_Base {


	public function get_name() {
		return 'lcake-kit-contact-form-7';
	}

	public function get_title() {
		return esc_html__( 'Contact Form 7', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_keywords() {
		return array( 'contact', 'form', 'cf7', 'contact form 7', 'form' );
	}

	public function get_required_dependencies() {
		return array(
			array(
				'type'  => 'plugin',
				'class' => 'WPCF7_ContactForm',
				'name'  => 'Contact Form 7',
			),
		);
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
			'form_id',
			array(
				'label'       => esc_html__( 'Select Form', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => $this->get_contact_form_7_forms(),
				'default'     => '',
				'description' => esc_html__( 'Select a Contact Form 7 form to display. Make sure Contact Form 7 plugin is installed and activated.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'show_form_title',
			array(
				'label'        => esc_html__( 'Show Form Title', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'form_id!' => '',
				),
			)
		);

		$this->add_control(
			'form_title',
			array(
				'label'       => esc_html__( 'Form Title', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Contact Us', 'lc-addons-kit-for-elementor' ),
				'placeholder' => esc_html__( 'Enter form title', 'lc-addons-kit-for-elementor' ),
				'condition'   => array(
					'form_id!'        => '',
					'show_form_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_form_description',
			array(
				'label'        => esc_html__( 'Show Form Description', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'form_id!' => '',
				),
			)
		);

		$this->add_control(
			'form_description',
			array(
				'label'       => esc_html__( 'Form Description', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'We would love to hear from you. Please fill out the form below.', 'lc-addons-kit-for-elementor' ),
				'placeholder' => esc_html__( 'Enter form description', 'lc-addons-kit-for-elementor' ),
				'rows'        => 3,
				'condition'   => array(
					'form_id!'              => '',
					'show_form_description' => 'yes',
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
					'{{WRAPPER}} .lcake-contact-form-7' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'form_border',
				'selector' => '{{WRAPPER}} .lcake-contact-form-7',
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
					'{{WRAPPER}} .lcake-contact-form-7' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .lcake-contact-form-7' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			array(
				'label'     => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'form_id!'        => '',
					'show_form_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .lcake-contact-form-7-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .lcake-contact-form-7-title',
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
					'{{WRAPPER}} .lcake-contact-form-7-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			array(
				'label'     => esc_html__( 'Description', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'form_id!'              => '',
					'show_form_description' => 'yes',
				),
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => array(
					'{{WRAPPER}} .lcake-contact-form-7-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .lcake-contact-form-7-description',
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
					'{{WRAPPER}} .lcake-contact-form-7-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .lcake-contact-form-7 input[type="text"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="email"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="tel"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="url"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="number"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="date"],
                     {{WRAPPER}} .lcake-contact-form-7 textarea,
                     {{WRAPPER}} .lcake-contact-form-7 select' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .lcake-contact-form-7 input[type="text"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="email"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="tel"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="url"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="number"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="date"],
                     {{WRAPPER}} .lcake-contact-form-7 textarea,
                     {{WRAPPER}} .lcake-contact-form-7 select' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'selector' => '{{WRAPPER}} .lcake-contact-form-7 input[type="text"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="email"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="tel"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="url"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="number"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="date"],
                               {{WRAPPER}} .lcake-contact-form-7 textarea,
                               {{WRAPPER}} .lcake-contact-form-7 select',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'input_border',
				'selector' => '{{WRAPPER}} .lcake-contact-form-7 input[type="text"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="email"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="tel"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="url"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="number"],
                               {{WRAPPER}} .lcake-contact-form-7 input[type="date"],
                               {{WRAPPER}} .lcake-contact-form-7 textarea,
                               {{WRAPPER}} .lcake-contact-form-7 select',
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
					'{{WRAPPER}} .lcake-contact-form-7 input[type="text"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="email"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="tel"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="url"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="number"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="date"],
                     {{WRAPPER}} .lcake-contact-form-7 textarea,
                     {{WRAPPER}} .lcake-contact-form-7 select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .lcake-contact-form-7 input[type="text"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="email"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="tel"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="url"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="number"],
                     {{WRAPPER}} .lcake-contact-form-7 input[type="date"],
                     {{WRAPPER}} .lcake-contact-form-7 textarea,
                     {{WRAPPER}} .lcake-contact-form-7 select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .lcake-contact-form-7 .wpcf7-form-control-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			array(
				'label' => esc_html__( 'Submit Button', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#007bff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-contact-form-7 input[type="submit"],
                     {{WRAPPER}} .lcake-contact-form-7 button[type="submit"]' => 'background-color: {{VALUE}}; transition: all 0.3s ease-in-out;',
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
					'{{WRAPPER}} .lcake-contact-form-7 input[type="submit"],
                     {{WRAPPER}} .lcake-contact-form-7 button[type="submit"]' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'button_background_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-contact-form-7 input[type="submit"]:hover,
                     {{WRAPPER}} .lcake-contact-form-7 button[type="submit"]:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-contact-form-7 input[type="submit"]:hover,
                     {{WRAPPER}} .lcake-contact-form-7 button[type="submit"]:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_border_hover_color',
			array(
				'label'     => esc_html__( 'Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-contact-form-7 input[type="submit"]:hover,
                     {{WRAPPER}} .lcake-contact-form-7 button[type="submit"]:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .lcake-contact-form-7 input[type="submit"],
                               {{WRAPPER}} .lcake-contact-form-7 button[type="submit"]',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .lcake-contact-form-7 input[type="submit"],
                               {{WRAPPER}} .lcake-contact-form-7 button[type="submit"]',
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
					'{{WRAPPER}} .lcake-contact-form-7 input[type="submit"],
                     {{WRAPPER}} .lcake-contact-form-7 button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .lcake-contact-form-7 input[type="submit"],
                     {{WRAPPER}} .lcake-contact-form-7 button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	private function get_contact_form_7_forms() {
		$forms = array();

		if ( class_exists( 'WPCF7_ContactForm' ) ) {
			$cf7_forms = get_posts(
				array(
					'post_type'   => 'wpcf7_contact_form',
					'numberposts' => -1,
				)
			);

			foreach ( $cf7_forms as $form ) {
				$forms[ $form->ID ] = $form->post_title;
			}
		}

		if ( empty( $forms ) ) {
			$forms[''] = esc_html__( 'No forms found', 'lc-addons-kit-for-elementor' );
		}

		return $forms;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['form_id'] ) ) {
			echo '<div class="lcake-contact-form-7-error">' . esc_html__( 'Please select a Contact Form 7 form.', 'lc-addons-kit-for-elementor' ) . '</div>';
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'lcake-contact-form-7' );

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';

		if ( $settings['show_form_title'] === 'yes' && ! empty( $settings['form_title'] ) ) {
			echo '<h3 class="lcake-contact-form-7-title">' . esc_html( $settings['form_title'] ) . '</h3>';
		}

		if ( $settings['show_form_description'] === 'yes' && ! empty( $settings['form_description'] ) ) {
			echo '<div class="lcake-contact-form-7-description">' . esc_html( $settings['form_description'] ) . '</div>';
		}

		if ( function_exists( 'wpcf7_contact_form' ) ) {
			echo do_shortcode( '[contact-form-7 id="' . esc_attr( $settings['form_id'] ) . '"]' );
		} else {
			echo '<div class="lcake-contact-form-7-error">' . esc_html__( 'Contact Form 7 plugin is not installed or activated.', 'lc-addons-kit-for-elementor' ) . '</div>';
		}

		echo '</div>';
	}
}
