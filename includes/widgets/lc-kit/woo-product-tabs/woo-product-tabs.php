<?php
/**
 * WooCommerce Product Tabs Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woo Product Tabs Widget.
 *
 * Elementor widget that displays a Woo Product Tabs.
 */
class LCAKE_Kit_Woo_Product_Tabs extends \Elementor\Widget_Base {

	public function get_required_dependencies() {
		return array(
			array(
				'type'  => 'plugin',
				'class' => 'WooCommerce',
				'name'  => 'WooCommerce',
			),
		);
	}

	public function get_name() {
		return 'lcake-kit-woo-product-tabs';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Woo Product Tabs', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-tabs';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-woo-product-tabs-css' );
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
			'product_id',
			array(
				'label'   => esc_html__( 'Product', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'options' => LCAKE_Kit_Utils::get_woo_product_options(),
				'default' => 0,
			)
		);

		$this->end_controls_section();

		// --- Tab Buttons Style Section ---
		$this->start_controls_section(
			'section_style_tabs',
			array(
				'label' => esc_html__( 'Tab Buttons', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'tab_spacing',
			array(
				'label'     => esc_html__( 'Spacing Between Tabs', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'   => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-woo-tabs ul.tabs' => 'gap: {{SIZE}}{{UNIT}};',
				),
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
			'tab_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f9fafb',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-tabs ul.tabs li a' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'tab_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4b5563',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-tabs ul.tabs li a' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'tab_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .lcake-woo-tabs ul.tabs li a' => 'border-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_active',
			array(
				'label' => esc_html__( 'Active', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'active_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-tabs ul.tabs li.active a' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'active_color',
			array(
				'label'     => esc_html__( 'Text/Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-tabs ul.tabs li.active a' => 'color: {{VALUE}}; border-color: {{VALUE}}; border-bottom-color: {{active_bg_color.VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'tab_typography',
				'selector'  => '{{WRAPPER}} .lcake-woo-tabs ul.tabs li a',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'tab_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-tabs ul.tabs li a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-tabs ul.tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// --- Panel Style Section ---
		$this->start_controls_section(
			'section_style_panel',
			array(
				'label' => esc_html__( 'Content Panel', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'panel_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-tabs .woocommerce-Tabs-panel' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'panel_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4b5563',
				'selectors' => array(
					'{{WRAPPER}} .lcake-woo-tabs .woocommerce-Tabs-panel' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-woo-tabs .woocommerce-Tabs-panel p' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'panel_typography',
				'selector' => '{{WRAPPER}} .lcake-woo-tabs .woocommerce-Tabs-panel',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'panel_border',
				'selector'  => '{{WRAPPER}} .lcake-woo-tabs .woocommerce-Tabs-panel',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'panel_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-tabs .woocommerce-Tabs-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-tabs .woocommerce-Tabs-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! LCAKE_Kit_Utils::is_woo_active() ) {
			LCAKE_Kit_Utils::woo_inactive_notice();
			return;
		}

		$settings   = $this->get_settings_for_display();
		$product_id = (int) $settings['product_id'];
		$product    = LCAKE_Kit_Utils::get_woo_product( $product_id );

		if ( ! $product ) {
			return;
		}

		global $post;
		$original_post    = $post;
		$original_product = isset( $GLOBALS['product'] ) ? $GLOBALS['product'] : null;

		$post               = get_post( $product->get_id() );
		$GLOBALS['product'] = $product;
		setup_postdata( $post );
		?>
		<div class="lcake-woo-tabs">
			<?php wc_get_template( 'single-product/tabs/tabs.php' ); ?>
		</div>
		<?php
		$post               = $original_post;
		$GLOBALS['product'] = $original_product;
		if ( $original_post ) {
			setup_postdata( $original_post );
		} else {
			wp_reset_postdata();
		}
	}
}
