<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Inline_Editing_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Html_V3_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LC_Drop_Caps extends Atomic_Widget_Base {
    use Has_Template;

    public static function get_element_type(): string {
        return 'e-lc-drop-caps';
    }

    public function get_title() {
        return esc_html__( 'LC Drop Caps', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-text';
    }

    public function get_keywords() {
        return [ 'drop', 'caps', 'text', 'typography', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-drop-caps-css' ];
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'text' => Html_V3_Prop_Type::make()
                ->default( [
                    'content'  => String_Prop_Type::generate( __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] )
                ->description( 'The main body of text.' ),

            'drop_cap_letter' => String_Prop_Type::make()
                ->default( '' )
                ->description( 'The letter to be displayed as a drop cap. If left empty, the first letter of the text is used.' ),

            'drop_cap_position' => String_Prop_Type::make()
                ->enum( [ 'left', 'right' ] )
                ->default( 'left' )
                ->description( 'The position of the drop cap letter.' ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Inline_Editing_Control::bind_to( 'text' )
                        ->set_label( __( 'Text', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Enter your text here...', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Text_Control::bind_to( 'drop_cap_letter' )
                        ->set_label( __( 'Drop Cap Letter', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Enter the letter for drop cap', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'drop_cap_position' )
                        ->set_label( __( 'Drop Cap Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'left', 'label' => __( 'Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'right', 'label' => __( 'Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic text styling (color, typography, alignment, margin) and
        // drop cap styling (color, background, size, line height, border, radius, padding, margin, shadow)
        // were styled via CSS selectors. In v4 these are handled by the Style Panel.
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

        $text = $settings['text'] ?? '';
        $drop_cap_letter = $settings['drop_cap_letter'] ?? '';

        if ( empty( $drop_cap_letter ) && ! empty( $text ) ) {
            $clean_text = trim( strip_tags( $text ) );
            $drop_cap_letter = mb_substr( $clean_text, 0, 1, 'UTF-8' );
        }

        if ( ! empty( $drop_cap_letter ) ) {
            $escaped_letter = preg_quote( $drop_cap_letter, '/' );
            $text = preg_replace( '/(^|>)([^<]*?)' . $escaped_letter . '/u', '$1$2', $text, 1 );
        }

        $settings['processed_drop_cap_letter'] = $drop_cap_letter;
        $settings['processed_text'] = $text;

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-drop-caps' => __DIR__ . '/lc-drop-caps.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $letter = $settings['processed_drop_cap_letter'] ?? '';
        $text = wp_strip_all_tags( $settings['processed_text'] ?? '' );
        return $letter . $text;
    }
}
