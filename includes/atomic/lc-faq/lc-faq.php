<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Inline_Editing_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Html_V3_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Number_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classic widget used a 2-field (title/content) Elementor Repeater with unlimited rows.
 * Atomic Repeatable_Control can't render multi-field rows, so FAQ items are exposed as
 * fixed, individually toggleable slots (see LC_Business_Hours for the same pattern).
 */
class LC_FAQ extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_ITEMS = 8;

    const DEFAULT_ITEMS = [
        [
            'title' => 'Can I build a professional website without knowing how to code?',
            'content' => 'Yes! With Elementor and WordPress, you can easily design stunning websites using drag-and-drop tools—no coding needed',
        ],
        [
            'title' => 'What\'s the difference between WordPress and Elementor?',
            'content' => 'WordPress is a website platform, while Elementor is a page builder plugin that lets you customize your site visually.',
        ],
        [
            'title' => 'Is Elementor good for beginners?',
            'content' => 'Absolutely! Elementor is designed for users of all skill levels. Start learning new design skills right from this platform.',
        ],
        [
            'title' => 'How can I improve my website design using Elementor?',
            'content' => 'From animations to responsive layouts, Elementor offers powerful tools. Explore tips and tutorials here to keep learning new things.',
        ],
    ];

    public static function get_element_type(): string {
        return 'e-lc-faq';
    }

    public function get_title() {
        return esc_html__( 'LC FAQ', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-help-o';
    }

    public function get_keywords() {
        return [ 'faq', 'questions', 'answers', 'accordion', 'help', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lcake-kit-faq-js' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-faq-css' ];
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
        }

        $schema['active_item'] = Number_Prop_Type::make()
            ->default( 1 )
            ->description( 'The number of the item that should be open by default (0 = all closed).' );

        $schema['multiple_open'] = Boolean_Prop_Type::make()->default( false );

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
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'FAQ Items', 'lc-addons-kit-for-elementor' ) )
                ->set_items( $item_sections ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Number_Control::bind_to( 'active_item' )
                        ->set_label( __( 'Active Item', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 0 )
                        ->set_max( self::MAX_ITEMS ),
                    Switch_Control::bind_to( 'multiple_open' )
                        ->set_label( __( 'Multiple Items Open', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic item border/radius/spacing and question/answer background,
        // color, typography, padding (incl. hover/active states) were styled via CSS selectors.
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
        $allowed_tags = '<b><strong><sup><sub><s><em><i><u><a><del><span><br>';

        $items = [];
        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            if ( empty( $settings[ "enabled_{$i}" ] ) ) {
                continue;
            }

            $items[] = [
                'slot' => $i,
                'title' => wp_strip_all_tags( $settings[ "title_{$i}" ] ?? '' ),
                'content' => wp_kses( $settings[ "content_{$i}" ] ?? '', wp_kses_allowed_html( 'post' ) ),
            ];
        }

        $active_item = intval( $settings['active_item'] ?? 0 );
        $active_position = null;
        if ( $active_item > 0 ) {
            foreach ( $items as $position => $item ) {
                if ( $item['slot'] === $active_item ) {
                    $active_position = $position;
                    break;
                }
            }
        }

        foreach ( $items as $position => &$item ) {
            $item['is_active'] = ( $position === $active_position );
        }
        unset( $item );

        $settings['processed_items'] = $items;

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-faq' => __DIR__ . '/lc-faq.html.twig',
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
