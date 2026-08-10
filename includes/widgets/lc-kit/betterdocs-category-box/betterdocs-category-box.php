<?php
/**
 * BetterDocs Category Box Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Docs Category Box Widget.
 *
 * Elementor widget that displays a Docs Category Box.
 */
class LCAKE_Kit_Betterdocs_Category_Box extends \Elementor\Widget_Base {

	public function get_required_dependencies() {
		return array(
			array(
				'type'      => 'post_type',
				'post_type' => 'docs',
				'name'      => 'BetterDocs',
			),
		);
	}

	public function get_name() {
		return 'lcake-kit-betterdocs-category-box';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Docs Category Box', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-betterdocs-category-box-css' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'     => esc_html__( 'Columns', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'selectors' => array( '{{WRAPPER}} .lcake-docs-category-box' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ),
			)
		);

		$this->add_control(
			'exclude_empty',
			array(
				'label'   => esc_html__( 'Hide Empty Categories', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_icon',
			array(
				'label'        => esc_html__( 'Show Category Icon', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'category_icon',
			array(
				'label'     => esc_html__( 'Category Icon', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-folder',
					'library' => 'solid',
				),
				'condition' => array(
					'show_icon' => 'yes',
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
			'heading_card_style',
			array(
				'label' => esc_html__( 'Card', 'lc-addons-kit-for-elementor' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'grid_gap',
			array(
				'label'      => esc_html__( 'Gap Between Boxes', 'lc-addons-kit-for-elementor' ),
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
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-docs-category-box' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_card_style' );

		$this->start_controls_tab(
			'tab_card_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'card_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-card' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .lcake-docs-category-card',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .lcake-docs-category-card',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_card_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'card_bg_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-card:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_border_hover_color',
			array(
				'label'     => esc_html__( 'Border Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-card:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_box_shadow_hover',
				'selector' => '{{WRAPPER}} .lcake-docs-category-card:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-docs-category-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_control(
			'card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-docs-category-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'hover_animation_style',
			array(
				'label'     => esc_html__( 'Hover Animation Style', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'translate',
				'options'   => array(
					'none'      => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
					'translate' => esc_html__( 'Slide Up', 'lc-addons-kit-for-elementor' ),
					'scale'     => esc_html__( 'Scale Up', 'lc-addons-kit-for-elementor' ),
					'shadow'    => esc_html__( 'Shadow Shift', 'lc-addons-kit-for-elementor' ),
					'border'    => esc_html__( 'Border Shift', 'lc-addons-kit-for-elementor' ),
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading_name_style',
			array(
				'label'     => esc_html__( 'Category Name', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_name_style' );

		$this->start_controls_tab(
			'tab_name_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'name_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-card .lcake-docs-category-name, {{WRAPPER}} .lcake-docs-category-name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_name_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'name_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-card:hover .lcake-docs-category-name, {{WRAPPER}} .lcake-docs-category-card:hover a .lcake-docs-category-name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .lcake-docs-category-card .lcake-docs-category-name, {{WRAPPER}} .lcake-docs-category-name',
			)
		);

		$this->add_control(
			'name_hover_underline',
			array(
				'label'     => esc_html__( 'Hover Underline', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'      => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
					'underline' => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-card:hover, {{WRAPPER}} .lcake-docs-category-card:hover .lcake-docs-category-name, {{WRAPPER}} .lcake-docs-category-card:hover a .lcake-docs-category-name' => 'text-decoration: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'heading_count_style',
			array(
				'label'     => esc_html__( 'Article Count', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_count_style' );

		$this->start_controls_tab(
			'tab_count_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'count_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#9ca3af',
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-count' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_count_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'count_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-card:hover .lcake-docs-category-count' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'count_typography',
				'selector' => '{{WRAPPER}} .lcake-docs-category-count',
			)
		);

		$this->add_control(
			'heading_icon_style',
			array(
				'label'     => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_icon' => 'yes',
				),
			)
		);

		$this->start_controls_tabs(
			'tabs_icon_style',
			array(
				'condition' => array(
					'show_icon' => 'yes',
				),
			)
		);

		$this->start_controls_tab(
			'tab_icon_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .lcake-docs-category-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'icon_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-card:hover .lcake-docs-category-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .lcake-docs-category-card:hover .lcake-docs-category-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-icon' => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .lcake-docs-category-icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
				),
				'separator' => 'before',
				'condition' => array(
					'show_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'icon_margin',
			array(
				'label'     => esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-icon' => 'margin-bottom: {{SIZE}}px;',
				),
				'condition' => array(
					'show_icon' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! taxonomy_exists( 'doc_category' ) ) {
			LCAKE_Kit_Utils::plugin_inactive_notice( 'BetterDocs' );
			return;
		}

		$settings = $this->get_settings_for_display();

		$terms = get_terms(
			array(
				'taxonomy'   => 'doc_category',
				'hide_empty' => 'yes' === $settings['exclude_empty'],
			)
		);

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return;
		}
		?>
		<div class="lcake-docs-category-box">
			<?php foreach ( $terms as $term ) : ?>
				<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="lcake-docs-category-card lcake-hover-ani-<?php echo esc_attr( $settings['hover_animation_style'] ?? 'translate' ); ?>">
					<?php if ( 'yes' === $settings['show_icon'] && ! empty( $settings['category_icon']['value'] ) ) : ?>
						<span class="lcake-docs-category-icon" aria-hidden="true" style="display: inline-flex; align-items: center; justify-content: center; line-height: 1;">
							<?php \Elementor\Icons_Manager::render_icon( $settings['category_icon'], array( 'aria-hidden' => 'true' ) ); ?>
						</span>
					<?php endif; ?>
					<span class="lcake-docs-category-name"><?php echo esc_html( $term->name ); ?></span>
					<span class="lcake-docs-category-count">
						<?php
						printf(
							/* translators: %d: number of articles */
							esc_html( _n( '%d Article', '%d Articles', $term->count, 'lc-addons-kit-for-elementor' ) ),
							(int) $term->count
						);
						?>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
