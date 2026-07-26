<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Image_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Textarea_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Video_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Image_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Video_Src_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LC_Video extends Atomic_Widget_Base {
    use Has_Template;

    public static function get_element_type(): string {
        return 'e-lc-video';
    }

    public function get_title() {
        return esc_html__( 'LC Video', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-video-playlist';
    }

    public function get_keywords() {
        return [ 'video', 'player', 'youtube', 'vimeo', 'dailymotion', 'embed', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-video-css' ];
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'video_type' => String_Prop_Type::make()
                ->enum( [ 'youtube', 'vimeo', 'dailymotion', 'hosted' ] )
                ->default( 'youtube' ),

            'video_url' => String_Prop_Type::make()
                ->default( '' )
                ->description( 'YouTube, Vimeo, or Dailymotion URL.' ),

            'video_file' => Video_Src_Prop_Type::make(),

            'poster' => Image_Prop_Type::make()
                ->default_size( 'large' ),

            'autoplay' => Boolean_Prop_Type::make()->default( false ),
            'mute' => Boolean_Prop_Type::make()->default( true ),
            'loop' => Boolean_Prop_Type::make()->default( false ),
            'controls' => Boolean_Prop_Type::make()->default( true ),
            'modestbranding' => Boolean_Prop_Type::make()->default( true ),

            'video_title' => String_Prop_Type::make()->default( '' ),
            'video_description' => String_Prop_Type::make()->default( '' ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Select_Control::bind_to( 'video_type' )
                        ->set_label( __( 'Video Type', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'youtube', 'label' => __( 'YouTube', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'vimeo', 'label' => __( 'Vimeo', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'dailymotion', 'label' => __( 'Dailymotion', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'hosted', 'label' => __( 'Self Hosted', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Text_Control::bind_to( 'video_url' )
                        ->set_label( __( 'Video URL', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'https://www.youtube.com/watch?v=...', 'lc-addons-kit-for-elementor' ) ),
                    Video_Control::bind_to( 'video_file' )
                        ->set_label( __( 'Video File', 'lc-addons-kit-for-elementor' ) ),
                    Image_Control::bind_to( 'poster' )
                        ->set_label( __( 'Poster Image', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Playback Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'playback' )
                ->set_items( [
                    Switch_Control::bind_to( 'autoplay' )
                        ->set_label( __( 'Autoplay', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'mute' )
                        ->set_label( __( 'Mute', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'loop' )
                        ->set_label( __( 'Loop', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'controls' )
                        ->set_label( __( 'Player Controls', 'lc-addons-kit-for-elementor' ) ),
                    Switch_Control::bind_to( 'modestbranding' )
                        ->set_label( __( 'Modest Branding (YouTube)', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Information Overlay', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'overlay' )
                ->set_items( [
                    Text_Control::bind_to( 'video_title' )
                        ->set_label( __( 'Video Title', 'lc-addons-kit-for-elementor' ) ),
                    Textarea_Control::bind_to( 'video_description' )
                        ->set_label( __( 'Description', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic aspect-ratio/max-width/border-radius/border/box-shadow and
        // title/description color+typography were styled via CSS selectors (aspect-ratio still
        // defaults to 16/9 via CSS). In v4 these are handled by the Style Panel.
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

    private static function get_embed_url( string $video_url, array $settings ): string {
        $embed_url = '';
        $type = $settings['video_type'] ?? 'youtube';

        if ( 'youtube' === $type ) {
            $pattern = '/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/';
            if ( preg_match( $pattern, $video_url, $matches ) ) {
                $video_id = $matches[1];
                $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                $embed_url .= '?autoplay=' . ( ! empty( $settings['autoplay'] ) ? '1' : '0' );
                $embed_url .= '&mute=' . ( ! empty( $settings['mute'] ) ? '1' : '0' );
                $embed_url .= '&loop=' . ( ! empty( $settings['loop'] ) ? '1' : '0' );
                if ( ! empty( $settings['loop'] ) ) {
                    $embed_url .= '&playlist=' . $video_id;
                }
                $embed_url .= '&controls=' . ( ! empty( $settings['controls'] ) ? '1' : '0' );
                $embed_url .= '&modestbranding=' . ( ! empty( $settings['modestbranding'] ) ? '1' : '0' );
                $embed_url .= '&rel=0';
            }
        } elseif ( 'vimeo' === $type ) {
            $pattern = '/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:[a-zA-Z0-9_\-]+)?/i';
            if ( preg_match( $pattern, $video_url, $matches ) ) {
                $video_id = $matches[1];
                $embed_url = 'https://player.vimeo.com/video/' . $video_id;
                $embed_url .= '?autoplay=' . ( ! empty( $settings['autoplay'] ) ? '1' : '0' );
                $embed_url .= '&muted=' . ( ! empty( $settings['mute'] ) ? '1' : '0' );
                $embed_url .= '&loop=' . ( ! empty( $settings['loop'] ) ? '1' : '0' );
                $embed_url .= '&controls=' . ( ! empty( $settings['controls'] ) ? '1' : '0' );
            }
        } elseif ( 'dailymotion' === $type ) {
            $pattern = '/^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/';
            if ( preg_match( $pattern, $video_url, $matches ) ) {
                $video_id = isset( $matches[4] ) ? $matches[4] : $matches[2];
                $embed_url = 'https://www.dailymotion.com/embed/video/' . $video_id;
                $embed_url .= '?autoplay=' . ( ! empty( $settings['autoplay'] ) ? '1' : '0' );
                $embed_url .= '&mute=' . ( ! empty( $settings['mute'] ) ? '1' : '0' );
                $embed_url .= '&loop=' . ( ! empty( $settings['loop'] ) ? '1' : '0' );
                $embed_url .= '&controls=' . ( ! empty( $settings['controls'] ) ? '1' : '0' );
            }
        }

        return $embed_url;
    }

    public function get_atomic_settings(): array {
        $settings = parent::get_atomic_settings();
        $type = $settings['video_type'] ?? 'youtube';

        if ( 'hosted' === $type ) {
            $settings['resolved_video_url'] = $settings['video_file']['url'] ?? '';
            $settings['embed_url'] = '';
        } else {
            $settings['resolved_video_url'] = $settings['video_url'] ?? '';
            $settings['embed_url'] = self::get_embed_url( $settings['resolved_video_url'], $settings );
        }

        $settings['text_no_url'] = __( 'Please provide a valid video URL or file.', 'lc-addons-kit-for-elementor' );
        $settings['text_invalid_format'] = __( 'Invalid URL matching format.', 'lc-addons-kit-for-elementor' );
        $settings['text_no_video_support'] = __( 'Your browser does not support the video tag.', 'lc-addons-kit-for-elementor' );

        return $settings;
    }

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-video' => __DIR__ . '/lc-video.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $title = wp_strip_all_tags( $settings['video_title'] ?? '' );
        $url = $settings['resolved_video_url'] ?? '';
        if ( empty( $url ) ) {
            return '';
        }
        return '[' . ( $title ?: __( 'Video', 'lc-addons-kit-for-elementor' ) ) . '](' . esc_url( $url ) . ')';
    }
}
