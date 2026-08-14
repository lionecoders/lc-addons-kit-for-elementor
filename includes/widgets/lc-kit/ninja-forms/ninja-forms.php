<?php
/**
 * Ninja Forms Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ninja Forms Widget.
 *
 * Elementor widget that integrates with Ninja Forms.
 */
class LCAKE_Kit_Ninja_Forms extends \Elementor\Widget_Base {

	public function get_required_dependencies() {
		return array(
			array(
				'type'  => 'plugin',
				'class' => 'Ninja_Forms',
				'name'  => 'Ninja Forms',
			),
		);
	}

	public function get_name() {
		return 'lcake-kit-ninja-forms';
	}

	public function get_categories() {
		return array( 'lcake-page-kit' );
	}

	public function get_title() {
		return esc_html__( 'Ninja Forms', 'lc-addons-kit-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal lcake-mveous-badge';
	}

	public function get_style_depends() {
		return array( 'lcake-kit-ninja-forms-css' );
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
				'options' => LCAKE_Kit_Utils::lcake_get_ninja_form(),
				'default' => 0,
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'Ninja_Forms' ) ) {
			LCAKE_Kit_Utils::plugin_inactive_notice( 'Ninja Forms' );
			return;
		}

		$settings = $this->get_settings_for_display();

		if ( empty( $settings['form_id'] ) ) {
			return;
		}

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$form_title = 'Ninja Form';
			if ( function_exists( 'Ninja_Forms' ) ) {
				$form = Ninja_Forms()->form( $settings['form_id'] )->get();
				if ( $form ) {
					$form_title = $form->get_setting( 'title' );
				}
			}
			?>
			<div class="lcake-ninja-forms-placeholder" style="border: 2px dashed #3b82f6; padding: 30px; text-align: center; background: #f8fafc; border-radius: 8px;">
				<span class="dashicons dashicons-feedback" style="font-size: 36px; width: 36px; height: 36px; color: #3b82f6; margin-bottom: 12px; display: inline-block;"></span>
				<h4 style="margin: 0 0 6px; font-weight: 700; color: #1e293b; font-size: 16px;"><?php echo esc_html( $form_title ); ?></h4>
				<p style="margin: 0; font-size: 13px; color: #64748b;"><?php esc_html_e( 'Ninja Forms uses custom dynamic scripts and will display properly on your live site.', 'lc-addons-kit-for-elementor' ); ?></p>
			</div>
			<?php
			return;
		}
		?>
		<div class="lcake-ninja-forms">
			<?php echo do_shortcode( '[ninja_form id="' . (int) $settings['form_id'] . '"]' ); ?>
		</div>
		<?php
	}
}
