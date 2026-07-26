<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Inline_Editing_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Html_V3_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\AtomicWidgets\PropTypes\Color_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LC_Heading extends Atomic_Widget_Base {
    use Has_Template;

    public static function get_element_type(): string {
        return 'e-lc-heading';
    }

    public function get_title() {
        return esc_html__( 'LC Heading', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-t-letter';
    }

    public function get_keywords() {
        return [ 'heading', 'title', 'text', 'lc' ];
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'tag' => String_Prop_Type::make()
                ->enum( [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ] )
                ->default( 'h2' )
                ->description( 'The HTML tag for the heading.' ),

            'title' => Html_V3_Prop_Type::make()
                ->default( [
                    'content'  => String_Prop_Type::generate( __( 'Build Beautiful Experiences', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] )
                ->description( 'The heading text.' ),

            'gradient_effect' => Boolean_Prop_Type::make()
                ->default( true )
                ->description( 'Enable Gradient Text effect.' ),

            'gradient_color_left' => String_Prop_Type::make()
                ->default( '#4f46e5' )
                ->description( 'Gradient Left Color.' ),

            'gradient_color_right' => String_Prop_Type::make()
                ->default( '#ec4899' )
                ->description( 'Gradient Right Color.' ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Inline_Editing_Control::bind_to( 'title' )
                        ->set_label( __( 'Heading', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Enter your heading', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Select_Control::bind_to( 'tag' )
                        ->set_label( __( 'HTML Tag', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'h1', 'label' => 'H1' ],
                            [ 'value' => 'h2', 'label' => 'H2' ],
                            [ 'value' => 'h3', 'label' => 'H3' ],
                            [ 'value' => 'h4', 'label' => 'H4' ],
                            [ 'value' => 'h5', 'label' => 'H5' ],
                            [ 'value' => 'h6', 'label' => 'H6' ],
                            [ 'value' => 'div', 'label' => 'div' ],
                            [ 'value' => 'span', 'label' => 'span' ],
                            [ 'value' => 'p', 'label' => 'p' ],
                        ] ),
                    Switch_Control::bind_to( 'gradient_effect' )
                        ->set_label( __( 'Enable Gradient Text', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'gradient_color_left' )
                        ->set_label( __( 'Gradient Left Color (Hex)', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'gradient_color_right' )
                        ->set_label( __( 'Gradient Right Color (Hex)', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic "alignment", "text color", group typography, text-shadow and
        // margin controls used CSS `selectors`. In v4 those are handled by the Style panel /
        // base styles, not per-control selectors. Move essential defaults into define_base_styles().
        // TODO(atomic): lcake_heading_gradient_color_left and lcake_heading_gradient_color_right have no v4 color control equivalent in 4.1.4.
    }

    protected function define_base_styles(): array {
        $margin = Size_Prop_Type::generate( [ 'unit' => 'px', 'size' => 0 ] );

        return [
            'base' => Style_Definition::make()
                ->add_variant(
                    Style_Variant::make()
                        ->add_prop( 'margin', $margin )
                        ->add_prop( 'text-align', 'center' )
                ),
            'heading-base' => Style_Definition::make()
                ->add_variant(
                    Style_Variant::make()
                        ->add_prop( 'margin', Size_Prop_Type::generate( [ 'unit' => 'px', 'size' => 0 ] ) )
                        ->add_prop( 'padding', Size_Prop_Type::generate( [ 'unit' => 'px', 'size' => 0 ] ) )
                        ->add_prop( 'font-size', Size_Prop_Type::generate( [ 'unit' => 'px', 'size' => 48 ] ) )
                        ->add_prop( 'font-weight', '800' )
                        ->add_prop( 'line-height', '1.2' )
                        ->add_prop( 'letter-spacing', '-0.02em' )
                        ->add_prop( 'color', Color_Prop_Type::generate( '#111827' ) )
                        ->add_prop( 'display', 'inline-block' )
                ),
        ];
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-heading' => __DIR__ . '/lc-heading.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $title = wp_strip_all_tags( $settings['title'] ?? '' );
        if ( empty( $title ) ) { return ''; }
        $tag = $settings['tag'] ?? 'h2';
        $level = [ 'h1'=>1,'h2'=>2,'h3'=>3,'h4'=>4,'h5'=>5,'h6'=>6 ][ $tag ] ?? 2;
        return str_repeat( '#', $level ) . ' ' . $title;
    }
}
