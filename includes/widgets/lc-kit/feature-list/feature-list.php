<?php
/**
 * Feature List Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Feature List Widget.
 *
 * Elementor widget that displays a Feature List.
 */
class LCAKE_Kit_Feature_List extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-feature-list';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Feature List', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-feature-list-css' );
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
			'item_icon',
			array(
				'label'   => esc_html__( 'Icon', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
			)
		);

		$repeater->add_control(
			'item_text',
			array(
				'label'       => esc_html__( 'Text', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'List Item', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'item_link',
			array(
				'label'       => esc_html__( 'Link', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lc-addons-kit-for-elementor' ),
				'default'     => array( 'url' => '' ),
			)
		);

		$this->add_control(
			'list_items',
			array(
				'label'       => esc_html__( 'Items', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'item_text' => esc_html__( 'Fully Responsive Design', 'lc-addons-kit-for-elementor' ) ),
					array( 'item_text' => esc_html__( 'Cross Browser Compatible', 'lc-addons-kit-for-elementor' ) ),
					array( 'item_text' => esc_html__( 'Retina Ready', 'lc-addons-kit-for-elementor' ) ),
				),
				'title_field' => '{{{ item_text }}}',
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'     => esc_html__( 'Columns', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-feature-list' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_list',
			array(
				'label' => esc_html__( 'List', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array(
					'{{WRAPPER}} .lcake-feature-list-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .lcake-feature-list-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_background',
			array(
				'label'     => esc_html__( 'Icon Background', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(59, 130, 246, 0.1)',
				'selectors' => array(
					'{{WRAPPER}} .lcake-feature-list-icon' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 8,
						'max' => 40,
					),
				),
				'default'   => array(
					'size' => 14,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-feature-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lcake-feature-list-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_padding',
			array(
				'label'     => esc_html__( 'Icon Padding', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'   => array(
					'size' => 7,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-feature-list-icon' => 'padding: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_spacing',
			array(
				'label'     => esc_html__( 'Icon Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'   => array(
					'size' => 12,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-feature-list-link' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lcake-feature-list-text' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .lcake-feature-list-text',
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'     => esc_html__( 'Vertical Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'   => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-feature-list' => 'row-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'horizontal_spacing',
			array(
				'label'     => esc_html__( 'Horizontal Spacing', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'   => array(
					'size' => 24,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lcake-feature-list' => 'column-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $settings['list_items'] ?? array();

		if ( empty( $items ) ) {
			return;
		}
		?>
		<ul class="lcake-feature-list">
			<?php
			foreach ( $items as $item ) :
				$link       = $item['item_link'] ?? array();
				$tag        = ! empty( $link['url'] ) ? 'a' : 'div';
				$link_attrs = '';
				if ( 'a' === $tag ) {
					$link_attrs  = 'href="' . esc_url( $link['url'] ) . '"';
					$link_attrs .= ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
					$link_attrs .= ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
				}
				?>
				<li class="lcake-feature-list-item">
					<<?php echo tag_escape( $tag ); ?> class="lcake-feature-list-link" <?php echo $link_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $link_attrs is built with esc_url() and hardcoded safe attribute strings. ?>>
						<span class="lcake-feature-list-icon">
							<?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], array( 'aria-hidden' => 'true' ) ); ?>
						</span>
						<span class="lcake-feature-list-text"><?php echo esc_html( $item['item_text'] ); ?></span>
					</<?php echo tag_escape( $tag ); ?>>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}
