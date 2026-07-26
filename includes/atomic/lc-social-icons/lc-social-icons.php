<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Link_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Svg_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Link_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Svg_Src_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * The classic widget used an Elementor Repeater for its icon list. Elementor's atomic
 * Repeatable_Control only supports a single-field child control (text/select/link/svg/etc,
 * or the hardcoded 2-field key-value control) — there is no multi-field composite row control
 * in the public API. So each icon is a fixed, individually toggleable slot instead of a true
 * add/remove/reorder repeater.
 */
class LC_Social_Icons extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_ITEMS = 6;
    const DEFAULT_ENABLED_ITEMS = 3;

    public static function get_element_type(): string {
        return 'e-lc-social-icons';
    }

    public function get_title() {
        return esc_html__( 'LC Social Icons', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-social-icons';
    }

    public function get_keywords() {
        return [ 'social', 'icons', 'facebook', 'twitter', 'instagram', 'linkedin', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-social-icons' ];
    }

    protected static function define_props_schema(): array {
        $schema = [
            'classes' => Classes_Prop_Type::make()->default( [] ),
        ];

        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            $schema[ "enabled_{$i}" ] = Boolean_Prop_Type::make()
                ->default( $i <= self::DEFAULT_ENABLED_ITEMS );

            $schema[ "svg_{$i}" ] = Svg_Src_Prop_Type::make()
                ->description( "The icon for social item {$i}." );

            $schema[ "link_{$i}" ] = Link_Prop_Type::make();

            $schema[ "title_{$i}" ] = String_Prop_Type::make()
                ->default( '' )
                ->description( "The accessible label / visible title for social item {$i}." );
        }

        $schema['layout'] = String_Prop_Type::make()
            ->enum( [ 'horizontal', 'vertical' ] )
            ->default( 'horizontal' )
            ->description( 'The layout direction of the icon list.' );

        $schema['alignment'] = String_Prop_Type::make()
            ->enum( [ 'flex-start', 'center', 'flex-end' ] )
            ->default( 'center' )
            ->description( 'The horizontal alignment of the icon list (horizontal layout only).' );

        $schema['show_title'] = Boolean_Prop_Type::make()
            ->default( false )
            ->description( 'Show the title label next to each icon.' );

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
                    Svg_Control::bind_to( "svg_{$i}" )
                        ->set_label( __( 'Icon (SVG)', 'lc-addons-kit-for-elementor' ) ),
                    Link_Control::bind_to( "link_{$i}" )
                        ->set_label( __( 'Link', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'https://your-link.com', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "title_{$i}" )
                        ->set_label( __( 'Title', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Social Platform', 'lc-addons-kit-for-elementor' ) ),
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'Social Icons', 'lc-addons-kit-for-elementor' ) )
                ->set_items( $item_sections ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Select_Control::bind_to( 'layout' )
                        ->set_label( __( 'Layout', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'horizontal', 'label' => __( 'Horizontal', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'vertical', 'label' => __( 'Vertical', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Select_Control::bind_to( 'alignment' )
                        ->set_label( __( 'Alignment', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'flex-start', 'label' => __( 'Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'center', 'label' => __( 'Center', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'flex-end', 'label' => __( 'Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'show_title' )
                        ->set_label( __( 'Show Title', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic icon/background color, hover color, border, border-radius, padding,
        // margin and title typography were styled via CSS selectors. In v4 these are handled by the
        // Style Panel.
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
        $allowed_schemes = [ 'http', 'https', 'mailto', 'tel' ];
        $items = [];

        for ( $i = 1; $i <= self::MAX_ITEMS; $i++ ) {
            if ( empty( $settings[ "enabled_{$i}" ] ) ) {
                continue;
            }

            $link = $settings[ "link_{$i}" ] ?? null;
            $href = $link['href'] ?? '';

            if ( empty( $href ) ) {
                continue;
            }

            $scheme = wp_parse_url( $href, PHP_URL_SCHEME );
            if ( $scheme && ! in_array( strtolower( $scheme ), $allowed_schemes, true ) ) {
                continue;
            }

            $items[] = [
                'svg' => $settings[ "svg_{$i}" ] ?? null,
                'link' => $link,
                'title' => $settings[ "title_{$i}" ] ?? '',
            ];
        }

        $settings['processed_items'] = $items;

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-social-icons' => __DIR__ . '/lc-social-icons.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $parts = [];
        foreach ( $settings['processed_items'] as $item ) {
            if ( ! empty( $item['title'] ) && ! empty( $item['link']['href'] ) ) {
                $parts[] = '[' . $item['title'] . '](' . esc_url( $item['link']['href'] ) . ')';
            }
        }
        return implode( ' | ', $parts );
    }
}
