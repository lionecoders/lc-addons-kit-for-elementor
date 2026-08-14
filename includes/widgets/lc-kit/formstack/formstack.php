<?php
/**
 * Formstack Embed Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Formstack Widget.
 *
 * Elementor widget that integrates with Formstack.
 */
class LCAKE_Kit_Formstack extends \Elementor\Widget_Base {

	public function get_name() {
		return 'lcake-kit-formstack';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Formstack', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal lcake-mveous-badge';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-formstack-css' );
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
			'view_key',
			array(
				'label'       => esc_html__( 'Form View Key', 'lc-addons-kit-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Find this in your Formstack form\'s embed code.', 'lc-addons-kit-for-elementor' ),
				'placeholder' => 'e.g. AbCdEf',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$view_key = sanitize_text_field( $settings['view_key'] ?? '' );

		if ( empty( $view_key ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				echo '<p class="lcake-plugin-notice">' . esc_html__( 'Please enter a Formstack Form View Key.', 'lc-addons-kit-for-elementor' ) . '</p>';
			}
			return;
		}
		?>
		<div class="lcake-formstack" data-view-key="<?php echo esc_attr( $view_key ); ?>">
			<iframe class="lcake-formstack-iframe" title="<?php echo esc_attr__( 'Formstack form', 'lc-addons-kit-for-elementor' ); ?>"
					src="https://www.formstack.com/forms/embed.php?id=<?php echo esc_attr( $view_key ); ?>"
					loading="lazy"></iframe>
		</div>
		<?php
	}
}
