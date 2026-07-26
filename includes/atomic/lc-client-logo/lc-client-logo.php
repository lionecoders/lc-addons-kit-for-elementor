<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Image_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Link_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Svg_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Image_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Link_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Number_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Svg_Src_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classic widget used an unlimited Elementor Repeater (name/logo/hover-logo/link). Atomic
 * Repeatable_Control can't render multi-field rows, so logos are exposed as fixed,
 * individually toggleable slots (see LC_Business_Hours for the same pattern). The classic
 * Font-Awesome arrow icons have no v4 equivalent — icons use the SVG control instead.
 */
class LC_Client_Logo extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_LOGOS = 8;
    const DEFAULT_COUNT = 5;

    public static function get_element_type(): string {
        return 'e-lc-client-logo';
    }

    public function get_title() {
        return esc_html__( 'LC Client Logo', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-carousel';
    }

    public function get_keywords() {
        return [ 'client', 'logo', 'brand', 'carousel', 'slider', 'partners', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lcake-kit-client-logo', 'lcake-swiper-js' ];
    }

    public function get_style_depends() {
        return [ 'lcake-swiper-css', 'lcake-kit-client-logo' ];
    }

    protected static function define_props_schema(): array {
        $schema = [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'slide_style' => String_Prop_Type::make()
                ->enum( [ 'simple_logo_image', 'banner_logo_image' ] )
                ->default( 'simple_logo_image' ),
        ];

        for ( $i = 1; $i <= self::MAX_LOGOS; $i++ ) {
            $schema[ "enabled_{$i}" ] = Boolean_Prop_Type::make()->default( $i <= self::DEFAULT_COUNT );
            $schema[ "name_{$i}" ] = String_Prop_Type::make()->default( sprintf( __( 'Title #%d', 'lc-addons-kit-for-elementor' ), $i ) );
            $schema[ "logo_{$i}" ] = Image_Prop_Type::make()->default_size( 'full' );
            $schema[ "hover_enabled_{$i}" ] = Boolean_Prop_Type::make()->default( false );
            $schema[ "hover_logo_{$i}" ] = Image_Prop_Type::make()->default_size( 'full' );
            $schema[ "link_enabled_{$i}" ] = Boolean_Prop_Type::make()->default( false );
            $schema[ "link_{$i}" ] = Link_Prop_Type::make();
        }

        $schema['spacing'] = Number_Prop_Type::make()->default( 15 );
        $schema['slides_to_show'] = Number_Prop_Type::make()->default( 4 );
        $schema['slides_to_scroll'] = Number_Prop_Type::make()->default( 1 );
        $schema['autoplay'] = Boolean_Prop_Type::make()->default( true );
        $schema['speed'] = Number_Prop_Type::make()->default( 1000 );
        $schema['pause_on_hover'] = Boolean_Prop_Type::make()->default( true );
        $schema['show_arrow'] = Boolean_Prop_Type::make()->default( false );
        $schema['left_arrow'] = Svg_Src_Prop_Type::make();
        $schema['right_arrow'] = Svg_Src_Prop_Type::make();
        $schema['loop'] = Boolean_Prop_Type::make()->default( false );
        $schema['show_dot'] = Boolean_Prop_Type::make()->default( false );
        $schema['rows'] = String_Prop_Type::make()->enum( [ '1', '2', '3' ] )->default( '1' );
        $schema['separator'] = Boolean_Prop_Type::make()->default( false );
        $schema['arrow_position'] = String_Prop_Type::make()
            ->enum( [ 'arrow_inside', 'arrow_outside' ] )
            ->default( 'arrow_inside' );
        $schema['dot_style'] = String_Prop_Type::make()
            ->enum( [ 'dot_default', 'dot_dashed', 'dot_dotted', 'dot_paginated' ] )
            ->default( 'dot_dotted' );
        $schema['hover_direction'] = String_Prop_Type::make()
            ->enum( [ 'hover_from_left', 'hover_from_top', 'hover_from_bottom', 'hover_from_right' ] )
            ->default( 'hover_from_bottom' );

        $schema['attributes'] = Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() );

        return $schema;
    }

    protected function define_atomic_controls(): array {
        $logo_sections = [];
        for ( $i = 1; $i <= self::MAX_LOGOS; $i++ ) {
            $logo_sections[] = Section::make()
                ->set_label( sprintf( __( 'Logo %d', 'lc-addons-kit-for-elementor' ), $i ) )
                ->set_items( [
                    Switch_Control::bind_to( "enabled_{$i}" )
                        ->set_label( __( 'Enabled', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "name_{$i}" )
                        ->set_label( __( 'Client Name', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( "logo_{$i}" )
                        ->set_label( __( 'Client Logo', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( "hover_enabled_{$i}" )
                        ->set_label( __( 'Enable Hover Logo', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( "hover_logo_{$i}" )
                        ->set_label( __( 'Hover Logo', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( "link_enabled_{$i}" )
                        ->set_label( __( 'Enable Link', 'lc-addons-kit-for-elementor' ) ),
                    Link_Control::bind_to( "link_{$i}" )
                        ->set_label( __( 'Link', 'lc-addons-kit-for-elementor' ) ),
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'Logo', 'lc-addons-kit-for-elementor' ) )
                ->set_items( array_merge( [
                    Select_Control::bind_to( 'slide_style' )
                        ->set_label( __( 'Slide Style', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'simple_logo_image', 'label' => __( 'Simple', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'banner_logo_image', 'label' => __( 'Banner', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                ], $logo_sections ) ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Number_Control::bind_to( 'spacing' )
                        ->set_label( __( 'Spacing Left/Right (px)', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 0 )->set_max( 50 )->set_step( 1 ),
                    Number_Control::bind_to( 'slides_to_show' )
                        ->set_label( __( 'Slides To Show', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 1 )->set_max( 8 )->set_step( 1 ),
                    Number_Control::bind_to( 'slides_to_scroll' )
                        ->set_label( __( 'Slides To Scroll', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 1 )->set_max( 8 )->set_step( 1 ),
                    Switch_Control::bind_to( 'autoplay' )
                        ->set_label( __( 'Autoplay', 'lc-addons-kit-for-elementor' ) ),
                    Number_Control::bind_to( 'speed' )
                        ->set_label( __( 'Speed (ms)', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 1000 )->set_max( 15000 )->set_step( 100 ),
                    Switch_Control::bind_to( 'pause_on_hover' )
                        ->set_label( __( 'Pause on Hover', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'show_arrow' )
                        ->set_label( __( 'Show Arrow', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'left_arrow' )
                        ->set_label( __( 'Left Arrow Icon', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'right_arrow' )
                        ->set_label( __( 'Right Arrow Icon', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'arrow_position' )
                        ->set_label( __( 'Arrow Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'arrow_inside', 'label' => __( 'Inside', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'arrow_outside', 'label' => __( 'Outside', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'loop' )
                        ->set_label( __( 'Enable Loop?', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'show_dot' )
                        ->set_label( __( 'Show Dots', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'dot_style' )
                        ->set_label( __( 'Dot Style', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'dot_default', 'label' => __( 'Default', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'dot_dashed', 'label' => __( 'Dashed', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'dot_dotted', 'label' => __( 'Dotted', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'dot_paginated', 'label' => __( 'Paginate', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Select_Control::bind_to( 'rows' )
                        ->set_label( __( 'Rows', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => '1', 'label' => __( 'One row', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => '2', 'label' => __( 'Two row', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => '3', 'label' => __( 'Three row', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'separator' )
                        ->set_label( __( 'Show Separator', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'hover_direction' )
                        ->set_label( __( 'Overlay Direction (Banner style)', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'hover_from_left', 'label' => __( 'From Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'hover_from_top', 'label' => __( 'From Top', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'hover_from_bottom', 'label' => __( 'From Bottom', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'hover_from_right', 'label' => __( 'From Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic container/logo/dot/arrow/separator background, border, radius,
        // shadow, padding, margin, opacity, position, and typography (incl. normal/hover states)
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

        $items = [];
        for ( $i = 1; $i <= self::MAX_LOGOS; $i++ ) {
            if ( empty( $s[ "enabled_{$i}" ] ) ) {
                continue;
            }
            $has_hover = ! empty( $s[ "hover_enabled_{$i}" ] ) && ! empty( $s[ "hover_logo_{$i}" ]['src'] );
            $items[] = [
                'name' => $s[ "name_{$i}" ] ?? '',
                'logo_src' => $s[ "logo_{$i}" ]['src'] ?? '',
                'logo_alt' => $s[ "logo_{$i}" ]['alt'] ?? '',
                'has_hover' => $has_hover,
                'hover_src' => $has_hover ? ( $s[ "hover_logo_{$i}" ]['src'] ?? '' ) : '',
                'has_link' => ! empty( $s[ "link_enabled_{$i}" ] ) && ! empty( $s[ "link_{$i}" ]['href'] ),
                'href' => $s[ "link_{$i}" ]['href'] ?? '',
                'target' => $s[ "link_{$i}" ]['target'] ?? '',
            ];
        }
        $s['processed_items'] = $items;

        $slides_to_show = max( 1, intval( $s['slides_to_show'] ?? 4 ) );
        $slides_to_scroll = max( 1, intval( $s['slides_to_scroll'] ?? 1 ) );
        $spacing = max( 0, intval( $s['spacing'] ?? 15 ) );
        $rows = intval( $s['rows'] ?? 1 );

        $config = [
            'rtl' => is_rtl(),
            'arrows' => ! empty( $s['show_arrow'] ),
            'dots' => ! empty( $s['show_dot'] ),
            'autoplay' => ! empty( $s['autoplay'] ),
            'speed' => max( 1, intval( $s['speed'] ?? 1000 ) ),
            'slidesPerView' => $slides_to_show,
            'slidesPerGroup' => $slides_to_scroll,
            'pauseOnHover' => ! empty( $s['pause_on_hover'] ),
            'loop' => ( ! empty( $s['loop'] ) && 1 === $rows ),
            'spaceBetween' => $spacing,
            'breakpoints' => [
                320 => [ 'slidesPerView' => 1, 'slidesPerGroup' => 1, 'spaceBetween' => 10 ],
                768 => [ 'slidesPerView' => min( 2, $slides_to_show ), 'slidesPerGroup' => 1, 'spaceBetween' => 10 ],
                1024 => [ 'slidesPerView' => $slides_to_show, 'slidesPerGroup' => $slides_to_scroll, 'spaceBetween' => $spacing ],
            ],
        ];

        if ( $rows > 1 ) {
            $config['grid'] = [ 'fill' => 'row', 'rows' => $rows ];
        }

        $s['data_config'] = wp_json_encode( $config );

        $wrapper_classes = [ 'lcake-clients-slider' ];
        if ( ! empty( $s['show_dot'] ) ) {
            $wrapper_classes[] = 'slider-dotted';
        }
        $wrapper_classes[] = $s['arrow_position'] ?? 'arrow_inside';
        $wrapper_classes[] = $s['dot_style'] ?? 'dot_dotted';
        $wrapper_classes[] = $s['hover_direction'] ?? 'hover_from_bottom';
        $wrapper_classes[] = $s['slide_style'] ?? 'simple_logo_image';
        $s['slider_class'] = implode( ' ', array_filter( $wrapper_classes ) );
        $s['separator_class'] = ! empty( $s['separator'] ) ? 'log-separator' : '';

        return $s;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-client-logo' => __DIR__ . '/lc-client-logo.html.twig',
        ];
    }

    public function render_markdown(): string {
        $s = $this->get_atomic_settings();
        $names = array_map( static fn( $item ) => $item['name'], $s['processed_items'] );
        return implode( ', ', array_filter( $names ) );
    }
}
