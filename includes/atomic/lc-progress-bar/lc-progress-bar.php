<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Inline_Editing_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Svg_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Html_V3_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Number_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Svg_Src_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LC_Progress_Bar extends Atomic_Widget_Base {
    use Has_Template;

    const STYLES = [
        '' => 'Default',
        'inner-content skill-big' => 'Inner Content',
        'skilltrack-style2' => 'Track Shadow',
        'tooltip-style3' => 'Tooltip (Classic)',
        'tooltip-style2' => 'Tooltip (Boxed)',
        'tooltip-style' => 'Tooltip (Rounded)',
        'pin-style' => 'Tooltip (Pin)',
        'style-switch' => 'Switch',
        'style-ribbon' => 'Ribbon',
        'style-stripe skill-medium tooltip-style' => 'Striped',
    ];

    public static function get_element_type(): string {
        return 'e-lc-progress-bar';
    }

    public function get_title() {
        return esc_html__( 'LC Progress Bar', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-skill-bar';
    }

    public function get_keywords() {
        return [ 'progress', 'bar', 'skill', 'percentage', 'meter', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lcake-kit-progress-bar-js' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-progress-bar-css' ];
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'style' => String_Prop_Type::make()
                ->enum( array_keys( self::STYLES ) )
                ->default( '' )
                ->description( 'The visual style of the progress bar.' ),

            'title' => Html_V3_Prop_Type::make()
                ->default( [
                    'content' => String_Prop_Type::generate( __( 'WordPress', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] )
                ->description( 'The label above the bar.' ),

            'percentage' => Number_Prop_Type::make()
                ->default( 90 )
                ->description( 'The progress percentage (1-100).' ),

            'hide_percentage' => Boolean_Prop_Type::make()
                ->default( false )
                ->description( 'Hide the percentage number.' ),

            'animation_duration' => Number_Prop_Type::make()
                ->default( 3500 )
                ->description( 'The animation duration in milliseconds.' ),

            'svg' => Svg_Src_Prop_Type::make()
                ->description( 'Icon shown for the "Inner Content" style.' ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        $style_options = [];
        foreach ( self::STYLES as $value => $label ) {
            $style_options[] = [ 'value' => $value, 'label' => __( $label, 'lc-addons-kit-for-elementor' ) ];
        }

        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Inline_Editing_Control::bind_to( 'title' )
                        ->set_label( __( 'Title', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'WordPress', 'lc-addons-kit-for-elementor' ) ),
                    Number_Control::bind_to( 'percentage' )
                        ->set_label( __( 'Percentage', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 1 )
                        ->set_max( 100 )
                        ->set_step( 1 ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Select_Control::bind_to( 'style' )
                        ->set_label( __( 'Style', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( $style_options ),
                    Svg_Control::bind_to( 'svg' )
                        ->set_label( __( 'Icon (SVG, "Inner Content" style)', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'hide_percentage' )
                        ->set_label( __( 'Hide Percentage Number?', 'lc-addons-kit-for-elementor' ) ),
                    Number_Control::bind_to( 'animation_duration' )
                        ->set_label( __( 'Animation Duration (ms)', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 100 )
                        ->set_max( 10000 )
                        ->set_step( 5 ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic bar/track background, height, box-shadow, border-radius, padding,
        // margin, title/percent typography+color+text-shadow and icon color/size were styled via
        // CSS selectors. In v4 these are handled by the Style Panel.
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

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-progress-bar' => __DIR__ . '/lc-progress-bar.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $title = wp_strip_all_tags( $settings['title'] ?? '' );
        $percentage = $settings['percentage'] ?? 0;
        return trim( $title . ': ' . $percentage . '%' );
    }
}
