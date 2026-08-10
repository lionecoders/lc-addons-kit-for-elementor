<?php
/**
 * WooCommerce Product Compare Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woo Product Compare Widget.
 *
 * Elementor widget that displays a Woo Product Compare.
 */
class LCAKE_Kit_Woo_Product_Compare extends \Elementor\Widget_Base {

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
		return 'lcake-kit-woo-product-compare';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Woo Product Compare', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-exchange';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-woo-product-compare-css' );
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
			'products',
			array(
				'label'    => esc_html__( 'Products', 'lc-addons-kit-for-elementor' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options'  => LCAKE_Kit_Utils::is_woo_active() ? array_slice( LCAKE_Kit_Utils::get_woo_product_options(), 1, null, true ) : array(),
			)
		);

		$this->add_control(
			'max_products',
			array(
				'label'     => esc_html__( 'Max Products Limit', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 4,
				'min'       => 1,
				'max'       => 10,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading_row_visibility',
			array(
				'label'     => esc_html__( 'Row Visibility', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'show_image',
			array(
				'label'        => esc_html__( 'Show Image', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_price',
			array(
				'label'        => esc_html__( 'Show Price', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_rating',
			array(
				'label'        => esc_html__( 'Show Rating', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_description',
			array(
				'label'        => esc_html__( 'Show Description', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_add_to_cart',
			array(
				'label'        => esc_html__( 'Show Add to Cart', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		// --- Style Tab ---
		$this->start_controls_section(
			'section_style_table',
			array(
				'label' => esc_html__( 'Table & Cells', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Text Alignment', 'lc-addons-kit-for-elementor' ),
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
					'{{WRAPPER}} .lcake-woo-compare th, {{WRAPPER}} .lcake-woo-compare td' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'table_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#e5e7eb',
				'selectors' => array(
					'{{WRAPPER}} .lcake-woo-compare th, {{WRAPPER}} .lcake-woo-compare td' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// --- Header Style Section ---
		$this->start_controls_section(
			'section_style_header',
			array(
				'label' => esc_html__( 'Header Row', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'header_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-compare thead th' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'header_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-compare thead th' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'header_typography',
				'selector' => '{{WRAPPER}} .lcake-woo-compare thead th',
			)
		);

		$this->add_responsive_control(
			'header_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-compare thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// --- Row Labels Section ---
		$this->start_controls_section(
			'section_style_labels',
			array(
				'label' => esc_html__( 'Row Labels', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'label_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f9fafb',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-compare td.lcake-woo-compare-label' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#374151',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-compare td.lcake-woo-compare-label' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .lcake-woo-compare td.lcake-woo-compare-label',
			)
		);

		$this->add_responsive_control(
			'label_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-compare td.lcake-woo-compare-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// --- Value Cells Section ---
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content Cells', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'content_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-compare td:not(.lcake-woo-compare-label)' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4b5563',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-compare td:not(.lcake-woo-compare-label)' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .lcake-woo-compare td:not(.lcake-woo-compare-label)',
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-compare td:not(.lcake-woo-compare-label)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$settings    = $this->get_settings_for_display();
		$product_ids = $settings['products'] ?? array();

		if ( empty( $product_ids ) ) {
			return;
		}

		$max_limit   = ! empty( $settings['max_products'] ) ? (int) $settings['max_products'] : 4;
		$product_ids = array_slice( $product_ids, 0, $max_limit );

		$products = array_filter( array_map( 'wc_get_product', $product_ids ) );

		if ( empty( $products ) ) {
			return;
		}

		$rows = array();
		if ( 'yes' === ( $settings['show_image'] ?? 'yes' ) ) {
			$rows['image'] = esc_html__( 'Image', 'lc-addons-kit-for-elementor' );
		}
		if ( 'yes' === ( $settings['show_price'] ?? 'yes' ) ) {
			$rows['price'] = esc_html__( 'Price', 'lc-addons-kit-for-elementor' );
		}
		if ( 'yes' === ( $settings['show_rating'] ?? 'yes' ) ) {
			$rows['rating'] = esc_html__( 'Rating', 'lc-addons-kit-for-elementor' );
		}
		if ( 'yes' === ( $settings['show_description'] ?? 'yes' ) ) {
			$rows['description'] = esc_html__( 'Description', 'lc-addons-kit-for-elementor' );
		}
		if ( 'yes' === ( $settings['show_add_to_cart'] ?? 'yes' ) ) {
			$rows['add_to_cart'] = esc_html__( 'Add To Cart', 'lc-addons-kit-for-elementor' );
		}
		?>
		<div class="lcake-woo-compare-wrapper">
			<table class="lcake-woo-compare">
				<thead>
					<tr>
						<th></th>
						<?php foreach ( $products as $product ) : ?>
							<th><?php echo esc_html( $product->get_name() ); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $key => $label ) : ?>
						<tr>
							<td class="lcake-woo-compare-label"><?php echo esc_html( $label ); ?></td>
							<?php foreach ( $products as $product ) : ?>
								<td>
									<?php
									switch ( $key ) :
										case 'image':
											?>
											<?php echo $product->get_image( 'thumbnail' ); ?>
											<?php
											break;
										case 'price':
											?>
											<?php echo wp_kses_post( $product->get_price_html() ); ?>
											<?php
											break;
										case 'rating':
											?>
											<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
											<?php
											break;
										case 'description':
											?>
											<?php echo esc_html( wp_trim_words( $product->get_short_description(), 15, '...' ) ); ?>
											<?php
											break;
										case 'add_to_cart':
											?>
											<?php echo do_shortcode( '[add_to_cart id="' . $product->get_id() . '" show_price="false"]' ); ?>
											<?php
											break;
									endswitch;
									?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}
}
