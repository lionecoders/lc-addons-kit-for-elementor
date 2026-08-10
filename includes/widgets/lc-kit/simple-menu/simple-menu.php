<?php
/**
 * Simple Menu Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LCAKE_Kit_Simple_Menu extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-simple-menu';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Simple Menu', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-simple-menu-css' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'menu_text',
			array(
				'label'       => esc_html__( 'Text', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Menu Item', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'menu_link',
			array(
				'label'       => esc_html__( 'Link', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lc-addons-kit-for-elementor' ),
				'default'     => array( 'url' => '#' ),
			)
		);

		$this->add_control(
			'menu_items',
			array(
				'label'       => esc_html__( 'Menu Items', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'menu_text' => esc_html__( 'Home', 'lc-addons-kit-for-elementor' ) ),
					array( 'menu_text' => esc_html__( 'About', 'lc-addons-kit-for-elementor' ) ),
					array( 'menu_text' => esc_html__( 'Services', 'lc-addons-kit-for-elementor' ) ),
					array( 'menu_text' => esc_html__( 'Contact', 'lc-addons-kit-for-elementor' ) ),
				),
				'title_field' => '{{{ menu_text }}}',
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
					'dropdown'   => esc_html__( 'Dropdown Toggle', 'lc-addons-kit-for-elementor' ),
				),
				'prefix_class' => 'lcake-simple-menu--',
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'        => esc_html__( 'Alignment', 'lc-addons-kit-for-elementor' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => array(
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
				'default'      => 'left',
				'prefix_class' => 'lcake-simple-menu-align%s--',
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
			'item_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lcake-simple-menu-item a' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'item_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-simple-menu-item a:hover' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'item_hover_underline',
			array(
				'label'     => esc_html__( 'Hover Underline', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'      => esc_html__( 'Hide', 'lc-addons-kit-for-elementor' ),
					'underline' => esc_html__( 'Show', 'lc-addons-kit-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-simple-menu-item a:hover' => 'text-decoration: {{VALUE}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 80,
					),
				),
				'default'   => array(
					'size' => 30,
					'unit' => 'px',
				),
				'selectors' => array( '{{WRAPPER}} .lcake-simple-menu' => 'gap: {{SIZE}}{{UNIT}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .lcake-simple-menu-item a',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $settings['menu_items'] ?? array();

		if ( empty( $items ) ) {
			return;
		}
		$layout    = $settings['layout'] ?? 'horizontal';
		$widget_id = $this->get_id();
		?>
		<nav class="lcake-simple-menu-wrapper">
			<?php if ( 'dropdown' === $layout ) : ?>
				<input type="checkbox" id="lcake-menu-toggle-<?php echo esc_attr( $widget_id ); ?>" class="lcake-simple-menu-toggle-checkbox" style="display: none;">
				<label for="lcake-menu-toggle-<?php echo esc_attr( $widget_id ); ?>" class="lcake-simple-menu-toggle-btn">
					<span class="lcake-simple-menu-toggle-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
					<span class="lcake-simple-menu-toggle-text"><?php echo esc_html__( 'Menu', 'lc-addons-kit-for-elementor' ); ?></span>
				</label>
			<?php endif; ?>
			<ul class="lcake-simple-menu">
				<?php
				foreach ( $items as $item ) :
					$link = $item['menu_link'] ?? array();
					?>
					<li class="lcake-simple-menu-item">
						<a href="<?php echo ! empty( $link['url'] ) ? esc_url( $link['url'] ) : '#'; ?>"
							<?php echo ! empty( $link['is_external'] ) ? 'target="_blank"' : ''; ?>
							<?php echo ! empty( $link['nofollow'] ) ? 'rel="nofollow"' : ''; ?>>
							<?php echo esc_html( $item['menu_text'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?php
	}
}
