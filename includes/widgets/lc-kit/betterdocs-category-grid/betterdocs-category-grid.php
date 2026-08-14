<?php
/**
 * BetterDocs Category Grid Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Docs Category Grid Widget.
 *
 * Elementor widget that displays a Docs Category Grid.
 */
class LCAKE_Kit_Betterdocs_Category_Grid extends \Elementor\Widget_Base {

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
		return 'lcake-kit-betterdocs-category-grid';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Docs Category Grid', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-betterdocs-category-grid-css' );
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
				'default'   => '2',
				'options'   => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
				),
				'selectors' => array( '{{WRAPPER}} .lcake-docs-category-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ),
			)
		);

		$this->add_control(
			'show_articles',
			array(
				'label'        => esc_html__( 'Show Articles List', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'articles_per_category',
			array(
				'label'     => esc_html__( 'Articles Per Category', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 5,
				'min'       => 1,
				'max'       => 20,
				'condition' => array(
					'show_articles' => 'yes',
				),
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

		// --- Grid/Card Style Section ---
		$this->start_controls_section(
			'section_style_grid',
			array(
				'label' => esc_html__( 'Grid & Cards', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'grid_gap',
			array(
				'label'      => esc_html__( 'Gap Between Columns', 'lc-addons-kit-for-elementor' ),
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
					'size' => 30,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-docs-category-grid' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_bg',
			array(
				'label'     => esc_html__( 'Card Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lcake-docs-category-grid-column' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Card Padding', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lcake-docs-category-grid-column' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// --- Title Style Section ---
		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Category Title', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
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
				'selectors' => array( '{{WRAPPER}} .lcake-docs-category-grid-title a' => 'color: {{VALUE}};' ),
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
				'selectors' => array( '{{WRAPPER}} .lcake-docs-category-grid-title a:hover' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'title_typography',
				'selector'  => '{{WRAPPER}} .lcake-docs-category-grid-title, {{WRAPPER}} .lcake-docs-category-grid-title a',
				'separator' => 'before',
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
					'{{WRAPPER}} .lcake-docs-category-grid-title a:hover, {{WRAPPER}} .lcake-docs-category-grid-list a:hover' => 'text-decoration: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_section();

		// --- Icon Style Section ---
		$this->start_controls_section(
			'section_style_icon',
			array(
				'label'     => esc_html__( 'Category Icon', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_icon' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

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
					'{{WRAPPER}} .lcake-docs-category-grid-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .lcake-docs-category-grid-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
				'default'   => '#2563eb',
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-grid-column:hover .lcake-docs-category-grid-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .lcake-docs-category-grid-column:hover .lcake-docs-category-grid-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
					'{{WRAPPER}} .lcake-docs-category-grid-icon' => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .lcake-docs-category-grid-icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'icon_margin',
			array(
				'label'     => esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .lcake-docs-category-grid-icon' => 'margin-right: {{SIZE}}px;',
				),
			)
		);

		$this->end_controls_section();

		// --- Articles List Style Section ---
		$this->start_controls_section(
			'section_style_articles',
			array(
				'label'     => esc_html__( 'Articles List', 'lc-addons-kit-for-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_articles' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_articles_style' );

		$this->start_controls_tab(
			'tab_articles_normal',
			array(
				'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'articles_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#374151',
				'selectors' => array( '{{WRAPPER}} .lcake-docs-category-grid-list a' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_articles_hover',
			array(
				'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->add_control(
			'articles_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-docs-category-grid-list a:hover' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'articles_typography',
				'selector'  => '{{WRAPPER}} .lcake-docs-category-grid-list a',
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! taxonomy_exists( 'doc_category' ) || ! post_type_exists( 'docs' ) ) {
			LCAKE_Kit_Utils::plugin_inactive_notice( 'BetterDocs' );
			return;
		}

		$settings = $this->get_settings_for_display();

		$terms = get_terms(
			array(
				'taxonomy'   => 'doc_category',
				'hide_empty' => true,
			)
		);

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return;
		}
		?>
		<div class="lcake-docs-category-grid">
			<?php
			foreach ( $terms as $term ) :
				$articles = array();
				if ( 'yes' === $settings['show_articles'] ) {
					$articles = get_posts(
						array(
							'post_type'      => 'docs',
							'posts_per_page' => (int) $settings['articles_per_category'],
							'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
								array(
									'taxonomy' => 'doc_category',
									'field'    => 'term_id',
									'terms'    => $term->term_id,
								),
							),
						)
					);
				}
				?>
				<div class="lcake-docs-category-grid-column">
					<h3 class="lcake-docs-category-grid-title" style="display: flex; align-items: center;">
						<?php if ( 'yes' === $settings['show_icon'] && ! empty( $settings['category_icon']['value'] ) ) : ?>
							<span class="lcake-docs-category-grid-icon" style="display: inline-flex; align-items: center; justify-content: center; line-height: 1;">
								<?php \Elementor\Icons_Manager::render_icon( $settings['category_icon'], array( 'aria-hidden' => 'true' ) ); ?>
							</span>
						<?php endif; ?>
						<a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
					</h3>
					<?php if ( 'yes' === $settings['show_articles'] && ! empty( $articles ) ) : ?>
						<ul class="lcake-docs-category-grid-list">
							<?php foreach ( $articles as $article ) : ?>
								<li><a href="<?php echo esc_url( get_permalink( $article ) ); ?>"><?php echo esc_html( get_the_title( $article ) ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
