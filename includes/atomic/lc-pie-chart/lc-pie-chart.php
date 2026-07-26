<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Inline_Editing_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Size_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Html_V3_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Number_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classic widget's PHP render() draws a pure CSS conic-gradient — its JS file targets an
 * unrelated Chart.js/canvas markup contract that never actually matched the render output
 * (a latent bug, Chart.js never fired). This port keeps the real, working conic-gradient
 * behavior and drops the dead Chart.js dependency.
 *
 * Classic widget used an Elementor Repeater for chart slices. Atomic Repeatable_Control can't
 * render multi-field rows, so each slice is a fixed, individually toggleable slot instead.
 */
class LC_Pie_Chart extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_ITEMS = 6;

    const DEFAULTS = [
        1 => [ 'label' => 'Profit', 'value' => 50, 'color' => '#35c048', 'enabled' => true ],
        2 => [ 'label' => 'Lose', 'value' => 30, 'color' => '#ed2424', 'enabled' => true ],
        3 => [ 'label' => 'Investment', 'value' => 20, 'color' => '#7068ff', 'enabled' => true ],
        4 => [ 'label' => 'Data Label', 'value' => 25, 'color' => '#61ce70', 'enabled' => false ],
        5 => [ 'label' => 'Data Label', 'value' => 25, 'color' => '#61ce70', 'enabled' => false ],
        6 => [ 'label' => 'Data Label', 'value' => 25, 'color' => '#61ce70', 'enabled' => false ],
    ];

    public static function get_element_type(): string {
        return 'e-lc-pie-chart';
    }

    public function get_title() {
        return esc_html__( 'LC Pie Chart', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-circle-o';
    }

    public function get_keywords() {
        return [ 'pie', 'chart', 'graph', 'data', 'visualization', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-pie-chart-css' ];
    }

    protected static function define_props_schema(): array {
        $schema = [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'chart_title' => Html_V3_Prop_Type::make()
                ->default( [
                    'content' => String_Prop_Type::generate( '' ),
                    'children' => [],
                ] )
                ->description( 'The title above the chart.' ),
        ];

        foreach ( self::DEFAULTS as $slot => $item ) {
            $schema[ "enabled_{$slot}" ] = Boolean_Prop_Type::make()->default( $item['enabled'] );
            $schema[ "label_{$slot}" ] = String_Prop_Type::make()->default( $item['label'] );
            $schema[ "value_{$slot}" ] = Number_Prop_Type::make()->default( $item['value'] );
            $schema[ "color_{$slot}" ] = String_Prop_Type::make()->default( $item['color'] );
        }

        $schema['show_legend'] = Boolean_Prop_Type::make()->default( true );
        $schema['show_percentage'] = Boolean_Prop_Type::make()->default( true );
        $schema['chart_size'] = Size_Prop_Type::make()->units( [ 'px', '%' ] )->default_unit( 'px' );

        $schema['attributes'] = Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() );

        return $schema;
    }

    protected function define_atomic_controls(): array {
        $item_sections = [];

        foreach ( self::DEFAULTS as $slot => $item ) {
            $item_sections[] = Section::make()
                ->set_label( sprintf( __( 'Slice %d', 'lc-addons-kit-for-elementor' ), $slot ) )
                ->set_items( [
                    Switch_Control::bind_to( "enabled_{$slot}" )
                        ->set_label( __( 'Enabled', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "label_{$slot}" )
                        ->set_label( __( 'Label', 'lc-addons-kit-for-elementor' ) ),
                    Number_Control::bind_to( "value_{$slot}" )
                        ->set_label( __( 'Value', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 0 )
                        ->set_step( 1 ),
                    Text_Control::bind_to( "color_{$slot}" )
                        ->set_label( __( 'Color (Hex)', 'lc-addons-kit-for-elementor' ) ),
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Inline_Editing_Control::bind_to( 'chart_title' )
                        ->set_label( __( 'Chart Title', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Enter chart title', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Chart Data', 'lc-addons-kit-for-elementor' ) )
                ->set_items( $item_sections ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Switch_Control::bind_to( 'show_legend' )
                        ->set_label( __( 'Show Legend', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'show_percentage' )
                        ->set_label( __( 'Show Percentage', 'lc-addons-kit-for-elementor' ) ),
                    Size_Control::bind_to( 'chart_size' )
                        ->set_label( __( 'Chart Size', 'lc-addons-kit-for-elementor' ) )
                        ->set_units( [ 'px', '%' ] )
                        ->set_default_unit( 'px' ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic chart alignment, background, border, border-radius, legend gap,
        // legend text color and legend font size were styled via CSS selectors. In v4 these are
        // handled by the Style Panel.
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

        $labels = [];
        $values = [];
        $colors = [];
        $total = 0;
        $has_values = false;

        foreach ( self::DEFAULTS as $slot => $default ) {
            if ( empty( $settings[ "enabled_{$slot}" ] ) ) {
                continue;
            }

            $label = $settings[ "label_{$slot}" ] ?? '';
            $value = $settings[ "value_{$slot}" ] ?? 0;
            $color = $settings[ "color_{$slot}" ] ?? '#ccc';

            $labels[] = ! empty( $label ) ? $label : sprintf( __( 'Slice %d', 'lc-addons-kit-for-elementor' ), $slot );
            $values[] = is_numeric( $value ) ? (float) $value : 0;
            $colors[] = ! empty( $color ) ? $color : '#ccc';

            if ( is_numeric( $value ) && $value > 0 ) {
                $total += $value;
                $has_values = true;
            }
        }

        if ( ! $has_values && count( $values ) > 0 ) {
            $equal_value = 100 / count( $values );
            $values = array_fill( 0, count( $values ), $equal_value );
            $total = 100;
        }

        $gradient_parts = [];
        $legend_items = [];
        $current_deg = 0;

        foreach ( $values as $index => $value ) {
            $percentage = ( $total > 0 ) ? ( $value / $total ) : 0;
            $slice_deg = $percentage * 360;
            $start_deg = $current_deg;
            $end_deg = $current_deg + $slice_deg;
            $gradient_parts[] = "{$colors[$index]} {$start_deg}deg {$end_deg}deg";
            $current_deg = $end_deg;

            $legend_items[] = [
                'label' => $labels[ $index ],
                'color' => $colors[ $index ],
                'percentage' => round( $percentage * 100, 1 ),
            ];
        }

        $settings['gradient_css'] = implode( ', ', $gradient_parts );
        $settings['legend_items'] = $legend_items;

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-pie-chart' => __DIR__ . '/lc-pie-chart.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $title = wp_strip_all_tags( $settings['chart_title'] ?? '' );
        $parts = [];
        if ( ! empty( $title ) ) {
            $parts[] = '### ' . $title;
        }
        foreach ( $settings['legend_items'] as $item ) {
            $parts[] = '- ' . $item['label'] . ': ' . $item['percentage'] . '%';
        }
        return implode( "\n", $parts );
    }
}
