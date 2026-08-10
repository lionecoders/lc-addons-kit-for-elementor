<?php
/**
 * Site Title Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Site Title Widget.
 *
 * Elementor widget that displays a Site Title.
 */
class LC_Header_Footer_Site_Title extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lc-header-footer-site-title';
	}

	public function get_title() {
		return esc_html__( 'Site Title', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-site-title';
	}

	public function get_categories() {
		return array( 'lc-header-footer-kit' );
	}

	public function get_style_depends() {
		return array( 'lc-header-footer-site-title-css' );
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
			'show_tagline',
			array(
				'label'   => esc_html__( 'Show Tagline', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'link_to_home',
			array(
				'label'   => esc_html__( 'Link to Home', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
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
					'div'  => 'div',
					'span' => 'span',
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
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => array( '{{WRAPPER}} .lc-hf-site-title' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .lc-hf-site-title',
			)
		);

		$this->add_control(
			'tagline_color',
			array(
				'label'     => esc_html__( 'Tagline Color', 'lc-addons-kit-for-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6b7280',
				'condition' => array( 'show_tagline' => 'yes' ),
				'selectors' => array( '{{WRAPPER}} .lc-hf-site-tagline' => 'color: {{VALUE}};' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'tagline_typography',
				'condition' => array( 'show_tagline' => 'yes' ),
				'selector'  => '{{WRAPPER}} .lc-hf-site-tagline',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$valid_tags = array( 'h1', 'h2', 'h3', 'div', 'span' );
		$tag        = in_array( $settings['html_tag'], $valid_tags, true ) ? $settings['html_tag'] : 'h2';
		$site_name  = get_bloginfo( 'name' );
		$has_link   = 'yes' === $settings['link_to_home'];
		?>
		<div class="lc-hf-site-title-wrap">
			<<?php echo $tag; ?> class="lc-hf-site-title">
				<?php if ( $has_link ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $site_name ); ?></a>
				<?php else : ?>
					<?php echo esc_html( $site_name ); ?>
				<?php endif; ?>
			</<?php echo $tag; ?>>
			<?php if ( 'yes' === $settings['show_tagline'] ) : ?>
				<p class="lc-hf-site-tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
			<?php endif; ?>
		</div>
		<?php
	}
}
