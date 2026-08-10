<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class LC_Header_Footer_Nav_Menu extends \Elementor\Widget_Base {


	public function get_name() {
		return 'lc-header-footer-nav-menu';
	}

	public function get_title() {
		return esc_html__( 'Nav Menu', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_categories() {
		return array( 'lc-header-footer-kit' );
	}

	public function get_keywords() {
		return array( 'nav', 'menu', 'navigation', 'header' );
	}

	public function get_style_depends() {
		return array( 'lc-header-footer-nav-menu-css' );
	}

	public function get_script_depends() {
		return array( 'lc-header-footer-nav-menu-js' );
	}

	protected function register_controls() {
		// CONTENT TAB
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Layout', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$menus        = wp_get_nav_menus();
		$menu_options = array( 0 => esc_html__( '— Select a Menu —', 'lc-addons-kit-for-elementor' ) );
		foreach ( $menus as $menu ) {
			$menu_options[ $menu->term_id ] = $menu->name;
		}

		$this->add_control(
			'menu',
			array(
				'label'       => esc_html__( 'Menu', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => $menu_options,
				'default'     => 0,
				'description' => empty( $menus )
					? esc_html__( 'No menus found. Create one under Appearance > Menus.', 'lc-addons-kit-for-elementor' )
					: '',
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'        => esc_html__( 'Layout', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => 'horizontal',
				'options'      => array(
					'horizontal' => esc_html__( 'Horizontal', 'lc-addons-kit-for-elementor' ),
					'vertical'   => esc_html__( 'Vertical', 'lc-addons-kit-for-elementor' ),
				),
				'prefix_class' => 'lc-hf-nav-menu--',
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'        => esc_html__( 'Align', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-h-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Stretch', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-h-align-stretch',
					),
				),
				'prefix_class' => 'lc-hf-nav-menu__align-',
				'condition'    => array(
					'layout' => 'horizontal',
				),
			)
		);

		$this->add_control(
			'mobile_breakpoint',
			array(
				'label'       => esc_html__( 'Collapse Below (px)', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 800,
				'description' => esc_html__( 'The menu will turn into a hamburger toggle below this width.', 'lc-addons-kit-for-elementor' ),
			)
		);

		$this->end_controls_section();

		// STYLE TAB - MAIN MENU
		$this->start_controls_section(
			'section_style_main_menu',
			array(
				'label' => esc_html__( 'Main Menu', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'link_typography',
				'selector' => '{{WRAPPER}} .lc-hf-nav-menu > li > a',
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'     => esc_html__( 'Space Between', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 28,
					'unit' => 'px',
				),
				'selectors' => array( '{{WRAPPER}} .lc-hf-nav-menu' => 'gap: {{SIZE}}{{UNIT}};' ),
			)
		);

		$this->start_controls_tabs( 'tabs_main_menu_style' );

		// NORMAL
		$this->start_controls_tab(
			'tab_main_menu_normal',
			array( 'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ) )
		);

		$this->add_control(
			'link_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lc-hf-nav-menu > li > a' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		// HOVER
		$this->start_controls_tab(
			'tab_main_menu_hover',
			array( 'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ) )
		);

		$this->add_control(
			'link_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-nav-menu > li > a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		// ACTIVE
		$this->start_controls_tab(
			'tab_main_menu_active',
			array( 'label' => esc_html__( 'Active', 'lc-addons-kit-for-elementor' ) )
		);

		$this->add_control(
			'link_active_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-nav-menu > li.current-menu-item > a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		// STYLE TAB - DROPDOWN
		$this->start_controls_section(
			'section_style_dropdown',
			array(
				'label' => esc_html__( 'Dropdown', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'dropdown_typography',
				'selector' => '{{WRAPPER}} .lc-hf-nav-submenu li a',
			)
		);

		$this->start_controls_tabs( 'tabs_dropdown_style' );

		// NORMAL
		$this->start_controls_tab(
			'tab_dropdown_normal',
			array( 'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ) )
		);

		$this->add_control(
			'dropdown_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#374151',
				'selectors' => array( '{{WRAPPER}} .lc-hf-nav-submenu li a' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'dropdown_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array( '{{WRAPPER}} .lc-hf-nav-submenu' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		// HOVER
		$this->start_controls_tab(
			'tab_dropdown_hover',
			array( 'label' => esc_html__( 'Hover', 'lc-addons-kit-for-elementor' ) )
		);

		$this->add_control(
			'dropdown_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lc-hf-nav-submenu li a:hover' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'dropdown_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(59, 130, 246, 0.08)',
				'selectors' => array( '{{WRAPPER}} .lc-hf-nav-submenu li a:hover' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();

		// ACTIVE
		$this->start_controls_tab(
			'tab_dropdown_active',
			array( 'label' => esc_html__( 'Active', 'lc-addons-kit-for-elementor' ) )
		);

		$this->add_control(
			'dropdown_active_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lc-hf-nav-submenu li.current-menu-item > a' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'dropdown_active_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .lc-hf-nav-submenu li.current-menu-item > a' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'dropdown_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lc-hf-nav-submenu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'dropdown_box_shadow',
				'selector' => '{{WRAPPER}} .lc-hf-nav-submenu',
			)
		);

		$this->add_responsive_control(
			'dropdown_distance',
			array(
				'label'     => esc_html__( 'Distance', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-nav-submenu' => 'transform: translateY({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .lc-hf-has-submenu:hover > .lc-hf-nav-submenu' => 'transform: translateY(0);',
				),
			)
		);

		$this->end_controls_section();

		// STYLE TAB - TOGGLE BUTTON
		$this->start_controls_section(
			'section_style_toggle',
			array(
				'label' => esc_html__( 'Toggle Button', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_toggle_style' );

		// NORMAL
		$this->start_controls_tab(
			'tab_toggle_normal',
			array( 'label' => esc_html__( 'Normal', 'lc-addons-kit-for-elementor' ) )
		);

		$this->add_control(
			'toggle_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lc-hf-menu-toggle-bar' => 'background-color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'toggle_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .lc-hf-menu-toggle' => 'background-color: {{VALUE}} !important;' ),
			)
		);

		$this->end_controls_tab();

		// HOVER
		$this->start_controls_tab(
			'tab_toggle_hover',
			array( 'label' => esc_html__( 'Hover / Active', 'lc-addons-kit-for-elementor' ) )
		);

		$this->add_control(
			'toggle_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-menu-toggle:hover .lc-hf-menu-toggle-bar' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .lc-hf-nav-menu-container.lc-hf-menu-open .lc-hf-menu-toggle .lc-hf-menu-toggle-bar' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'toggle_hover_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .lc-hf-menu-toggle:hover' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .lc-hf-nav-menu-container.lc-hf-menu-open .lc-hf-menu-toggle' => 'background-color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'full_width',
			array(
				'label'        => esc_html__( 'Full Width', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Stretch the dropdown of the menu to full width.', 'lc-addons-kit-for-elementor' ),
				'prefix_class' => 'lc-hf-nav-menu--',
				'return_value' => 'stretch',
				'separator'    => 'before',
			)
		);

		$this->add_responsive_control(
			'toggle_size',
			array(
				'label'     => esc_html__( 'Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 20,
						'max' => 80,
					),
				),
				'default'   => array(
					'size' => 28,
					'unit' => 'px',
				),
				'separator' => 'before',
				'selectors' => array( '{{WRAPPER}} .lc-hf-menu-toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ),
			)
		);

		$this->add_control(
			'toggle_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'lc-addons-kit-for-elementor' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lc-hf-menu-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$menu_id  = (int) $settings['menu'];

		if ( empty( $menu_id ) ) {
			if ( current_user_can( 'edit_theme_options' ) ) {
				echo '<p class="lc-hf-notice">' . esc_html__( 'Select a menu to display.', 'lc-addons-kit-for-elementor' ) . '</p>';
			}
			return;
		}

		$args = array(
			'echo'        => false,
			'menu'        => $menu_id,
			'container'   => false,
			'menu_class'  => 'lc-hf-nav-menu',
			'fallback_cb' => function ( $args ) {
				$pages = wp_list_pages(
					array(
						'title_li' => '',
						'echo'     => false,
					)
				);
				return '<ul class="' . esc_attr( $args['menu_class'] ) . '">' . $pages . '</ul>';
			},
			'walker'      => new LC_Header_Footer_Nav_Menu_Walker(),
		);

		$layout = $settings['layout'] ?? 'horizontal';

		$main_args = $args;
		if ( $layout === 'vertical' ) {
			$main_args['menu_class'] .= ' sm-vertical';
		} else {
			$main_args['menu_class'] .= ' sm-horizontal';
		}
		$main_args['menu_id'] = 'menu-' . $this->get_id();
		$menu_html            = wp_nav_menu( $main_args );

		$dropdown_args                = $args;
		$dropdown_args['menu_class'] .= ' sm-vertical';
		$dropdown_args['menu_id']     = 'menu-' . $this->get_id() . '-dropdown';
		$dropdown_menu_html           = wp_nav_menu( $dropdown_args );

		if ( ! $menu_html ) {
			return;
		}

		$id                = $this->get_id();
		$mobile_breakpoint = ! empty( $settings['mobile_breakpoint'] ) ? (int) $settings['mobile_breakpoint'] : 800;

		// Output responsive breakpoint logic
		?>
		<style>
			@media (max-width: <?php echo $mobile_breakpoint; ?>px) {
				.elementor-element-<?php echo $id; ?> .lc-hf-nav-menu--main {
					display: none !important;
				}

				.elementor-element-<?php echo $id; ?> .lc-hf-menu-toggle {
					display: flex !important;
				}
			}

			@media (min-width: <?php echo $mobile_breakpoint + 1; ?>px) {
				.elementor-element-<?php echo $id; ?> .lc-hf-menu-toggle,
				.elementor-element-<?php echo $id; ?> .lc-hf-nav-menu--dropdown {
					display: none !important;
				}
			}
		</style>

		<?php if ( $layout !== 'dropdown' ) : ?>
			<nav class="lc-hf-nav-menu--main lc-hf-nav-menu__container lc-hf-nav-menu--layout-<?php echo esc_attr( $layout ); ?>">
				<?php echo LCAKE_Kit_Utils::kses( $menu_html ); ?>
			</nav>
		<?php endif; ?>

		<div class="lc-hf-menu-toggle" role="button" tabindex="0"
			aria-label="<?php echo esc_attr__( 'Toggle menu', 'lc-addons-kit-for-elementor' ); ?>" aria-expanded="false">
			<span class="lc-hf-menu-toggle-bar"></span>
			<span class="lc-hf-menu-toggle-bar"></span>
			<span class="lc-hf-menu-toggle-bar"></span>
		</div>

		<nav class="lc-hf-nav-menu--dropdown lc-hf-nav-menu__container" aria-hidden="true">
			<?php echo LCAKE_Kit_Utils::kses( $dropdown_menu_html ); ?>
		</nav>
		<?php
	}
}

if ( ! class_exists( 'LC_Header_Footer_Nav_Menu_Walker' ) ) {
	class LC_Header_Footer_Nav_Menu_Walker extends \Walker_Nav_Menu {

		public function start_lvl( &$output, $depth = 0, $args = null ) {
			$output .= '<ul class="sub-menu">';
		}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$has_children = in_array( 'menu-item-has-children', $item->classes, true );

			// Add elementor-like classes
			$item->classes[] = $depth ? 'lc-hf-sub-item' : 'lc-hf-item';
			if ( in_array( 'current-menu-item', $item->classes ) ) {
				$item->classes[] = 'lc-hf-item-active';
			}
			if ( false !== strpos( $item->url, '#' ) ) {
				$item->classes[] = 'lc-hf-item-anchor';
			}

			$classes = implode( ' ', array_filter( $item->classes ) );

			$output .= '<li class="' . esc_attr( $classes ) . ( $has_children ? ' lc-hf-has-submenu' : '' ) . '">';
			$output .= '<a href="' . esc_url( $item->url ) . '" class="lc-hf-item-link">';
			$output .= esc_html( $item->title );
			if ( $has_children ) {
				$output .= '<span class="sub-arrow"><i class="fas fa-chevron-down"></i></span>';
			}
			$output .= '</a>';
		}
	}
}
