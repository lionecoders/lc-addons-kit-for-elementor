<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Image_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Inline_Editing_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Svg_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Html_V3_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Image_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Svg_Src_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classic widget used a multi-field (title/content/icon type/icon/image/active) Elementor
 * Repeater with unlimited rows. Atomic Repeatable_Control can't render multi-field rows, so
 * tabs are exposed as fixed, individually toggleable slots (see LC_Business_Hours for the
 * same pattern). The classic Font-Awesome icon picker has no v4 equivalent — icons use the
 * SVG control instead.
 */
class LC_Tab extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_ITEMS = 6;

    const DEFAULT_ITEMS = [
        [
            'title' => 'Services',
            'content' => '<p>We design and build fast, accessible websites and web apps.</p>',
        ],
        [
            'title' => 'About Us',
            'content' => '<p>We are a team of designers and engineers focused on craft and outcomes.</p>',
        ],
        [
            'title' => 'FAQs',
            'content' => '<p><strong>How long does a project take?</strong><br>Most projects take 3-8 weeks depending on scope.</p>',
        ],
    ];

    public static function get_element_type(): string {
        return 'e-lc-tab';
    }

    public function get_title() {
        return esc_html__( 'LC Tab', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_keywords() {
        return [ 'tab', 'tabs', 'toggle', 'accordion', 'content', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lcake-kit-tab-js' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-tab-css' ];
    }

    protected static function define_props_schema(): array {
        $schema = [
            'classes' => Classes_Prop_Type::make()->default( [] ),
        ];

        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            $default = self::DEFAULT_ITEMS[ $i - 1 ] ?? null;

            $schema[ "enabled_{$i}" ] = Boolean_Prop_Type::make()->default( null !== $default );

            $schema[ "title_{$i}" ] = Html_V3_Prop_Type::make()
                ->default( [
                    'content' => String_Prop_Type::generate( $default['title'] ?? sprintf( __( 'Tab %d', 'lc-addons-kit-for-elementor' ), $i ) ),
                    'children' => [],
                ] );

            $schema[ "content_{$i}" ] = Html_V3_Prop_Type::make()
                ->default( [
                    'content' => String_Prop_Type::generate( $default['content'] ?? __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] );

            $schema[ "is_active_{$i}" ] = Boolean_Prop_Type::make()->default( false );

            $schema[ "icon_type_{$i}" ] = String_Prop_Type::make()
                ->enum( [ 'none', 'icon', 'image' ] )
                ->default( 'none' );

            $schema[ "icon_{$i}" ] = Svg_Src_Prop_Type::make();
            $schema[ "image_{$i}" ] = Image_Prop_Type::make()->default_size( 'thumbnail' );
        }

        $schema['style'] = String_Prop_Type::make()
            ->enum( [ 'horizontal', 'vertical' ] )
            ->default( 'horizontal' );

        $schema['full_width'] = Boolean_Prop_Type::make()->default( false );

        $schema['icon_position'] = String_Prop_Type::make()
            ->enum( [ 'left-pos', 'right-pos', 'top-pos', 'bottom-pos' ] )
            ->default( 'left-pos' );

        $schema['trigger_type'] = String_Prop_Type::make()
            ->enum( [ 'click', 'mouseenter' ] )
            ->default( 'click' );

        $schema['enable_schema'] = Boolean_Prop_Type::make()->default( false );

        $schema['attributes'] = Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() );

        return $schema;
    }

    protected function define_atomic_controls(): array {
        $item_sections = [];

        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            $item_sections[] = Section::make()
                ->set_label( sprintf( __( 'Tab %d', 'lc-addons-kit-for-elementor' ), $i ) )
                ->set_items( [
                    Switch_Control::bind_to( "enabled_{$i}" )
                        ->set_label( __( 'Enabled', 'lc-addons-kit-for-elementor' ) ),
                    Inline_Editing_Control::bind_to( "title_{$i}" )
                        ->set_label( __( 'Title', 'lc-addons-kit-for-elementor' ) ),
                    Inline_Editing_Control::bind_to( "content_{$i}" )
                        ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( "is_active_{$i}" )
                        ->set_label( __( 'Keep This Tab Open?', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( "icon_type_{$i}" )
                        ->set_label( __( 'Icon Type', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'none', 'label' => __( 'None', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'icon', 'label' => __( 'Icon', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'image', 'label' => __( 'Image', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Svg_Control::bind_to( "icon_{$i}" )
                        ->set_label( __( 'Title Icon', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( "image_{$i}" )
                        ->set_label( __( 'Choose Image', 'lc-addons-kit-for-elementor' ) ),
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'Tabs', 'lc-addons-kit-for-elementor' ) )
                ->set_items( $item_sections ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Select_Control::bind_to( 'style' )
                        ->set_label( __( 'Style', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'horizontal', 'label' => __( 'Horizontal', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'vertical', 'label' => __( 'Vertical', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'full_width' )
                        ->set_label( __( 'Full Width Nav', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'icon_position' )
                        ->set_label( __( 'Nav Icon Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'left-pos', 'label' => __( 'Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'right-pos', 'label' => __( 'Right', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'top-pos', 'label' => __( 'Top', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'bottom-pos', 'label' => __( 'Bottom', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Select_Control::bind_to( 'trigger_type' )
                        ->set_label( __( 'Toggle Type', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'click', 'label' => __( 'Click', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'mouseenter', 'label' => __( 'Hover', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'enable_schema' )
                        ->set_label( __( 'Output FAQ Schema', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic wrapper/nav/nav-item background, border, radius, shadow, padding,
        // margin, typography (incl. normal/active states), caret styles, and nav alignment were
        // styled via CSS selectors. In v4 these are handled by the Style Panel.
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
        $allowed_tags = '<b><strong><sup><sub><s><em><i><u><a><del><span><br>';

        $items = [];
        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            if ( empty( $settings[ "enabled_{$i}" ] ) ) {
                continue;
            }

            $title = wp_strip_all_tags( $settings[ "title_{$i}" ] ?? '' );

            $items[] = [
                'slot' => $i,
                'title' => $title,
                'content' => wp_kses( $settings[ "content_{$i}" ] ?? '', wp_kses_allowed_html( 'post' ) ),
                'is_active' => ! empty( $settings[ "is_active_{$i}" ] ),
                'icon_type' => $settings[ "icon_type_{$i}" ] ?? 'none',
                'icon_html' => $settings[ "icon_{$i}" ]['html'] ?? '',
                'image_src' => $settings[ "image_{$i}" ]['src'] ?? '',
                'image_alt' => $settings[ "image_{$i}" ]['alt'] ?? '',
                'handler_id' => $title !== '' ? strtolower( preg_replace( '![^a-z0-9]+!i', '-', $title ) ) : ( 'tab-' . $i ),
            ];
        }

        if ( ! empty( $items ) && ! array_filter( $items, fn( $item ) => $item['is_active'] ) ) {
            $items[0]['is_active'] = true;
        }

        $settings['processed_items'] = $items;
        $settings['tab_id'] = $this->get_id();

        if ( ! empty( $settings['enable_schema'] ) && ! empty( $items ) ) {
            $json = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array_map( static function ( $item ) {
                    return [
                        '@type' => 'Question',
                        'name' => $item['title'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => wp_strip_all_tags( $item['content'] ),
                        ],
                    ];
                }, $items ),
            ];
            $settings['schema_json'] = wp_json_encode( $json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        } else {
            $settings['schema_json'] = '';
        }

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-tab' => __DIR__ . '/lc-tab.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $lines = [];
        foreach ( $settings['processed_items'] as $item ) {
            $lines[] = '**' . $item['title'] . '**';
            $lines[] = wp_strip_all_tags( $item['content'] );
            $lines[] = '';
        }
        return trim( implode( "\n", $lines ) );
    }
}
