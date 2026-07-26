<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Textarea_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LC_Countdown_Timer extends Atomic_Widget_Base {
    use Has_Template;

    const STYLE_CLASSES = [
        'style1' => 'lcake-countdown-timer lcake-countdown text-center',
        'style2' => 'lcake-countdown-timer-2 lcake-countdown text-center',
        'style3' => 'lcake-flip-clock text-center',
        'style4' => 'lcake-countdown-timer-3 lcake-countdown text-center',
        'style5' => 'lcake-countdown-timer-3 lcake-countdown lcake-version-box text-center align-items-end',
        'style6' => 'lcake-countdown-timer-4 lcake-countdown',
    ];

    public static function get_element_type(): string {
        return 'e-lc-countdown-timer';
    }

    public function get_title() {
        return esc_html__( 'LC Countdown Timer', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-countdown';
    }

    public function get_keywords() {
        return [ 'countdown', 'timer', 'clock', 'time', 'deadline', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lcake-kit-countdown-js', 'lcake-kit-countdown-timer-js' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-countdown-timer-css' ];
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'style' => String_Prop_Type::make()
                ->enum( array_keys( self::STYLE_CLASSES ) )
                ->default( 'style1' )
                ->description( 'The visual preset of the countdown timer.' ),

            'due_date' => String_Prop_Type::make()
                ->default( gmdate( 'Y-m-d H:i', strtotime( '+1 day' ) ) )
                ->description( 'The countdown due date and time (Y-m-d H:i).' ),

            'label_weeks' => String_Prop_Type::make()
                ->default( __( 'Weeks', 'lc-addons-kit-for-elementor' ) ),

            'label_days' => String_Prop_Type::make()
                ->default( __( 'Days', 'lc-addons-kit-for-elementor' ) ),

            'label_hours' => String_Prop_Type::make()
                ->default( __( 'Hours', 'lc-addons-kit-for-elementor' ) ),

            'label_minutes' => String_Prop_Type::make()
                ->default( __( 'Minutes', 'lc-addons-kit-for-elementor' ) ),

            'label_seconds' => String_Prop_Type::make()
                ->default( __( 'Seconds', 'lc-addons-kit-for-elementor' ) ),

            'expiry_title' => String_Prop_Type::make()
                ->default( __( 'Countdown is finished!', 'lc-addons-kit-for-elementor' ) ),

            'expiry_content' => String_Prop_Type::make()
                ->default( __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'lc-addons-kit-for-elementor' ) ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        $style_options = [];
        foreach ( array_keys( self::STYLE_CLASSES ) as $i => $value ) {
            $style_options[] = [ 'value' => $value, 'label' => sprintf( __( 'Style %d', 'lc-addons-kit-for-elementor' ), $i + 1 ) ];
        }

        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Text_Control::bind_to( 'due_date' )
                        ->set_label( __( 'Countdown Due Date', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'YYYY-MM-DD HH:MM', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'expiry_title' )
                        ->set_label( __( 'On Expiry Title', 'lc-addons-kit-for-elementor' ) ),
                    Textarea_Control::bind_to( 'expiry_content' )
                        ->set_label( __( 'On Expiry Content', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Select_Control::bind_to( 'style' )
                        ->set_label( __( 'Choose Style', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( $style_options ),
                    Text_Control::bind_to( 'label_weeks' )
                        ->set_label( __( 'Weeks Label', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'label_days' )
                        ->set_label( __( 'Days Label', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'label_hours' )
                        ->set_label( __( 'Hours Label', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'label_minutes' )
                        ->set_label( __( 'Minutes Label', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'label_seconds' )
                        ->set_label( __( 'Seconds Label', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic per-segment (weeks/days/hours/minutes/seconds) digit and label
        // background, border, radius, shadow, margin, typography controls were styled via CSS
        // selectors. In v4 these are handled by the Style Panel.
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
        $style = $settings['style'] ?? 'style1';

        $settings['timer_class'] = self::STYLE_CLASSES[ $style ] ?? self::STYLE_CLASSES['style1'];
        $settings['is_boxed_style'] = ( 'style6' === $style );

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-countdown-timer' => __DIR__ . '/lc-countdown-timer.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $due = $settings['due_date'] ?? '';
        return trim( __( 'Countdown to', 'lc-addons-kit-for-elementor' ) . ' ' . $due );
    }
}
