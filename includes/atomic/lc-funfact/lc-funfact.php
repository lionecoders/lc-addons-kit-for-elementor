<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Image_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Svg_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Image_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Number_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Svg_Src_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classic Font-Awesome icon picker has no v4 equivalent — icons use the SVG control instead.
 * The classic "View" (Default/Stacked/Framed) select was dead code (unused in render()) and
 * is dropped.
 */
class LC_Funfact extends Atomic_Widget_Base {
    use Has_Template;

    public static function get_element_type(): string {
        return 'e-lc-funfact';
    }

    public function get_title() {
        return esc_html__( 'LC Funfact', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-number-field';
    }

    public function get_keywords() {
        return [ 'funfact', 'counter', 'statistics', 'number', 'animation', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lcake-kit-funfact-js' ];
    }

    public function get_style_depends() {
        $deps = [];
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
            $deps[] = 'odometer';
        }
        return $deps;
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'icon_type' => String_Prop_Type::make()
                ->enum( [ 'icon', 'image_icon', 'none' ] )
                ->default( 'icon' ),
            'icon_switch' => Boolean_Prop_Type::make()->default( true ),
            'icon' => Svg_Src_Prop_Type::make(),
            'icon_image' => Image_Prop_Type::make()->default_size( 'thumbnail' ),

            'number_prefix' => String_Prop_Type::make()->default( '' ),
            'number' => Number_Prop_Type::make()->default( 254 ),
            'number_suffix' => String_Prop_Type::make()->default( 'M' ),

            'title_text' => String_Prop_Type::make()
                ->default( __( 'This is the heading', 'lc-addons-kit-for-elementor' ) ),

            'super_enable' => Boolean_Prop_Type::make()->default( false ),
            'super_text' => String_Prop_Type::make()->default( '+' ),

            'style' => String_Prop_Type::make()
                ->enum( [ 'static', 'sliding' ] )
                ->default( 'static' ),
            'animation_duration' => Number_Prop_Type::make()->default( 3500 ),

            'icon_position' => String_Prop_Type::make()
                ->enum( [ 'position_top', 'position_left', 'position_right' ] )
                ->default( 'position_top' ),

            'title_size' => String_Prop_Type::make()
                ->enum( [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ] )
                ->default( 'h3' ),

            'hover_border_bottom' => Boolean_Prop_Type::make()->default( false ),
            'hover_border_bottom_direction' => String_Prop_Type::make()
                ->enum( [ 'hover_from_left', 'hover_from_right' ] )
                ->default( 'hover_from_right' ),

            'enable_vertical_border' => Boolean_Prop_Type::make()->default( false ),
            'vertical_border_position' => String_Prop_Type::make()
                ->enum( [ 'border_left_side', 'border_right_side' ] )
                ->default( 'border_right_side' ),

            'show_overlay' => Boolean_Prop_Type::make()->default( false ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        return [
            Section::make()
                ->set_label( __( 'Icon', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Select_Control::bind_to( 'icon_type' )
                        ->set_label( __( 'Icon Type', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'icon', 'label' => __( 'Icon', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'image_icon', 'label' => __( 'Image', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'none', 'label' => __( 'None', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'icon_switch' )
                        ->set_label( __( 'Enable Icon', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'icon' )
                        ->set_label( __( 'Icon', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( 'icon_image' )
                        ->set_label( __( 'Choose Image', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'content' )
                ->set_items( [
                    Text_Control::bind_to( 'number_prefix' )
                        ->set_label( __( 'Number Prefix', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( '$' ),
                    Number_Control::bind_to( 'number' )
                        ->set_label( __( 'Number Count', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'number_suffix' )
                        ->set_label( __( 'Number Suffix', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( 'M+' ),
                    Text_Control::bind_to( 'title_text' )
                        ->set_label( __( 'Title', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'super_enable' )
                        ->set_label( __( 'Enable Super Text', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'super_text' )
                        ->set_label( __( 'Super Text', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( '+' ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Select_Control::bind_to( 'style' )
                        ->set_label( __( 'Animation Style', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'static', 'label' => __( 'Static', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'sliding', 'label' => __( 'Sliding', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Number_Control::bind_to( 'animation_duration' )
                        ->set_label( __( 'Animation Duration (ms)', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 500 )->set_max( 5000 )->set_step( 100 ),
                    Select_Control::bind_to( 'icon_position' )
                        ->set_label( __( 'Icon Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'position_top', 'label' => __( 'Top', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'position_left', 'label' => __( 'Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'position_right', 'label' => __( 'Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Select_Control::bind_to( 'title_size' )
                        ->set_label( __( 'Title HTML Tag', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'h1', 'label' => 'H1' ], [ 'value' => 'h2', 'label' => 'H2' ],
                            [ 'value' => 'h3', 'label' => 'H3' ], [ 'value' => 'h4', 'label' => 'H4' ],
                            [ 'value' => 'h5', 'label' => 'H5' ], [ 'value' => 'h6', 'label' => 'H6' ],
                            [ 'value' => 'div', 'label' => 'div' ], [ 'value' => 'span', 'label' => 'span' ],
                            [ 'value' => 'p', 'label' => 'p' ],
                        ] ),
                    Switch_Control::bind_to( 'hover_border_bottom' )
                        ->set_label( __( 'Enable Bottom Hover Border', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'hover_border_bottom_direction' )
                        ->set_label( __( 'Hover Direction', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'hover_from_left', 'label' => __( 'From Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'hover_from_right', 'label' => __( 'From Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'enable_vertical_border' )
                        ->set_label( __( 'Enable Vertical Divider', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'vertical_border_position' )
                        ->set_label( __( 'Divider Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'border_left_side', 'label' => __( 'From Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'border_right_side', 'label' => __( 'From Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'show_overlay' )
                        ->set_label( __( 'Enable Overlay', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic icon/number/title/super colors, typography, sizes, spacing,
        // background, border, radius, shadow, overlay color, and divider width/height/background
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
        $s = parent::get_atomic_settings();

        $classes = [ 'lcake-funfact', 'text-center' ];
        if ( ! empty( $s['hover_border_bottom'] ) ) {
            $classes[] = 'style-border-bottom';
            $classes[] = $s['hover_border_bottom_direction'] ?? '';
        }
        if ( ! empty( $s['enable_vertical_border'] ) ) {
            $classes[] = 'divider_funfact';
            $classes[] = $s['vertical_border_position'] ?? '';
        }
        $s['wrapper_class'] = implode( ' ', array_filter( $classes ) );

        $s['icon_image_src'] = $s['icon_image']['src'] ?? '';
        $s['icon_image_alt'] = $s['icon_image']['alt'] ?? '';

        $valid_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ];
        $s['title_tag'] = in_array( $s['title_size'] ?? 'h3', $valid_tags, true ) ? $s['title_size'] : 'h3';

        return $s;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-funfact' => __DIR__ . '/lc-funfact.html.twig',
        ];
    }

    public function render_markdown(): string {
        $s = $this->get_atomic_settings();
        $number = trim( ( $s['number_prefix'] ?? '' ) . ( $s['number'] ?? '' ) . ( $s['number_suffix'] ?? '' ) );
        return trim( $number . ' ' . ( $s['title_text'] ?? '' ) );
    }
}
