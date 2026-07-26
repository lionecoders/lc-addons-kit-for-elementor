<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Image_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Inline_Editing_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Link_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Svg_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Textarea_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Html_V3_Prop_Type;
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
 * Classic widget used an unlimited Elementor Repeater for the feature list (text/icon/info).
 * Atomic Repeatable_Control can't render multi-field rows, so list items are exposed as
 * fixed, individually toggleable slots (see LC_Business_Hours for the same pattern). The
 * classic Font-Awesome icon pickers have no v4 equivalent — icons use the SVG control instead.
 * The niche flex "Enable Ordering" feature (reorder header/price/features/button via numeric
 * sliders) is dropped — sections keep their natural document order in the atomic version.
 */
class LC_Pricing_Table extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_LIST_ITEMS = 8;

    const DEFAULT_LIST_ITEMS = [
        '15 Email Account',
        '100 GB Space',
        '1 Domain Name',
    ];

    public static function get_element_type(): string {
        return 'e-lc-pricing-table';
    }

    public function get_title() {
        return esc_html__( 'LC Pricing Table', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_keywords() {
        return [ 'pricing', 'table', 'price', 'plan', 'subscription', 'billing', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-price-table' ];
    }

    protected static function define_props_schema(): array {
        $schema = [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'title' => Html_V3_Prop_Type::make()
                ->default( [
                    'content' => String_Prop_Type::generate( __( 'Starter', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] ),

            'title_size' => String_Prop_Type::make()
                ->enum( [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ] )
                ->default( 'h3' ),

            'subtitle' => String_Prop_Type::make()
                ->default( __( 'A small river named Duden flows by their place and supplies', 'lc-addons-kit-for-elementor' ) ),

            'icon_type' => String_Prop_Type::make()
                ->enum( [ 'none', 'icon', 'image' ] )
                ->default( 'none' ),

            'icon_switch' => Boolean_Prop_Type::make()->default( true ),
            'icon' => Svg_Src_Prop_Type::make(),
            'image' => Image_Prop_Type::make()->default_size( 'thumbnail' ),

            'currency' => String_Prop_Type::make()->default( '$' ),
            'currency_position' => String_Prop_Type::make()
                ->enum( [ 'before', 'after' ] )
                ->default( 'before' ),
            'price' => String_Prop_Type::make()->default( '5.99' ),
            'duration' => String_Prop_Type::make()
                ->default( __( 'Month', 'lc-addons-kit-for-elementor' ) ),

            'content_style' => String_Prop_Type::make()
                ->enum( [ 'paragraph', 'list' ] )
                ->default( 'paragraph' ),
            'content' => String_Prop_Type::make()
                ->default( __( 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam', 'lc-addons-kit-for-elementor' ) ),

            'btn_text' => String_Prop_Type::make()
                ->default( __( 'Learn more', 'lc-addons-kit-for-elementor' ) ),
            'btn_link' => Link_Prop_Type::make(),
            'btn_icon_switch' => Boolean_Prop_Type::make()->default( true ),
            'btn_icon' => Svg_Src_Prop_Type::make(),
            'btn_icon_align' => String_Prop_Type::make()
                ->enum( [ 'left', 'right' ] )
                ->default( 'left' ),
            'btn_class' => String_Prop_Type::make()->default( '' ),
            'btn_id' => String_Prop_Type::make()->default( '' ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];

        for ( $i = 1; $i <= self::MAX_LIST_ITEMS; $i++ ) {
            $default = self::DEFAULT_LIST_ITEMS[ $i - 1 ] ?? null;

            $schema[ "list_enabled_{$i}" ] = Boolean_Prop_Type::make()->default( null !== $default );
            $schema[ "list_text_{$i}" ] = String_Prop_Type::make()->default( $default ?? '' );
            $schema[ "list_icon_{$i}" ] = Svg_Src_Prop_Type::make();
            $schema[ "list_info_{$i}" ] = String_Prop_Type::make()->default( '' );
        }

        return $schema;
    }

    protected function define_atomic_controls(): array {
        $list_sections = [];
        for ( $i = 1; $i <= self::MAX_LIST_ITEMS; $i++ ) {
            $list_sections[] = Section::make()
                ->set_label( sprintf( __( 'List Item %d', 'lc-addons-kit-for-elementor' ), $i ) )
                ->set_items( [
                    Switch_Control::bind_to( "list_enabled_{$i}" )
                        ->set_label( __( 'Enabled', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "list_text_{$i}" )
                        ->set_label( __( 'List Text', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( "list_icon_{$i}" )
                        ->set_label( __( 'Icon', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "list_info_{$i}" )
                        ->set_label( __( 'Info Text', 'lc-addons-kit-for-elementor' ) ),
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'Header', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Inline_Editing_Control::bind_to( 'title' )
                        ->set_label( __( 'Table Title', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'title_size' )
                        ->set_label( __( 'Title HTML Tag', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'h1', 'label' => 'H1' ], [ 'value' => 'h2', 'label' => 'H2' ],
                            [ 'value' => 'h3', 'label' => 'H3' ], [ 'value' => 'h4', 'label' => 'H4' ],
                            [ 'value' => 'h5', 'label' => 'H5' ], [ 'value' => 'h6', 'label' => 'H6' ],
                            [ 'value' => 'div', 'label' => 'div' ], [ 'value' => 'span', 'label' => 'span' ],
                            [ 'value' => 'p', 'label' => 'p' ],
                        ] ),
                    Text_Control::bind_to( 'subtitle' )
                        ->set_label( __( 'Table Subtitle', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'icon_type' )
                        ->set_label( __( 'Header Icon or Image?', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'none', 'label' => __( 'None', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'icon', 'label' => __( 'Icon', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'image', 'label' => __( 'Image', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'icon_switch' )
                        ->set_label( __( 'Add Icon?', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'icon' )
                        ->set_label( __( 'Icon', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( 'image' )
                        ->set_label( __( 'Choose Image', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Price Tag', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'price' )
                ->set_items( [
                    Text_Control::bind_to( 'currency' )
                        ->set_label( __( 'Currency', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'currency_position' )
                        ->set_label( __( 'Currency Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'before', 'label' => __( 'Before', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'after', 'label' => __( 'After', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Text_Control::bind_to( 'price' )
                        ->set_label( __( 'Price', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'duration' )
                        ->set_label( __( 'Duration', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Features', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'features' )
                ->set_items( array_merge( [
                    Select_Control::bind_to( 'content_style' )
                        ->set_label( __( 'Features Style', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'paragraph', 'label' => __( 'Paragraph', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'list', 'label' => __( 'List', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Textarea_Control::bind_to( 'content' )
                        ->set_label( __( 'Table Content', 'lc-addons-kit-for-elementor' ) ),
                ], $list_sections ) ),
            Section::make()
                ->set_label( __( 'Button', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'button' )
                ->set_items( [
                    Text_Control::bind_to( 'btn_text' )
                        ->set_label( __( 'Label', 'lc-addons-kit-for-elementor' ) ),
                    Link_Control::bind_to( 'btn_link' )
                        ->set_label( __( 'Link', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'btn_icon_switch' )
                        ->set_label( __( 'Add Icon?', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'btn_icon' )
                        ->set_label( __( 'Icon', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'btn_icon_align' )
                        ->set_label( __( 'Icon Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'left', 'label' => __( 'Before', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'right', 'label' => __( 'After', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Text_Control::bind_to( 'btn_class' )
                        ->set_label( __( 'Class', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'btn_id' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) ),
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
        // TODO(atomic): classic body/title/subtitle/price/features/button background, border,
        // radius, shadow, padding, margin, typography (incl. normal/hover states) and alignment
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

        $s['image_src'] = $s['image']['src'] ?? '';
        $s['image_alt'] = $s['image']['alt'] ?? '';

        $valid_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ];
        $s['title_tag'] = in_array( $s['title_size'] ?? 'h3', $valid_tags, true ) ? $s['title_size'] : 'h3';

        $items = [];
        for ( $i = 1; $i <= self::MAX_LIST_ITEMS; $i++ ) {
            if ( empty( $s[ "list_enabled_{$i}" ] ) ) {
                continue;
            }
            $items[] = [
                'text' => $s[ "list_text_{$i}" ] ?? '',
                'icon_html' => $s[ "list_icon_{$i}" ]['html'] ?? '',
                'info' => $s[ "list_info_{$i}" ] ?? '',
            ];
        }
        $s['processed_list_items'] = $items;

        return $s;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-pricing-table' => __DIR__ . '/lc-pricing-table.html.twig',
        ];
    }

    public function render_markdown(): string {
        $s = $this->get_atomic_settings();
        $title = wp_strip_all_tags( $s['title'] ?? '' );
        $price = trim( ( $s['currency'] ?? '' ) . ( $s['price'] ?? '' ) );
        return trim( $title . ' - ' . $price . ' / ' . ( $s['duration'] ?? '' ) );
    }
}
