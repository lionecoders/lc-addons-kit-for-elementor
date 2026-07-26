<?php
namespace LCAKE\Atomic;

use Elementor\Modules\AtomicWidgets\Elements\Base\Atomic_Widget_Base;
use Elementor\Modules\AtomicWidgets\Elements\Base\Has_Template;
use Elementor\Modules\AtomicWidgets\Controls\Section;
use Elementor\Modules\AtomicWidgets\Controls\Types\Image_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Inline_Editing_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Link_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Textarea_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropTypes\Attributes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Classes_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Html_V3_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Image_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Link_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;
use Elementor\Modules\AtomicWidgets\Styles\Style_Definition;
use Elementor\Modules\AtomicWidgets\Styles\Style_Variant;
use Elementor\Modules\Components\PropTypes\Overridable_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LC_Image_Box extends Atomic_Widget_Base {
    use Has_Template;

    public static function get_element_type(): string {
        return 'e-lc-image-box';
    }

    public function get_title() {
        return esc_html__( 'LC Image Box', 'lc-addons-kit-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-image-box';
    }

    public function get_keywords() {
        return [ 'image', 'box', 'media', 'content', 'lc' ];
    }

    public function get_style_depends() {
        return [ 'lcake-kit-image-box-css' ];
    }

    protected static function define_props_schema(): array {
        return [
            'classes' => Classes_Prop_Type::make()->default( [] ),

            'image' => Image_Prop_Type::make()
                ->description( 'The image to display.' ),

            'title' => Html_V3_Prop_Type::make()
                ->default( [
                    'content'  => String_Prop_Type::generate( __( 'Image Box Title', 'lc-addons-kit-for-elementor' ) ),
                    'children' => [],
                ] )
                ->description( 'The title of the image box.' ),

            'description' => String_Prop_Type::make()
                ->default( __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'lc-addons-kit-for-elementor' ) )
                ->description( 'The description of the image box.' ),

            'link' => Link_Prop_Type::make(),

            'link_text' => String_Prop_Type::make()
                ->default( __( 'Read More', 'lc-addons-kit-for-elementor' ) )
                ->description( 'The text for the link anchor.' ),

            'position' => String_Prop_Type::make()
                ->enum( [ 'left', 'top', 'right' ] )
                ->default( 'top' )
                ->description( 'The position of the image relative to the content.' ),

            'title_size' => String_Prop_Type::make()
                ->enum( [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ] )
                ->default( 'h3' )
                ->description( 'The HTML tag for the title.' ),

            'attributes' => Attributes_Prop_Type::make()->meta( Overridable_Prop_Type::ignore() ),
        ];
    }

    protected function define_atomic_controls(): array {
        return [
            Section::make()
                ->set_label( __( 'Content', 'lc-addons-kit-for-elementor' ) )
                ->set_items( [
                    Image_Control::bind_to( 'image' )
                        ->set_label( __( 'Image', 'lc-addons-kit-for-elementor' ) ),
                    Inline_Editing_Control::bind_to( 'title' )
                        ->set_label( __( 'Title', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Image Box Title', 'lc-addons-kit-for-elementor' ) ),
                    Textarea_Control::bind_to( 'description' )
                        ->set_label( __( 'Description', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Enter description...', 'lc-addons-kit-for-elementor' ) ),
                ] ),
            Section::make()
                ->set_label( __( 'Settings', 'lc-addons-kit-for-elementor' ) )
                ->set_id( 'settings' )
                ->set_items( [
                    Link_Control::bind_to( 'link' )
                        ->set_label( __( 'Link', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'https://your-link.com', 'lc-addons-kit-for-elementor' ) ),
                    Text_Control::bind_to( 'link_text' )
                        ->set_label( __( 'Link Text', 'lc-addons-kit-for-elementor' ) )
                        ->set_placeholder( __( 'Read More', 'lc-addons-kit-for-elementor' ) ),
                    Select_Control::bind_to( 'position' )
                        ->set_label( __( 'Image Position', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'left', 'label' => __( 'Left', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'top', 'label' => __( 'Top', 'lc-addons-kit-for-elementor' ) ],
                            [ 'value' => 'right', 'label' => __( 'Right', 'lc-addons-kit-for-elementor' ) ],
                        ] ),
                    Select_Control::bind_to( 'title_size' )
                        ->set_label( __( 'Title HTML Tag', 'lc-addons-kit-for-elementor' ) )
                        ->set_options( [
                            [ 'value' => 'h1', 'label' => 'H1' ],
                            [ 'value' => 'h2', 'label' => 'H2' ],
                            [ 'value' => 'h3', 'label' => 'H3' ],
                            [ 'value' => 'h4', 'label' => 'H4' ],
                            [ 'value' => 'h5', 'label' => 'H5' ],
                            [ 'value' => 'h6', 'label' => 'H6' ],
                            [ 'value' => 'div', 'label' => 'div' ],
                            [ 'value' => 'span', 'label' => 'span' ],
                            [ 'value' => 'p', 'label' => 'p' ],
                        ] ),
                    Text_Control::bind_to( '_cssid' )
                        ->set_label( __( 'ID', 'lc-addons-kit-for-elementor' ) )
                        ->set_meta( $this->get_css_id_control_meta() ),
                ] ),
        ];
        // TODO(atomic): classic image size, spacing, border radius, opacity, border, hover animation,
        // alignment, vertical alignment, and typography & colors for title/description/link
        // were styled via CSS selectors. In v4 these are handled by the Style Panel.
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

    protected function get_templates(): array {
        return [
            'elementor/elements/lc-image-box' => __DIR__ . '/lc-image-box.html.twig',
        ];
    }

    public function render_markdown(): string {
        $settings = $this->get_atomic_settings();
        $title = wp_strip_all_tags( $settings['title'] ?? '' );
        $desc = wp_strip_all_tags( $settings['description'] ?? '' );
        
        $md = '';
        if ( ! empty( $settings['image']['url'] ) ) {
            $md .= '![Image](' . esc_url( $settings['image']['url'] ) . ")\n\n";
        }
        if ( ! empty( $title ) ) {
            $tag = $settings['title_size'] ?? 'h3';
            $level = [ 'h1'=>1,'h2'=>2,'h3'=>3,'h4'=>4,'h5'=>5,'h6'=>6 ][ $tag ] ?? 3;
            $md .= str_repeat( '#', $level ) . ' ' . $title . "\n\n";
        }
        if ( ! empty( $desc ) ) {
            $md .= $desc . "\n\n";
        }
        if ( ! empty( $settings['link']['href'] ) && ! empty( $settings['link_text'] ) ) {
            $md .= '[' . $settings['link_text'] . '](' . esc_url( $settings['link']['href'] ) . ')';
        }
        return $md;
    }
}
