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
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Number_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Svg_Src_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classic widget used a 4-field (title/content/icon/active_icon) Elementor Repeater with
 * unlimited rows. Atomic Repeatable_Control can't render multi-field rows, so items are
 * exposed as fixed, individually toggleable slots (see LC_Business_Hours for the same pattern).
 * The classic Font-Awesome icon picker has no v4 equivalent — icons use the SVG control instead.
 */
class LC_Accordion extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_ITEMS = 8;

    const DEFAULT_ITEMS = [
        [
            'title' => 'How do I start using WordPress?',
            'content' => 'You can start by choosing a domain, getting web hosting, and installing WordPress with one click from most hosting dashboards.',
        ],
        [
            'title' => 'Can I build a website without coding in WordPress?',
            'content' => 'Yes! WordPress has drag-and-drop builders like Elementor that let you build websites visually, without writing code.',
        ],
        [
            'title' => 'What are WordPress themes and plugins?',
            'content' => 'Themes control your website\'s design, and plugins add new features like contact forms, galleries, SEO tools, and more.',
        ],
        [
            'title' => 'How can I learn WordPress faster?',
            'content' => 'Start by exploring the WordPress dashboard, watching tutorials on YouTube, or trying small changes like editing pages and posts.',
        ],
    ];

    public static function get_element_type(): string {
        return 'e-lc-accordion';
    }

    public function get_title() {
        return esc_html__( 'LC Accordion', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_keywords() {
        return [ 'accordion', 'tabs', 'toggle', 'collapsible', 'faq', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lcake-kit-accordion' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-accordion' ];
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
                    'content' => String_Prop_Type::generate( $default['title'] ?? __( 'Accordion Title', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] );

            $schema[ "content_{$i}" ] = Html_V3_Prop_Type::make()
                ->default( [
                    'content' => String_Prop_Type::generate( $default['content'] ?? __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] );

            $schema[ "icon_{$i}" ] = Svg_Src_Prop_Type::make();
            $schema[ "active_icon_{$i}" ] = Svg_Src_Prop_Type::make();
        }

        $schema['active_item'] = Number_Prop_Type::make()
            ->default( 1 )
            ->description( 'The number of the item that should be open by default (0 = all closed).' );

        $schema['icon_position'] = String_Prop_Type::make()
            ->enum( [ 'left', 'right' ] )
            ->default( 'right' );

        $schema['multiple'] = Boolean_Prop_Type::make()->default( false );

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
                    Inline_Editing_Control::bind_to( "title_{$i}" )
                        ->set_label( __( 'Title', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Accordion Title', 'lc-addons-kit-for-elementor' ) ),
                    Inline_Editing_Control::bind_to( "content_{$i}" )
                        ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Lorem ipsum dolor sit amet...', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( "icon_{$i}" )
                        ->set_label( __( 'Icon (Closed)', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( "active_icon_{$i}" )
                        ->set_label( __( 'Icon (Open)', 'lc-addons-kit-for-elementor' ) ),
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
                    Number_Control::bind_to( 'active_item' )
                        ->set_label( __( 'Active Item', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 0 )
                        ->set_max( self::MAX_ITEMS ),
                    Select_Control::bind_to( 'icon_position' )
                        ->set_label( __( 'Icon Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'left', 'label' => __( 'Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'right', 'label' => __( 'Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'multiple' )
                        ->set_label( __( 'Multiple Items Open', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic title/content/icon typography, color, background, border,
        // radius, shadow, padding, margin (per open/closed state) were styled via CSS selectors.
        // In v4 these are handled by the Style Panel.
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

        $items = [];
        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            if ( empty( $settings[ "enabled_{$i}" ] ) ) {
                continue;
            }

            $items[] = [
                'slot' => $i,
                'title' => wp_strip_all_tags( $settings[ "title_{$i}" ] ?? '' ),
                'content' => wp_kses( $settings[ "content_{$i}" ] ?? '', wp_kses_allowed_html( 'post' ) ),
                'icon_html' => $settings[ "icon_{$i}" ]['html'] ?? '',
                'active_icon_html' => $settings[ "active_icon_{$i}" ]['html'] ?? '',
            ];
        }

        $active_item = intval( $settings['active_item'] ?? 0 );
        foreach ( $items as &$item ) {
            $item['is_active'] = ( $item['slot'] === $active_item );
        }
        unset( $item );

        $settings['processed_items'] = $items;
        $settings['icon_position_class'] = ( 'left' === ( $settings['icon_position'] ?? 'right' ) ) ? 'icon-left' : '';

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-accordion' => __DIR__ . '/lc-accordion.html.twig',
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
