<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Textarea_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LC_Contact_Form_7 extends Atomic_Widget_Base {
    use Has_Template;

    public static function get_element_type(): string {
        return 'e-lc-contact-form-7';
    }

    public function get_title() {
        return esc_html__( 'LC Contact Form 7', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_keywords() {
        return [ 'contact', 'form', 'cf7', 'contact form 7', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-atomic-contact-form-7-css' ];
    }

    private static function get_forms(): array {
        $forms = [];

        if ( class_exists( 'WPCF7_ContactForm' ) ) {
            $cf7_forms = get_posts( [
                'post_type' => 'wpcf7_contact_form',
                'numberposts' => -1,
            ] );

            foreach ( $cf7_forms as $form ) {
                $forms[ (string) $form->ID ] = $form->post_title;
            }
        }

        if ( empty( $forms ) ) {
            $forms[''] = __( 'No forms found', 'lc-addons-kit-for-elementor' );
        }

        return $forms;
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'form_id' => String_Prop_Type::make()->default( '' ),

            'show_form_title' => Boolean_Prop_Type::make()->default( true ),

            'form_title' => String_Prop_Type::make()
                ->default( __( 'Contact Us', 'lc-addons-kit-for-elementor' ) ),

            'show_form_description' => Boolean_Prop_Type::make()->default( true ),

            'form_description' => String_Prop_Type::make()
                ->default( __( 'We would love to hear from you. Please fill out the form below.', 'lc-addons-kit-for-elementor' ) ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        $form_options = [];
        foreach ( self::get_forms() as $value => $label ) {
            $form_options[] = [ 'value' => $value, 'label' => $label ];
        }

        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Select_Control::bind_to( 'form_id' )
                        ->set_label( __( 'Select Form', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( $form_options ),
                    Switch_Control::bind_to( 'show_form_title' )
                        ->set_label( __( 'Show Form Title', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'form_title' )
                        ->set_label( __( 'Form Title', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'show_form_description' )
                        ->set_label( __( 'Show Form Description', 'lc-addons-kit-for-elementor' ) ),
                    Textarea_Control::bind_to( 'form_description' )
                        ->set_label( __( 'Form Description', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic form/title/description/input/button background, border, radius,
        // padding, margin, typography were styled via CSS selectors. In v4 these are handled by
        // the Style Panel; a modernized default look ships in lcake-atomic-contact-form-7.css.
    }

    protected function define_base_styles(): array {
        return [
            'base' => Style_Definition::make()
                ->add_variant(
                    Style_Variant::make()
                        ->add_prop( 'display', 'block' )
                ),
        ];
    }

    public function get_atomic_settings(): array {
        $settings = parent::get_atomic_settings();

        $settings['rendered_form'] = '';
        $settings['error_text'] = '';

        if ( empty( $settings['form_id'] ) ) {
            $settings['error_text'] = __( 'Please select a Contact Form 7 form.', 'lc-addons-kit-for-elementor' );
        } elseif ( ! function_exists( 'wpcf7_contact_form' ) ) {
            $settings['error_text'] = __( 'Contact Form 7 plugin is not installed or activated.', 'lc-addons-kit-for-elementor' );
        } else {
            $settings['rendered_form'] = do_shortcode( '[contact-form-7 id="' . esc_attr( $settings['form_id'] ) . '"]' );
        }

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-contact-form-7' => __DIR__ . '/lc-contact-form-7.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        if ( empty( $settings['form_id'] ) ) {
            return '';
        }
        return wp_strip_all_tags( $settings['form_title'] ?? __( 'Contact Form', 'lc-addons-kit-for-elementor' ) );
    }
}
