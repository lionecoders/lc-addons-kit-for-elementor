<?php
/**
 * Fluent Forms Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fluent Forms Widget.
 *
 * Elementor widget that integrates with Fluent Forms.
 */
class LCAKE_Kit_Fluent_Form extends \Elementor\Widget_Base {

	public function get_required_dependencies() {
		return array(
			array(
				'type'     => 'plugin',
				'constant' => 'FLUENTFORM',
				'name'     => 'Fluent Forms',
			),
		);
	}

	public function get_name() {
		return 'lcake-kit-fluent-form';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Fluent Forms', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-fluent-form-css' );
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
			'form_id',
			array(
				'label'   => esc_html__( 'Select Form', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => LCAKE_Kit_Utils::lcake_get_fluent_forms(),
				'default' => 0,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! defined( 'FLUENTFORM' ) ) {
			LCAKE_Kit_Utils::plugin_inactive_notice( 'Fluent Forms' );
			return;
		}

		$settings = $this->get_settings_for_display();

		if ( empty( $settings['form_id'] ) ) {
			return;
		}
		?>
		<div class="lcake-fluent-form">
			<?php echo do_shortcode( '[fluentform id="' . (int) $settings['form_id'] . '"]' ); ?>
		</div>
		<?php
	}
}
