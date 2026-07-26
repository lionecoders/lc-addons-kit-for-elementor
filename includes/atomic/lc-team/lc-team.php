<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Image_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Link_Control;
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
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Svg_Src_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classic widget used an unlimited Elementor Repeater for social icons (icon/link).
 * Atomic Repeatable_Control can't render multi-field rows, so icons are exposed as fixed,
 * individually toggleable slots (see LC_Business_Hours for the same pattern). The classic
 * Font-Awesome icon pickers have no v4 equivalent — icons use the SVG control instead.
 * The 11 classic layout variants and popup markup are assembled server-side (matching the
 * classic widget's markup/classes 1:1 so the existing lcake-team.css continues to style it),
 * then handed to the twig template as a single trusted HTML string.
 */
class LC_Team extends Atomic_Widget_Base {
    use Has_Template;

    const MAX_SOCIAL = 5;

    const STYLES = [
        'default' => 'Default',
        'overlay' => 'Overlay',
        'centered_style' => 'Centered',
        'hover_info' => 'Hover on Social',
        'overlay_details' => 'Overlay with Details',
        'centered_style_details' => 'Centered with Details',
        'long_height_hover' => 'Long Height with Hover',
        'long_height_details' => 'Long Height with Details',
        'long_height_details_hover' => 'Long Height with Details & Hover',
        'overlay_circle' => 'Circle Overlay',
        'overlay_circle_hover' => 'Circle Overlay & Hover',
    ];

    const CARD_STYLES = [ 'default', 'centered_style', 'centered_style_details', 'long_height_details', 'long_height_details_hover' ];
    const OVERLAY_STYLES = [ 'overlay', 'overlay_details', 'long_height_hover', 'overlay_circle', 'overlay_circle_hover' ];

    const DEFAULT_SOCIAL = [
        [ 'label' => 'Facebook', 'url' => 'https://facebook.com' ],
        [ 'label' => 'Twitter', 'url' => 'https://twitter.com' ],
        [ 'label' => 'Pinterest', 'url' => 'https://pinterest.com' ],
    ];

    public static function get_element_type(): string {
        return 'e-lc-team';
    }

    public function get_title() {
        return esc_html__( 'LC Team', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_keywords() {
        return [ 'team', 'member', 'staff', 'person', 'profile', 'lc' ];
    }

    public function get_script_depends() {
        return [ 'lcake-team-js' ];
    }

    public function get_style_depends() {
        return [ 'lcake-team-css' ];
    }

    protected static function define_props_schema(): array {
        $schema = [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'style' => String_Prop_Type::make()
                ->enum( array_keys( self::STYLES ) )
                ->default( 'default' ),

            'image' => Image_Prop_Type::make()->default_size( 'large' ),

            'name' => String_Prop_Type::make()
                ->default( __( 'John Smith', 'lc-addons-kit-for-elementor' ) ),

            'position' => String_Prop_Type::make()
                ->default( __( 'Software Engineer', 'lc-addons-kit-for-elementor' ) ),

            'toggle_icon' => Boolean_Prop_Type::make()->default( false ),
            'top_icon' => Svg_Src_Prop_Type::make(),
            'top_icon_align' => String_Prop_Type::make()
                ->enum( [ 'start', 'center', 'end' ] )
                ->default( 'center' ),

            'show_description' => Boolean_Prop_Type::make()->default( false ),
            'short_description' => String_Prop_Type::make()
                ->default( __( 'Passionate engineer focused on building fast, accessible, and user-friendly web experiences.', 'lc-addons-kit-for-elementor' ) ),

            'social_enable' => Boolean_Prop_Type::make()->default( true ),

            'chose_popup' => Boolean_Prop_Type::make()->default( true ),
            'popup_description' => String_Prop_Type::make()
                ->default( __( 'A small river named Duden flows by their place and supplies it with the necessary', 'lc-addons-kit-for-elementor' ) ),
            'popup_phone' => String_Prop_Type::make()->default( '+1 (859) 254-6589' ),
            'popup_email' => String_Prop_Type::make()->default( 'info@example.com' ),
            'close_icon' => Svg_Src_Prop_Type::make(),
            'close_icon_alignment' => String_Prop_Type::make()
                ->enum( [ 'left', 'right' ] )
                ->default( 'right' ),

            'remove_gutters' => Boolean_Prop_Type::make()->default( false ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];

        for ( $i = 1; $i <= self::MAX_SOCIAL; $i++ ) {
            $default = self::DEFAULT_SOCIAL[ $i - 1 ] ?? null;

            $schema[ "social_enabled_{$i}" ] = Boolean_Prop_Type::make()->default( null !== $default );
            $schema[ "social_icon_{$i}" ] = Svg_Src_Prop_Type::make();
            $schema[ "social_label_{$i}" ] = String_Prop_Type::make()->default( $default['label'] ?? '' );
            $schema[ "social_link_{$i}" ] = Link_Prop_Type::make();
        }

        return $schema;
    }

    protected function define_atomic_controls(): array {
        $style_options = [];
        foreach ( self::STYLES as $value => $label ) {
            $style_options[] = [ 'value' => $value, 'label' => __( $label, 'lc-addons-kit-for-elementor' ) ];
        }

        $social_sections = [];
        for ( $i = 1; $i <= self::MAX_SOCIAL; $i++ ) {
            $social_sections[] = Section::make()
                ->set_label( sprintf( __( 'Social %d', 'lc-addons-kit-for-elementor' ), $i ) )
                ->set_items( [
                    Switch_Control::bind_to( "social_enabled_{$i}" )
                        ->set_label( __( 'Enabled', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( "social_icon_{$i}" )
                        ->set_label( __( 'Icon', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( "social_label_{$i}" )
                        ->set_label( __( 'Label (for accessibility)', 'lc-addons-kit-for-elementor' ) ),
                    Link_Control::bind_to( "social_link_{$i}" )
                        ->set_label( __( 'Link', 'lc-addons-kit-for-elementor' ) ),
                ] );
        }

        return [
            Section::make()
                ->set_label( __( 'Team Member Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Select_Control::bind_to( 'style' )
                        ->set_label( __( 'Style', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( $style_options ),
                    Image_Control::bind_to( 'image' )
                        ->set_label( __( 'Choose Member Image', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'name' )
                        ->set_label( __( 'Member Name', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'position' )
                        ->set_label( __( 'Member Position', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'toggle_icon' )
                        ->set_label( __( 'Show Icon (Default style)', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'top_icon' )
                        ->set_label( __( 'Icon', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'top_icon_align' )
                        ->set_label( __( 'Icon Alignment', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'start', 'label' => __( 'Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'center', 'label' => __( 'Center', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'end', 'label' => __( 'Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Switch_Control::bind_to( 'show_description' )
                        ->set_label( __( 'Show Description', 'lc-addons-kit-for-elementor' ) ),
                    Textarea_Control::bind_to( 'short_description' )
                        ->set_label( __( 'About Member', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Social Profiles', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'social' )
                ->set_items( array_merge( [
                    Switch_Control::bind_to( 'social_enable' )
                        ->set_label( __( 'Display Social Profiles?', 'lc-addons-kit-for-elementor' ) ),
                ], $social_sections ) ),
            Section::make()
                ->set_label( __( 'Pop Up Details', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'popup' )
                ->set_items( [
                    Switch_Control::bind_to( 'chose_popup' )
                        ->set_label( __( 'Show Popup', 'lc-addons-kit-for-elementor' ) ),
                    Textarea_Control::bind_to( 'popup_description' )
                        ->set_label( __( 'About Member', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'popup_phone' )
                        ->set_label( __( 'Phone', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'popup_email' )
                        ->set_label( __( 'Email', 'lc-addons-kit-for-elementor' ) ),
                    Svg_Control::bind_to( 'close_icon' )
                        ->set_label( __( 'Close Icon', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'close_icon_alignment' )
                        ->set_label( __( 'Close Icon Alignment', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'left', 'label' => __( 'Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'right', 'label' => __( 'Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Switch_Control::bind_to( 'remove_gutters' )
                        ->set_label( __( 'Remove Gutter? (Long Height with Hover)', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic content/image/icon/name/position/social background, border,
        // radius, shadow, padding, margin, typography (incl. normal/hover states) and hover
        // animation were styled via CSS selectors. In v4 these are handled by the Style Panel.
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

    private function build_social_list_html( array $items ): string {
        if ( empty( $items ) ) {
            return '';
        }

        $html = '<ul class="lcake-team-social-list">';
        foreach ( $items as $item ) {
            $link_attrs = '';
            if ( ! empty( $item['label'] ) ) {
                $link_attrs .= ' aria-label="' . esc_attr( $item['label'] ) . '"';
            }
            $link_attrs .= ' href="' . ( ! empty( $item['href'] ) ? esc_url( $item['href'] ) : 'javascript:void(0)' ) . '"';
            if ( ! empty( $item['target'] ) ) {
                $link_attrs .= ' target="_blank" rel="noopener noreferrer"';
            }

            $html .= '<li><a' . $link_attrs . '>' . $item['icon_html'] . '</a></li>';
        }
        $html .= '</ul>';

        return $html;
    }

    private function build_popup_html( array $s, string $image_html, string $social_list_html ): string {
        $close_class = ( 'left' === $s['close_icon_alignment'] ) ? 'lcake-team-close-btn-align-left' : 'lcake-team-close-btn-align-right';
        $close_icon_html = $s['close_icon']['html'] ?? '';
        $modal_id = 'lcake_team_modal_' . $this->get_id() . '_' . get_the_ID();

        $html = '<div class="modal fade lcake-team-popup lcake-team-modal team-popup-id-' . esc_attr( $this->get_id() ) . '" id="' . esc_attr( $modal_id ) . '" tabindex="-1" role="dialog" aria-hidden="true" aria-modal="true">';
        $html .= '<div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">';
        $html .= '<button type="button" class="lcake-team-modal-close ' . esc_attr( $close_class ) . '" aria-label="Close" data-bs-dismiss="modal">';
        $html .= ! empty( $close_icon_html ) ? $close_icon_html : '<span aria-hidden="true">&times;</span>';
        $html .= '</button>';
        $html .= '<div class="modal-body"><div class="lcake-team-modal-info' . ( ! empty( $image_html ) ? ' has-img' : '' ) . '">';
        $html .= '<h2 class="lcake-team-modal-title">' . esc_html( $s['name'] ) . '</h2>';
        $html .= '<p class="lcake-team-modal-position">' . esc_html( $s['position'] ) . '</p>';
        $html .= '<div class="lcake-team-modal-content">' . wp_kses_post( $s['popup_description'] ) . '</div>';

        if ( $s['popup_phone'] || $s['popup_email'] ) {
            $html .= '<ul class="lcake-team-modal-list">';
            if ( $s['popup_phone'] ) {
                $html .= '<li><strong>' . esc_html__( 'Phone', 'lc-addons-kit-for-elementor' ) . ':</strong><a href="tel:' . esc_attr( $s['popup_phone'] ) . '">' . esc_html( $s['popup_phone'] ) . '</a></li>';
            }
            if ( $s['popup_email'] ) {
                $html .= '<li><strong>' . esc_html__( 'Email', 'lc-addons-kit-for-elementor' ) . ':</strong><a href="mailto:' . esc_attr( $s['popup_email'] ) . '">' . esc_html( $s['popup_email'] ) . '</a></li>';
            }
            $html .= '</ul>';
        }

        if ( $s['social_enable'] ) {
            $html .= $social_list_html;
        }

        $html .= '</div></div></div></div></div>';

        return $html;
    }

    public function get_atomic_settings(): array {
        $s = parent::get_atomic_settings();

        $image_html = '';
        if ( ! empty( $s['image']['src'] ) ) {
            $image_html = '<img src="' . esc_url( $s['image']['src'] ) . '" alt="' . esc_attr( $s['image']['alt'] ?? '' ) . '">';
        }

        $social_items = [];
        for ( $i = 1; $i <= self::MAX_SOCIAL; $i++ ) {
            if ( empty( $s[ "social_enabled_{$i}" ] ) ) {
                continue;
            }
            $social_items[] = [
                'icon_html' => $s[ "social_icon_{$i}" ]['html'] ?? '',
                'label' => $s[ "social_label_{$i}" ] ?? '',
                'href' => $s[ "social_link_{$i}" ]['href'] ?? '',
                'target' => $s[ "social_link_{$i}" ]['target'] ?? '',
            ];
        }
        $social_list_html = $s['social_enable'] ? $this->build_social_list_html( $social_items ) : '';

        $style = $s['style'] ?? 'default';
        $align = ''; // classic alignment control was Style-tab; omitted, see TODO.
        $name_html = esc_html( $s['name'] ?? '' );
        $modal_id = 'lcake_team_modal_' . $this->get_id() . '_' . get_the_ID();
        $popup_attrs = ! empty( $s['chose_popup'] ) ? ' data-bs-toggle="modal" data-bs-target="#' . esc_attr( $modal_id ) . '"' : '';
        $name_link_open = ! empty( $s['chose_popup'] ) ? '<a aria-label="profile" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#' . esc_attr( $modal_id ) . '" class="lcake-team-popup">' : '';
        $name_link_close = ! empty( $s['chose_popup'] ) ? '</a>' : '';

        $description_html = ( ! empty( $s['show_description'] ) && ! empty( $s['short_description'] ) )
            ? '<p class="lcake-profile-content">' . wp_kses_post( $s['short_description'] ) . '</p>'
            : '';

        $body_html = '<div class="lcake-profile-body">';
        if ( 'default' === $style && ! empty( $s['toggle_icon'] ) && ! empty( $s['top_icon']['html'] ) ) {
            $body_html .= '<div class="lcake-profile-icon icon-align-' . esc_attr( $s['top_icon_align'] ?? 'center' ) . '">' . $s['top_icon']['html'] . '</div>';
        }
        $body_html .= '<h2 class="lcake-profile-title">' . $name_link_open . $name_html . $name_link_close . '</h2>';
        $body_html .= '<p class="lcake-profile-designation">' . esc_html( $s['position'] ?? '' ) . '</p>';
        $body_html .= $description_html;
        $body_html .= '</div>';

        $footer_html = ! empty( $s['social_enable'] ) ? '<div class="lcake-profile-footer">' . $social_list_html . '</div>' : '';

        if ( in_array( $style, self::CARD_STYLES, true ) ) {
            $wrap_open = '';
            $wrap_close = '';
            if ( 'centered_style' === $style ) {
                $wrap_open = '<div class="lcake-profile-square-v">';
                $wrap_close = '</div>';
            } elseif ( 'centered_style_details' === $style ) {
                $wrap_open = '<div class="lcake-profile-square-v square-v5 no_gutters">';
                $wrap_close = '</div>';
            } elseif ( 'long_height_details' === $style ) {
                $wrap_open = '<div class="lcake-profile-square-v square-v6 no_gutters">';
                $wrap_close = '</div>';
            } elseif ( 'long_height_details_hover' === $style ) {
                $wrap_open = '<div class="lcake-profile-square-v square-v6 square-v6-v2 no_gutters">';
                $wrap_close = '</div>';
            }

            $header_html = '<div class="lcake-profile-header lcake-team-img' . ( 'default' === $style ? ' lcake-img-overlay lcake-team-img-block' : '' ) . '"' . $popup_attrs . '>' . $image_html . '</div>';
            if ( ! empty( $s['chose_popup'] ) ) {
                $header_html = '<a aria-label="profile" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#' . esc_attr( $modal_id ) . '" class="lcake-team-popup">' . $header_html . '</a>';
            }

            $card_html = '<div class="lcake-profile-card ' . esc_attr( $align ) . ' lcake-team-style-' . esc_attr( $style ) . '">' . $header_html . $body_html . $footer_html . '</div>';

            $content_html = $wrap_open . $card_html . $wrap_close;
        } elseif ( in_array( $style, self::OVERLAY_STYLES, true ) ) {
            $wrap_open = '';
            $wrap_close = '';
            if ( 'overlay_details' === $style ) {
                $wrap_open = '<div class="lcake-image-card-v2">';
                $wrap_close = '</div>';
            } elseif ( 'long_height_hover' === $style ) {
                $wrap_open = '<div class="' . ( ! empty( $s['remove_gutters'] ) ? '' : 'small-gutters' ) . ' lcake-image-card-v3">';
                $wrap_close = '</div>';
            } elseif ( 'overlay_circle' === $style ) {
                $wrap_open = '<div class="lcake-style-circle lcake-team-img-fit">';
                $wrap_close = '</div>';
            } elseif ( 'overlay_circle_hover' === $style ) {
                $wrap_open = '<div class="lcake-image-card-v2 lcake-style-circle">';
                $wrap_close = '</div>';
            }

            $card_html = '<div class="lcake-profile-image-card lcake-team-img lcake-team-style-' . esc_attr( $style ) . ' ' . esc_attr( $align ) . '">';
            $card_html .= $image_html;
            $card_html .= '<div class="lcake-hover-area">' . $body_html . $footer_html . '</div>';
            $card_html .= '</div>';

            $content_html = $wrap_open . $card_html . $wrap_close;
        } else { // hover_info
            $header_html = '<div class="lcake-profile-header lcake-team-img"' . $popup_attrs . '>' . $image_html . '</div>';
            $card_html = '<div class="lcake-profile-card ' . esc_attr( $align ) . '">' . $header_html . $body_html . $footer_html . '</div>';
            $content_html = '<div class="lcake-profile-square-v square-v4 lcake-team-style-' . esc_attr( $style ) . '">' . $card_html . '</div>';
        }

        $s['content_html'] = $content_html;
        $s['popup_html'] = ! empty( $s['chose_popup'] ) ? $this->build_popup_html( $s, $image_html, $social_list_html ) : '';

        return $s;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-team' => __DIR__ . '/lc-team.html.twig',
        ];
    }

    public function render_markdown(): string {
        $s = $this->get_atomic_settings();
        return trim( ( $s['name'] ?? '' ) . ' - ' . ( $s['position'] ?? '' ) );
    }
}
