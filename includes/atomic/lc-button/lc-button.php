<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Inline_Editing_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Link_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Html_V3_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Link_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;
use Elementor\Modules\AtomicWidgets\Controls\Types\Svg_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Svg_Src_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LC_Button extends Atomic_Widget_Base {
    use Has_Template;

    public static function get_element_type(): string {
        return 'e-lc-button';
    }

    public function get_title() {
        return esc_html__( 'LC Button', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_keywords() {
        return [ 'button', 'link', 'cta', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-button' ];
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'text' => Html_V3_Prop_Type::make()
                ->default( [
                    'content'  => String_Prop_Type::generate( __( 'Learn more', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] )
                ->description( 'The text displayed on the button.' ),

            'link' => Link_Prop_Type::make(),

            'badge' => String_Prop_Type::make()
                ->default( '' )
                ->description( 'Optional badge text.' ),

            'icon_switch' => Boolean_Prop_Type::make()
                ->default( true )
                ->description( 'Add icon to the button.' ),

            'icon_position' => String_Prop_Type::make()
                ->enum( [ 'left', 'right' ] )
                ->default( 'left' )
                ->description( 'Icon position (before or after label).' ),

            'svg' => Svg_Src_Prop_Type::make()
                ->description( 'The SVG icon to display.' ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Inline_Editing_Control::bind_to( 'text' )
                        ->set_label( __( 'Label', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Learn more', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Link_Control::bind_to( 'link' )
                        ->set_label( __( 'URL', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'https://your-link.com', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'icon_switch' )
                        ->set_label( __( 'Add Icon?', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'svg' )
                        ->set_label( __( 'Icon (SVG)', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'icon_position' )
                        ->set_label( __( 'Icon Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'left', 'label' => __( 'Before', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'right', 'label' => __( 'After', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Text_Control::bind_to( 'badge' )
                        ->set_label( __( 'Badge', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Optional badge text', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic "alignment", "margin", "padding", typography, text-shadow, box-shadow,
        // and background colors were styled via selectors. In v4 these are handled by the Style Panel.
        // TODO(atomic): icon picker lcake_button_icon (icon) has no v4 control equivalent in 4.1.4.
    }

    protected function define_base_styles(): array {
        return [
            'base' => Style_Definition::make()
                ->add_variant(
                    Style_Variant::make()
                        ->add_prop( 'display', 'inline-block' )
                        ->add_prop( 'text-align', 'center' )
                ),
        ];
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-button' => __DIR__ . '/lc-button.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $text = wp_strip_all_tags( $settings['text'] ?? '' );
        if ( empty( $text ) ) { return ''; }

        if ( ! empty( $settings['link']['href'] ) ) {
            return '[' . $text . '](' . esc_url( $settings['link']['href'] ) . ')';
        }
        return '**' . $text . '**';
    }
}
