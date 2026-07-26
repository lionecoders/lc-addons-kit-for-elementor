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
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classic widget used a 7-row Elementor Repeater (day/open/close/closed/closed_text).
 * Atomic Repeatable_Control can't render multi-field rows, but Business Hours naturally
 * has exactly 7 slots, so each day is a fixed, individually configurable slot.
 */
class LC_Business_Hours extends Atomic_Widget_Base {
    use Has_Template;

    const DAYS = [ 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' ];

    public static function get_element_type(): string {
        return 'e-lc-business-hours';
    }

    public function get_title() {
        return esc_html__( 'LC Business Hours', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-clock-o';
    }

    public function get_keywords() {
        return [ 'business', 'hours', 'time', 'schedule', 'opening', 'closing', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-business-hours' ];
    }

    private static function get_day_options(): array {
        $labels = self::get_day_labels();
        $options = [];
        foreach ( self::DAYS as $day ) {
            $options[] = [ 'value' => $day, 'label' => $labels[ $day ] ];
        }
        return $options;
    }

    private static function get_day_labels(): array {
        return [
            'monday' => __( 'Monday', 'lc-addons-kit-for-elementor' ),
            'tuesday' => __( 'Tuesday', 'lc-addons-kit-for-elementor' ),
            'wednesday' => __( 'Wednesday', 'lc-addons-kit-for-elementor' ),
            'thursday' => __( 'Thursday', 'lc-addons-kit-for-elementor' ),
            'friday' => __( 'Friday', 'lc-addons-kit-for-elementor' ),
            'saturday' => __( 'Saturday', 'lc-addons-kit-for-elementor' ),
            'sunday' => __( 'Sunday', 'lc-addons-kit-for-elementor' ),
        ];
    }

    protected static function define_props_schema(): array {
        $schema = [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'title' => Html_V3_Prop_Type::make()
                ->default( [
                    'content' => String_Prop_Type::generate( __( 'Business Hours', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] )
                ->description( 'The heading above the hours list.' ),
        ];

        foreach ( self::DAYS as $i => $day ) {
            $slot = $i + 1;
            $is_saturday = ( 'saturday' === $day );
            $is_sunday = ( 'sunday' === $day );

            $schema[ "day_{$slot}" ] = String_Prop_Type::make()
                ->enum( self::DAYS )
                ->default( $day );

            $schema[ "open_time_{$slot}" ] = String_Prop_Type::make()
                ->default( $is_saturday ? '10:00' : '09:00' );

            $schema[ "close_time_{$slot}" ] = String_Prop_Type::make()
                ->default( $is_saturday ? '16:00' : '18:00' );

            $schema[ "closed_{$slot}" ] = Boolean_Prop_Type::make()
                ->default( $is_sunday );

            $schema[ "closed_text_{$slot}" ] = String_Prop_Type::make()
                ->default( __( 'Closed', 'lc-addons-kit-for-elementor' ) );
        }

        $schema['highlight_today'] = Boolean_Prop_Type::make()->default( true );

        $schema['time_format'] = String_Prop_Type::make()
            ->enum( [ '12', '24' ] )
            ->default( '24' );

        $schema['attributes'] = Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() );

        return $schema;
    }

    protected function define_atomic_controls(): array {
        $day_options = self::get_day_options();
        $day_sections = [];

        foreach ( self::DAYS as $i => $day ) {
            $slot = $i + 1;

            $day_sections[] = Section::make()
                ->set_label( sprintf( __( 'Day %d', 'lc-addons-kit-for-elementor' ), $slot ) )
                ->set_items( [
                    Select_Control::bind_to( "day_{$slot}" )
                        ->set_label( __( 'Day', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( $day_options ),
                    Text_Control::bind_to( "open_time_{$slot}" )
                        ->set_label( __( 'Opening Time', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( '09:00' ),
                    Text_Control::bind_to( "close_time_{$slot}" )
                        ->set_label( __( 'Closing Time', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( '18:00' ),
                    Switch_Control::bind_to( "closed_{$slot}" )
                        ->set_label( __( 'Closed', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "closed_text_{$slot}" )
                        ->set_label( __( 'Closed Text', 'lc-addons-kit-for-elementor' ) ),
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Inline_Editing_Control::bind_to( 'title' )
                        ->set_label( __( 'Title', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Business Hours', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Hours', 'lc-addons-kit-for-elementor' ) )
                ->set_items( $day_sections ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Switch_Control::bind_to( 'highlight_today' )
                        ->set_label( __( 'Highlight Today', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'time_format' )
                        ->set_label( __( 'Time Format', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => '12', 'label' => __( '12 Hour', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => '24', 'label' => __( '24 Hour', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic container/title/hours/today-highlight background, border,
        // border-radius, padding, margin, color and typography controls were styled via
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

    private static function format_time( string $time, string $format_type ): string {
        if ( empty( $time ) ) {
            return '';
        }
        $timestamp = strtotime( $time );
        if ( false === $timestamp ) {
            return $time;
        }
        return ( '12' === $format_type ) ? gmdate( 'h:i A', $timestamp ) : gmdate( 'H:i', $timestamp );
    }

    public function get_atomic_settings(): array {
        $settings = parent::get_atomic_settings();
        $day_labels = self::get_day_labels();
        $today = strtolower( gmdate( 'l' ) );
        $highlight_today = ! empty( $settings['highlight_today'] );
        $time_format = $settings['time_format'] ?? '24';

        $items = [];
        foreach ( self::DAYS as $i => $default_day ) {
            $slot = $i + 1;
            $day = $settings[ "day_{$slot}" ] ?? $default_day;
            $closed = ! empty( $settings[ "closed_{$slot}" ] );

            $items[] = [
                'day' => $day,
                'day_name' => $day_labels[ $day ] ?? $day,
                'is_today' => $highlight_today && ( $day === $today ),
                'closed' => $closed,
                'closed_text' => $settings[ "closed_text_{$slot}" ] ?? '',
                'open_time' => self::format_time( $settings[ "open_time_{$slot}" ] ?? '', $time_format ),
                'close_time' => self::format_time( $settings[ "close_time_{$slot}" ] ?? '', $time_format ),
            ];
        }

        $settings['processed_items'] = $items;

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-business-hours' => __DIR__ . '/lc-business-hours.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $title = wp_strip_all_tags( $settings['title'] ?? '' );
        $lines = [];
        if ( ! empty( $title ) ) {
            $lines[] = '### ' . $title;
        }
        foreach ( $settings['processed_items'] as $item ) {
            $hours = $item['closed'] ? $item['closed_text'] : $item['open_time'] . ' - ' . $item['close_time'];
            $lines[] = '- **' . $item['day_name'] . '**: ' . $hours;
        }
        return implode( "\n", $lines );
    }
}
