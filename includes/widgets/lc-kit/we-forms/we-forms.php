<?php
/**
 * weForms Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LCAKE_Kit_We_Forms extends \Elementor\Widget_Base {

	public function get_required_dependencies() {
		return array(
			array(
				'type'  => 'plugin',
				'class' => 'WeForms',
				'name'  => 'weForms',
			),
		);
	}

	public function get_name() {
		return 'lcake-kit-we-forms';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'weForms', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-we-forms-css' );
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
				'options' => LCAKE_Kit_Utils::lcake_get_weforms(),
				'default' => 0,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WeForms' ) ) {
			LCAKE_Kit_Utils::plugin_inactive_notice( 'weForms' );
			return;
		}

		$settings = $this->get_settings_for_display();

		if ( empty( $settings['form_id'] ) ) {
			return;
		}
		?>
		<div class="lcake-we-forms">
			<?php echo do_shortcode( '[weforms id="' . (int) $settings['form_id'] . '"]' ); ?>
		</div>
		<?php
	}
}
