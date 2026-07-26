<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Image_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Link_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Svg_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Image_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Link_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Svg_Src_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classic widget used an unlimited Elementor Repeater. Atomic Repeatable_Control can't
 * render multi-field rows, so items are exposed as fixed, individually toggleable slots
 * (see LC_Business_Hours for the same pattern). The classic Font-Awesome icon pickers have
 * no v4 equivalent — icons use the SVG control instead. The CSS-only radio/label accordion
 * markup and lcake-kit-image-accordion.js behavior contract (data-link/data-behavior/
 * data-active) are preserved exactly.
 */
class LC_Image_Accordion extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_ITEMS = 6;

    public static function get_element_type(): string {
        return 'e-lc-image-accordion';
    }

    public function get_title() {
        return esc_html__( 'LC Image Accordion', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_keywords() {
        return [ 'image', 'accordion', 'gallery', 'hover', 'effect', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-image-accordion' ];
    }

    public function get_script_depends() {
        return [ 'lcake-kit-image-accordion' ];
    }

    protected static function define_props_schema(): array {
        $schema = [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'active_behavior' => String_Prop_Type::make()
                ->enum( [ 'click', 'hover' ] )
                ->default( 'click' ),
        ];

        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            $schema[ "enabled_{$i}" ] = Boolean_Prop_Type::make()->default( 1 === $i || 2 === $i || 3 === $i );
            $schema[ "active_{$i}" ] = Boolean_Prop_Type::make()->default( 1 === $i );
            $schema[ "bg_{$i}" ] = Image_Prop_Type::make()->default_size( 'full' );
            $schema[ "title_{$i}" ] = String_Prop_Type::make()
                ->default( __( 'Image accordion Title', 'lc-addons-kit-for-elementor' ) );

            $schema[ "enable_icon_{$i}" ] = Boolean_Prop_Type::make()->default( false );
            $schema[ "title_icon_{$i}" ] = Svg_Src_Prop_Type::make();
            $schema[ "title_icon_position_{$i}" ] = String_Prop_Type::make()
                ->enum( [ 'left', 'right' ] )
                ->default( 'left' );

            $schema[ "enable_wrap_link_{$i}" ] = Boolean_Prop_Type::make()->default( false );
            $schema[ "wrap_link_{$i}" ] = Link_Prop_Type::make();

            $schema[ "enable_button_{$i}" ] = Boolean_Prop_Type::make()->default( true );
            $schema[ "button_label_{$i}" ] = String_Prop_Type::make()
                ->default( __( 'Read More', 'lc-addons-kit-for-elementor' ) );
            $schema[ "button_link_{$i}" ] = Link_Prop_Type::make();

            $schema[ "enable_popup_{$i}" ] = Boolean_Prop_Type::make()->default( false );
            $schema[ "popup_icon_{$i}" ] = Svg_Src_Prop_Type::make();

            $schema[ "enable_project_link_{$i}" ] = Boolean_Prop_Type::make()->default( false );
            $schema[ "project_link_{$i}" ] = Link_Prop_Type::make();
            $schema[ "project_link_icon_{$i}" ] = Svg_Src_Prop_Type::make();
        }

        $schema['attributes'] = Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() );

        return $schema;
    }

    protected function define_atomic_controls(): array {
        $item_sections = [];

        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            $item_sections[] = Section::make()
                ->set_label( sprintf( __( 'Item %d', 'lc-addons-kit-for-elementor' ), $i ) )
                ->set_items( [
                    Switch_Control::bind_to( "enabled_{$i}" )
                        ->set_label( __( 'Enabled', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( "active_{$i}" )
                        ->set_label( __( 'Active?', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( "bg_{$i}" )
                        ->set_label( __( 'Background Image', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "title_{$i}" )
                        ->set_label( __( 'Title', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( "enable_icon_{$i}" )
                        ->set_label( __( 'Enable Icon', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( "title_icon_{$i}" )
                        ->set_label( __( 'Icon for Title', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( "title_icon_position_{$i}" )
                        ->set_label( __( 'Icon Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'left', 'label' => __( 'Before', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'right', 'label' => __( 'After', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( "enable_wrap_link_{$i}" )
                        ->set_label( __( 'Enable Wrap Link', 'lc-addons-kit-for-elementor' ) ),
                    Link_Control::bind_to( "wrap_link_{$i}" )
                        ->set_label( __( 'Wrap URL', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( "enable_button_{$i}" )
                        ->set_label( __( 'Enable Button', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "button_label_{$i}" )
                        ->set_label( __( 'Button Label', 'lc-addons-kit-for-elementor' ) ),
                    Link_Control::bind_to( "button_link_{$i}" )
                        ->set_label( __( 'Button URL', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( "enable_popup_{$i}" )
                        ->set_label( __( 'Enable Popup', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( "popup_icon_{$i}" )
                        ->set_label( __( 'Popup Icon', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( "enable_project_link_{$i}" )
                        ->set_label( __( 'Enable Project Link', 'lc-addons-kit-for-elementor' ) ),
                    Link_Control::bind_to( "project_link_{$i}" )
                        ->set_label( __( 'Project Link', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( "project_link_icon_{$i}" )
                        ->set_label( __( 'Project Link Icon', 'lc-addons-kit-for-elementor' ) ),
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'Accordion Items', 'lc-addons-kit-for-elementor' ) )
                ->set_items( $item_sections ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Select_Control::bind_to( 'active_behavior' )
                        ->set_label( __( 'Active Behavior', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'click', 'label' => __( 'Click', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'hover', 'label' => __( 'Hover', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic min-height, gutter, and active/inactive item background,
        // border, radius, shadow, overlay, title/button typography+color, spacing were styled
        // via CSS selectors. In v4 these are handled by the Style Panel.
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
        $behavior = $s['active_behavior'] ?? 'click';

        $items = [];
        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            if ( empty( $s[ "enabled_{$i}" ] ) ) {
                continue;
            }

            $is_active = ! empty( $s[ "active_{$i}" ] );
            $has_wrap_link = ! empty( $s[ "enable_wrap_link_{$i}" ] ) && ! empty( $s[ "wrap_link_{$i}" ]['href'] );

            $wrap_link_data = wp_json_encode( [
                'url' => $has_wrap_link ? $s[ "wrap_link_{$i}" ]['href'] : '',
                'is_external' => ( 'blank' === ( $s[ "wrap_link_{$i}" ]['target'] ?? '' ) ),
            ] );

            $has_popup = ! empty( $s[ "enable_popup_{$i}" ] );
            $has_project_link = ! empty( $s[ "enable_project_link_{$i}" ] ) && ! empty( $s[ "project_link_{$i}" ]['href'] );
            $has_button = ! empty( $s[ "enable_button_{$i}" ] );
            $has_button_link = $has_button && ! empty( $s[ "button_link_{$i}" ]['href'] );

            $items[] = [
                'slot' => $i,
                'is_active' => $is_active,
                'bg_src' => $s[ "bg_{$i}" ]['src'] ?? '',
                'title' => $s[ "title_{$i}" ] ?? '',
                'has_title_icon' => ! empty( $s[ "enable_icon_{$i}" ] ) && ! empty( $s[ "title_icon_{$i}" ]['html'] ),
                'title_icon_html' => $s[ "title_icon_{$i}" ]['html'] ?? '',
                'title_icon_position' => $s[ "title_icon_position_{$i}" ] ?? 'left',
                'has_wrap_link' => $has_wrap_link,
                'wrap_link_data' => $wrap_link_data,
                'has_button' => $has_button,
                'button_label' => $s[ "button_label_{$i}" ] ?? '',
                'button_href' => $has_button_link ? $s[ "button_link_{$i}" ]['href'] : '',
                'button_target' => $s[ "button_link_{$i}" ]['target'] ?? '',
                'has_popup' => $has_popup,
                'popup_icon_html' => $s[ "popup_icon_{$i}" ]['html'] ?? '',
                'has_project_link' => $has_project_link,
                'project_link_href' => $has_project_link ? $s[ "project_link_{$i}" ]['href'] : '',
                'project_link_target' => $s[ "project_link_{$i}" ]['target'] ?? '',
                'project_link_icon_html' => $s[ "project_link_icon_{$i}" ]['html'] ?? '',
            ];
        }

        $s['processed_items'] = $items;
        $s['wrapper_class'] = 'lcake-image-accordion lcake-image-accordion-wraper lcake-image-accordion-' . $behavior;

        return $s;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-image-accordion' => __DIR__ . '/lc-image-accordion.html.twig',
        ];
    }

    public function render_markdown(): string {
        $s = $this->get_atomic_settings();
        $titles = array_map( static fn( $item ) => $item['title'], $s['processed_items'] );
        return implode( ' | ', array_filter( $titles ) );
    }
}
