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

class LC_Mailchimp extends Atomic_Widget_Base {
    use Has_Template;

    public static function get_element_type(): string {
        return 'e-lc-mailchimp';
    }

    public function get_title() {
        return esc_html__( 'LC MailChimp', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-mail';
    }

    public function get_keywords() {
        return [ 'mailchimp', 'email', 'newsletter', 'subscribe', 'form', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-atomic-mailchimp-css' ];
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'title' => String_Prop_Type::make()
                ->default( __( 'Subscribe to our newsletter', 'lc-addons-kit-for-elementor' ) ),

            'description' => String_Prop_Type::make()
                ->default( __( 'Get the latest news and updates delivered to your inbox.', 'lc-addons-kit-for-elementor' ) ),

            'api_key' => String_Prop_Type::make()->default( '' ),
            'list_id' => String_Prop_Type::make()->default( '' ),

            'email_placeholder' => String_Prop_Type::make()
                ->default( __( 'Enter your email address', 'lc-addons-kit-for-elementor' ) ),

            'button_text' => String_Prop_Type::make()
                ->default( __( 'Subscribe', 'lc-addons-kit-for-elementor' ) ),

            'show_name_field' => Boolean_Prop_Type::make()->default( false ),

            'name_placeholder' => String_Prop_Type::make()
                ->default( __( 'Enter your name', 'lc-addons-kit-for-elementor' ) ),

            'layout' => String_Prop_Type::make()
                ->enum( [ 'inline', 'stacked' ] )
                ->default( 'inline' ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Text_Control::bind_to( 'title' )
                        ->set_label( __( 'Title', 'lc-addons-kit-for-elementor' ) ),
                    Textarea_Control::bind_to( 'description' )
                        ->set_label( __( 'Description', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Text_Control::bind_to( 'api_key' )
                        ->set_label( __( 'MailChimp API Key', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Enter your MailChimp API key', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'list_id' )
                        ->set_label( __( 'Audience ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Enter your MailChimp Audience ID', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'email_placeholder' )
                        ->set_label( __( 'Email Placeholder', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'button_text' )
                        ->set_label( __( 'Button Text', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'show_name_field' )
                        ->set_label( __( 'Show Name Field', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'name_placeholder' )
                        ->set_label( __( 'Name Placeholder', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'layout' )
                        ->set_label( __( 'Layout', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'inline', 'label' => __( 'Inline', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'stacked', 'label' => __( 'Stacked', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic items-gap and form/title/description/input/button background,
        // border, radius, padding, margin, typography were styled via CSS selectors. In v4 these
        // are handled by the Style Panel; a modernized default look ships in lcake-atomic-mailchimp.css.
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
        $settings['nonce'] = wp_create_nonce( 'lcake_mailchimp_nonce' );
        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-mailchimp' => __DIR__ . '/lc-mailchimp.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        return wp_strip_all_tags( $settings['title'] ?? '' );
    }
}
