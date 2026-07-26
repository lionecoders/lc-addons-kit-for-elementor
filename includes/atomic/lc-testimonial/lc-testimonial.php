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
use Elementor\Modules\AtomicWidgets\Controls\Types\Textarea_Control;
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
 * Classic widget used an unlimited Elementor Repeater (client_name/designation/review/rating/
 * link/client_photo/client_logo/hover-logo) plus 6 hand-built swiper slide-layout templates
 * (style1.php - style6.php). Atomic Repeatable_Control can't render multi-field rows, so
 * testimonials are exposed as fixed, individually toggleable slots (see LC_Business_Hours for
 * the same pattern). The 6 bespoke visual presets are consolidated into a single modernized,
 * responsive slide layout here — the Swiper behavior (slides/scroll/speed/autoplay/loop/arrows/
 * dots/spacing) is fully preserved via the same data-config contract the existing
 * lcake-kit-testimonial.js reads. Classic Font-Awesome arrow icons have no v4 equivalent —
 * icons use the SVG control instead.
 */
class LC_Testimonial extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_ITEMS = 6;

    const DEFAULT_ITEMS = [
        [ 'client_name' => 'Testimonial #1' ],
        [ 'client_name' => 'Testimonial #2' ],
        [ 'client_name' => 'Testimonial #3' ],
    ];

    public static function get_element_type(): string {
        return 'e-lc-testimonial';
    }

    public function get_title() {
        return esc_html__( 'LC Testimonial', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_keywords() {
        return [ 'testimonial', 'review', 'quote', 'feedback', 'client', 'rating', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lcake-kit-testimonial-js', 'lcake-swiper-js' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-testimonial-css', 'lcake-swiper-css' ];
    }

    protected static function define_props_schema(): array {
        $schema = [
            'classes' => Classes_Prop_Type::make()->default( [] ),
        ];

        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            $default = self::DEFAULT_ITEMS[ $i - 1 ] ?? null;

            $schema[ "enabled_{$i}" ] = Boolean_Prop_Type::make()->default( null !== $default );
            $schema[ "client_name_{$i}" ] = String_Prop_Type::make()->default( $default['client_name'] ?? '' );
            $schema[ "designation_{$i}" ] = String_Prop_Type::make()->default( __( 'Designation', 'lc-addons-kit-for-elementor' ) );
            $schema[ "review_{$i}" ] = String_Prop_Type::make()->default( __( 'Review Text', 'lc-addons-kit-for-elementor' ) );
            $schema[ "rating_{$i}" ] = String_Prop_Type::make()->enum( [ '1', '2', '3', '4', '5' ] )->default( '5' );
            $schema[ "link_{$i}" ] = Link_Prop_Type::make();
            $schema[ "photo_{$i}" ] = Image_Prop_Type::make()->default_size( 'thumbnail' );
            $schema[ "logo_{$i}" ] = Image_Prop_Type::make()->default_size( 'thumbnail' );
            $schema[ "use_hover_logo_{$i}" ] = Boolean_Prop_Type::make()->default( false );
            $schema[ "logo_active_{$i}" ] = Image_Prop_Type::make()->default_size( 'thumbnail' );
        }

        $schema['quote_icon_enable'] = Boolean_Prop_Type::make()->default( true );
        $schema['quote_icon'] = Svg_Src_Prop_Type::make();
        $schema['quote_position'] = String_Prop_Type::make()->enum( [ 'top', 'bottom' ] )->default( 'bottom' );

        $schema['rating_enable'] = Boolean_Prop_Type::make()->default( true );
        $schema['title_separator'] = Boolean_Prop_Type::make()->default( true );

        $schema['slides_to_show'] = Number_Prop_Type::make()->default( 1 );
        $schema['slides_to_scroll'] = Number_Prop_Type::make()->default( 1 );
        $schema['spacing'] = Number_Prop_Type::make()->default( 15 );
        $schema['speed'] = Number_Prop_Type::make()->default( 1000 );

        $schema['autoplay'] = Boolean_Prop_Type::make()->default( true );
        $schema['pause_on_hover'] = Boolean_Prop_Type::make()->default( true );
        $schema['loop'] = Boolean_Prop_Type::make()->default( false );
        $schema['show_arrow'] = Boolean_Prop_Type::make()->default( false );
        $schema['show_dot'] = Boolean_Prop_Type::make()->default( false );
        $schema['left_arrow'] = Svg_Src_Prop_Type::make();
        $schema['right_arrow'] = Svg_Src_Prop_Type::make();

        $schema['attributes'] = Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() );

        return $schema;
    }

    protected function define_atomic_controls(): array {
        $item_sections = [];

        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            $item_sections[] = Section::make()
                ->set_label( sprintf( __( 'Testimonial %d', 'lc-addons-kit-for-elementor' ), $i ) )
                ->set_items( [
                    Switch_Control::bind_to( "enabled_{$i}" )
                        ->set_label( __( 'Enabled', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "client_name_{$i}" )
                        ->set_label( __( 'Client Name', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "designation_{$i}" )
                        ->set_label( __( 'Designation', 'lc-addons-kit-for-elementor' ) ),
                    Textarea_Control::bind_to( "review_{$i}" )
                        ->set_label( __( 'Testimonial Review', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( "rating_{$i}" )
                        ->set_label( __( 'Rating', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => '5', 'label' => '5' ],
                            [ 'value' => '4', 'label' => '4' ],
                            [ 'value' => '3', 'label' => '3' ],
                            [ 'value' => '2', 'label' => '2' ],
                            [ 'value' => '1', 'label' => '1' ],
                        ] ),
                    Link_Control::bind_to( "link_{$i}" )
                        ->set_label( __( 'Link', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( "photo_{$i}" )
                        ->set_label( __( 'Client Avatar', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( "logo_{$i}" )
                        ->set_label( __( 'Logo', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( "use_hover_logo_{$i}" )
                        ->set_label( __( 'Display Different Logo on Hover?', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( "logo_active_{$i}" )
                        ->set_label( __( 'Logo Active', 'lc-addons-kit-for-elementor' ) ),
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'Testimonials', 'lc-addons-kit-for-elementor' ) )
                ->set_items( $item_sections ),
            Section::make()
                ->set_label( __( 'Quote & Rating', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'quote' )
                ->set_items( [
                    Switch_Control::bind_to( 'quote_icon_enable' )
                        ->set_label( __( 'Enable Quote Icon', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'quote_icon' )
                        ->set_label( __( 'Quote Icon', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'quote_position' )
                        ->set_label( __( 'Quote Icon Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'top', 'label' => __( 'Top', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'bottom', 'label' => __( 'Bottom', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'rating_enable' )
                        ->set_label( __( 'Enable Rating', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'title_separator' )
                        ->set_label( __( 'Show Separator', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Number_Control::bind_to( 'slides_to_show' )
                        ->set_label( __( 'Slides To Show', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 1 )->set_max( 6 )->set_step( 1 ),
                    Number_Control::bind_to( 'slides_to_scroll' )
                        ->set_label( __( 'Slides To Scroll', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 1 )->set_max( 6 )->set_step( 1 ),
                    Number_Control::bind_to( 'spacing' )
                        ->set_label( __( 'Spacing Left/Right (px)', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 0 )->set_max( 100 )->set_step( 1 ),
                    Number_Control::bind_to( 'speed' )
                        ->set_label( __( 'Speed (ms)', 'lc-addons-kit-for-elementor' ) )
                        ->set_min( 100 )->set_max( 10000 )->set_step( 100 ),
                    Switch_Control::bind_to( 'autoplay' )
                        ->set_label( __( 'Autoplay', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'pause_on_hover' )
                        ->set_label( __( 'Pause on Hover', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'loop' )
                        ->set_label( __( 'Enable Loop?', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'show_arrow' )
                        ->set_label( __( 'Show Arrow', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'left_arrow' )
                        ->set_label( __( 'Left Arrow Icon', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'right_arrow' )
                        ->set_label( __( 'Right Arrow Icon', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'show_dot' )
                        ->set_label( __( 'Show Dots', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic per-style backgrounds, borders, shadows, spacing, and typography
        // (for the slider, cards, avatar, logo, dots, arrows) were styled via CSS selectors. In
        // v4 these are handled by the Style Panel. The 6 classic visual presets (style1-style6)
        // are consolidated into one modernized responsive layout.
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

    private static function star_svg( bool $filled ): string {
        if ( $filled ) {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>';
        }
        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"/></svg>';
        }

    public function get_atomic_settings(): array {
        $s = parent::get_atomic_settings();

        $items = [];
        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            if ( empty( $s[ "enabled_{$i}" ] ) ) {
                continue;
            }

            $rating = intval( $s[ "rating_{$i}" ] ?? 5 );
            $stars = [];
            for ( $m = 1; $m <= 5; $m++ ) {
                $stars[] = self::star_svg( $rating >= $m );
            }

            $use_hover_logo = ! empty( $s[ "use_hover_logo_{$i}" ] ) && ! empty( $s[ "logo_active_{$i}" ]['src'] );

            $items[] = [
                'client_name' => $s[ "client_name_{$i}" ] ?? '',
                'designation' => $s[ "designation_{$i}" ] ?? '',
                'review' => wp_kses_post( $s[ "review_{$i}" ] ?? '' ),
                'stars' => $stars,
                'href' => $s[ "link_{$i}" ]['href'] ?? '',
                'target' => $s[ "link_{$i}" ]['target'] ?? '',
                'photo_src' => $s[ "photo_{$i}" ]['src'] ?? '',
                'photo_alt' => $s[ "photo_{$i}" ]['alt'] ?? '',
                'logo_src' => $s[ "logo_{$i}" ]['src'] ?? '',
                'logo_active_src' => $use_hover_logo ? ( $s[ "logo_active_{$i}" ]['src'] ?? '' ) : '',
            ];
        }

        $s['processed_items'] = $items;

        $slides_to_show = max( 1, intval( $s['slides_to_show'] ?? 1 ) );
        $slides_to_scroll = max( 1, intval( $s['slides_to_scroll'] ?? 1 ) );
        $spacing = max( 0, intval( $s['spacing'] ?? 15 ) );

        $config = [
            'rtl' => is_rtl(),
            'arrows' => ! empty( $s['show_arrow'] ),
            'dots' => ! empty( $s['show_dot'] ),
            'pauseOnHover' => ! empty( $s['pause_on_hover'] ),
            'autoplay' => ! empty( $s['autoplay'] ),
            'speed' => max( 1, intval( $s['speed'] ?? 1000 ) ),
            'slidesPerGroup' => $slides_to_scroll,
            'slidesPerView' => $slides_to_show,
            'loop' => ! empty( $s['loop'] ),
            'spaceBetween' => $spacing * 2,
            'breakpoints' => [
                320 => [ 'slidesPerView' => 1, 'slidesPerGroup' => 1, 'spaceBetween' => 20 ],
                768 => [ 'slidesPerView' => min( 2, $slides_to_show ), 'slidesPerGroup' => $slides_to_scroll, 'spaceBetween' => 20 ],
                1024 => [ 'slidesPerView' => $slides_to_show, 'slidesPerGroup' => $slides_to_scroll, 'spaceBetween' => $spacing * 2 ],
            ],
        ];

        $s['data_config'] = wp_json_encode( $config );
        $s['spacing_style'] = '--lcake-testimonial-spacing: ' . $spacing . 'px;';

        return $s;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-testimonial' => __DIR__ . '/lc-testimonial.html.twig',
        ];
    }

    public function render_markdown(): string {
        $s = $this->get_atomic_settings();
        $lines = [];
        foreach ( $s['processed_items'] as $item ) {
            $lines[] = '> ' . wp_strip_all_tags( $item['review'] );
            $lines[] = '**' . $item['client_name'] . '**' . ( $item['designation'] ? ', ' . $item['designation'] : '' );
            $lines[] = '';
        }
        return trim( implode( "\n", $lines ) );
    }
}
