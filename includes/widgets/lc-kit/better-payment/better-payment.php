<?php
/**
 * Better Payment Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Better Payment Widget.
 *
 * Elementor widget that displays a Better Payment.
 */
class LCAKE_Kit_Better_Payment extends \Elementor\Widget_Base {

	public function get_required_dependencies() {
		return array(
			array(
				'type'  => 'plugin',
				'class' => 'Better_Payment',
				'name'  => 'Better Payment',
			),
		);
	}

	public function get_name() {
		return 'lcake-kit-better-payment';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Better Payment', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-paypal-button lcake-mveous-badge';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-better-payment-css' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lc-addons-kit-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$options = array( 0 => esc_html__( 'Select Payment Form', 'lc-addons-kit-for-elementor' ) );
		if ( class_exists( 'Better_Payment' ) || post_type_exists( 'better-payment' ) ) {
			$forms = get_posts(
				array(
					'post_type'      => 'better-payment',
					'posts_per_page' => 200,
				)
			);
			foreach ( $forms as $form ) {
				$options[ $form->ID ] = $form->post_title;
			}
		}

		$this->add_control(
			'form_id',
			array(
				'label'   => esc_html__( 'Payment Form', 'lc-addons-kit-for-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $options,
				'default' => 0,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'Better_Payment' ) && ! post_type_exists( 'better-payment' ) ) {
			LCAKE_Kit_Utils::plugin_inactive_notice( 'Better Payment' );
			return;
		}

		$settings = $this->get_settings_for_display();

		if ( empty( $settings['form_id'] ) ) {
			return;
		}
		?>
		<div class="lcake-better-payment">
			<?php echo do_shortcode( '[better_payment id="' . (int) $settings['form_id'] . '"]' ); ?>
		</div>
		<?php
	}
}
