<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Number_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LC_Lottie extends Atomic_Widget_Base {
    use Has_Template;

    public static function get_element_type(): string {
        return 'e-lc-lottie';
    }

    public function get_title() {
        return esc_html__( 'LC Lottie', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-animation';
    }

    public function get_keywords() {
        return [ 'lottie', 'animation', 'json', 'svg', 'motion', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lottie', 'lcake-kit-lottie-js' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-lottie-css' ];
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'lottie_url' => String_Prop_Type::make()
                ->default( '' )
                ->description( 'Absolute URL to the Lottie JSON file (LottieFiles link or a Media Library file URL).' ),

            'autoplay' => Boolean_Prop_Type::make()->default( true ),
            'loop' => Boolean_Prop_Type::make()->default( true ),
            'pause_on_hover' => Boolean_Prop_Type::make()->default( true ),

            'speed' => Number_Prop_Type::make()
                ->default( 1 )
                ->description( 'Playback speed (0.1 - 3).' ),

            'direction' => String_Prop_Type::make()
                ->enum( [ '1', '-1' ] )
                ->default( '1' ),

            'show_controls' => Boolean_Prop_Type::make()->default( false ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Text_Control::bind_to( 'lottie_url' )
                        ->set_label( __( 'Lottie JSON URL', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'https://assets.lottiefiles.com/...', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Switch_Control::bind_to( 'autoplay' )
                        ->set_label( __( 'Autoplay', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'loop' )
                        ->set_label( __( 'Loop', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'pause_on_hover' )
                        ->set_label( __( 'Pause on Hover', 'lc-addons-kit-for-elementor' ) ),
                    Number_Control::bind_to( 'speed' )
                        ->set_label( __( 'Speed', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 0.1 )
                        ->set_max( 3 )
                        ->set_step( 0.1 ),
                    Select_Control::bind_to( 'direction' )
                        ->set_label( __( 'Direction', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => '1', 'label' => __( 'Forward', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => '-1', 'label' => __( 'Reverse', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'show_controls' )
                        ->set_label( __( 'Show Player Controls', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): "Media Library" JSON upload control has no v4 equivalent (only image/video
        // media pickers exist) — use the URL field with a copied Media Library file URL instead.
        // TODO(atomic): classic lottie box width/alignment/background/border/shadow/radius and
        // player-control colors were styled via CSS selectors. In v4 these are handled by the Style Panel.
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

        $settings['container_id'] = 'lcake-lottie-' . $this->get_id();
        $settings['lottie_config'] = wp_json_encode( [
            'container_id' => $settings['container_id'],
            'path' => esc_url_raw( $settings['lottie_url'] ?? '' ),
            'autoplay' => ! empty( $settings['autoplay'] ),
            'loop' => ! empty( $settings['loop'] ),
            'speed' => $settings['speed'] ?? 1,
            'direction' => intval( $settings['direction'] ?? 1 ),
            'pause_on_hover' => ! empty( $settings['pause_on_hover'] ),
        ] );

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-lottie' => __DIR__ . '/lc-lottie.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $url = $settings['lottie_url'] ?? '';
        return empty( $url ) ? '' : '[Lottie Animation](' . esc_url( $url ) . ')';
    }
}
