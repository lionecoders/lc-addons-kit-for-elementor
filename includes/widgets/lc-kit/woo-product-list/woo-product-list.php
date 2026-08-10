<?php
/**
 * WooCommerce Product List Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woo Product List Widget.
 *
 * Elementor widget that displays a Woo Product List.
 */
class LCAKE_Kit_Woo_Product_List extends \Elementor\Widget_Base {

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
		return 'lcake-kit-woo-product-list';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Woo Product List', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-woo-product-list-css' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Query', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'products_count',
			array(
				'label'   => esc_html__( 'Products Count', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 50,
			)
		);

		$this->add_control(
			'order_by',
			array(
				'label'   => esc_html__( 'Order By', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'       => esc_html__( 'Date', 'lc-addons-kit-for-elementor' ),
					'popularity' => esc_html__( 'Popularity', 'lc-addons-kit-for-elementor' ),
					'rand'       => esc_html__( 'Random', 'lc-addons-kit-for-elementor' ),
					'title'      => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
					'price'      => esc_html__( 'Price', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Order', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => array(
					'desc' => esc_html__( 'Descending', 'lc-addons-kit-for-elementor' ),
					'asc'  => esc_html__( 'Ascending', 'lc-addons-kit-for-elementor' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_visibility',
			array(
				'label' => esc_html__( 'Content Visibility', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
			'show_title',
			array(
				'label'        => esc_html__( 'Show Title', 'lc-addons-kit-for-elementor' ),
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
			'show_price',
			array(
				'label'        => esc_html__( 'Show Price', 'lc-addons-kit-for-elementor' ),
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
			'section_style_list_items',
			array(
				'label' => esc_html__( 'List Items', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'item_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-item' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'     => esc_html__( 'Spacing Between Items', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'   => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-woo-list' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => esc_html__( 'Item Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'item_border',
				'selector' => '{{WRAPPER}} .lcake-woo-list-item',
			)
		);

		$this->add_control(
			'item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .lcake-woo-list-item',
			)
		);

		$this->end_controls_section();

		// --- Title Styles ---
		$this->start_controls_section(
			'section_style_title',
			array(
				'label'     => esc_html__( 'Title', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_title' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-title a' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-title a:hover' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'title_typography',
				'selector'  => '{{WRAPPER}} .lcake-woo-list-title, {{WRAPPER}} .lcake-woo-list-title a',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_hover_underline',
			array(
				'label'     => esc_html__( 'Hover Underline', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'      => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
					'underline' => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-woo-list-title a:hover' => 'text-decoration: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_section();

		// --- Rating Styles ---
		$this->start_controls_section(
			'section_style_rating',
			array(
				'label'     => esc_html__( 'Rating', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_rating' => 'yes',
				),
			)
		);

		$this->add_control(
			'rating_star_color',
			array(
				'label'     => esc_html__( 'Star Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#facc15',
				'selectors' => array(
					'{{WRAPPER}} .lcake-woo-list-rating .star-rating span::before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'rating_star_size',
			array(
				'label'     => esc_html__( 'Star Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 8,
						'max' => 24,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-woo-list-rating .star-rating' => 'font-size: {{SIZE}}px; width: calc({{SIZE}}px * 5); height: {{SIZE}}px;',
				),
			)
		);

		$this->end_controls_section();

		// --- Price Styles ---
		$this->start_controls_section(
			'section_style_price',
			array(
				'label'     => esc_html__( 'Price', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_price' => 'yes',
				),
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Price Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-price' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .lcake-woo-list-price',
			)
		);

		$this->end_controls_section();

		// --- Add to Cart Button Styles ---
		$this->start_controls_section(
			'section_style_add_to_cart',
			array(
				'label'     => esc_html__( 'Add to Cart Button', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_add_to_cart' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_cart_btn' );

		$this->start_controls_tab(
			'tab_cart_btn_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'btn_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-cart a.button' => 'background-color: {{VALUE}}; transition: all 0.3s ease;' ),
			)
		);

		$this->add_control(
			'btn_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-cart a.button' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'btn_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-cart a.button' => 'border-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cart_btn_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'btn_hover_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-cart a.button:hover' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'btn_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-cart a.button:hover' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'btn_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .lcake-woo-list-cart a.button:hover' => 'border-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'btn_typography',
				'selector'  => '{{WRAPPER}} .lcake-woo-list-cart a.button',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'btn_border',
				'selector' => '{{WRAPPER}} .lcake-woo-list-cart a.button',
			)
		);

		$this->add_control(
			'btn_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-list-cart a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'btn_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-woo-list-cart a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$settings = $this->get_settings_for_display();

		$args = array(
			'post_type'           => 'product',
			'posts_per_page'      => (int) $settings['products_count'],
			'ignore_sticky_posts' => true,
		);

		$orderby = $settings['order_by'] ?? 'date';
		if ( 'price' === $orderby ) {
			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = '_price';
		} else {
			$args['orderby'] = $orderby;
		}

		$args['order'] = ! empty( $settings['order'] ) ? $settings['order'] : 'desc';

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return;
		}

		$show_image       = 'yes' === ( $settings['show_image'] ?? 'yes' );
		$show_title       = 'yes' === ( $settings['show_title'] ?? 'yes' );
		$show_rating      = 'yes' === ( $settings['show_rating'] ?? 'yes' );
		$show_price       = 'yes' === ( $settings['show_price'] ?? 'yes' );
		$show_add_to_cart = 'yes' === ( $settings['show_add_to_cart'] ?? 'yes' );
		?>
		<div class="lcake-woo-list">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				global $product;
				if ( ! $product instanceof \WC_Product ) {
					$product = wc_get_product( get_the_ID() );
				}
				if ( ! $product ) {
					continue;
				}
				?>
				<div class="lcake-woo-list-item">
					<?php if ( $show_image ) : ?>
						<a href="<?php the_permalink(); ?>" class="lcake-woo-list-thumb">
							<?php echo $product->get_image( 'thumbnail', array( 'class' => 'lcake-woo-list-image' ) ); ?>
						</a>
					<?php endif; ?>
					<div class="lcake-woo-list-content">
						<?php if ( $show_title ) : ?>
							<h3 class="lcake-woo-list-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
						<?php endif; ?>
						<?php if ( $show_rating ) : ?>
							<div class="lcake-woo-list-rating"><?php echo wc_get_rating_html( $product->get_average_rating() ); ?></div>
						<?php endif; ?>
						<?php if ( $show_price ) : ?>
							<div class="lcake-woo-list-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
						<?php endif; ?>
					</div>
					<?php if ( $show_add_to_cart ) : ?>
						<div class="lcake-woo-list-cart">
							<?php echo do_shortcode( '[add_to_cart id="' . $product->get_id() . '" show_price="false"]' ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endwhile; ?>
		</div>
		<?php
		wp_reset_postdata();
	}
}
