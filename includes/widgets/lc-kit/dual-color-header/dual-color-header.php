<?php
/**
 * Dual Color Header Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dual Color Heading Widget.
 *
 * Elementor widget that displays a Dual Color Heading.
 */
class LCAKE_Kit_Dual_Color_Header extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-dual-color-header';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Dual Color Heading', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-t-letter lcake-mveous-badge';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-dual-color-header-css' );
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
			'text_part_one',
			array(
				'label'       => esc_html__( 'First Text', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Build Beautiful', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'text_part_two',
			array(
				'label'       => esc_html__( 'Second Text', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Websites', 'lc-addons-kit-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'html_tag',
			array(
				'label'   => esc_html__( 'HTML Tag', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'div'  => 'div',
					'span' => 'span',
				),
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'     => esc_html__( 'Alignment', 'lc-addons-kit-for-elementor' ),
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
				'default'   => 'left',
				'selectors' => array( '{{WRAPPER}} .lcake-dual-color-header' => 'text-align: {{VALUE}};' ),
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
			'color_one',
			array(
				'label'     => esc_html__( 'First Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lcake-dual-color-header-part-one' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'color_two',
			array(
				'label'     => esc_html__( 'Second Text Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#3b82f6',
				'selectors' => array( '{{WRAPPER}} .lcake-dual-color-header-part-two' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .lcake-dual-color-header',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$valid_tags = array( 'h1', 'h2', 'h3', 'h4', 'div', 'span' );
		$tag        = in_array( $settings['html_tag'], $valid_tags, true ) ? $settings['html_tag'] : 'h2';
		?>
		<<?php echo tag_escape( $tag ); ?> class="lcake-dual-color-header">
			<span class="lcake-dual-color-header-part-one"><?php echo esc_html( $settings['text_part_one'] ); ?></span>
			<span class="lcake-dual-color-header-part-two"><?php echo esc_html( $settings['text_part_two'] ); ?></span>
		</<?php echo tag_escape( $tag ); ?>>
		<?php
	}
}
