<?php

defined( 'ABSPATH' ) || exit;

/**
 * Global helper class.
 *
 * @since 1.0.0
 */

class LCAKE_Kit_Utils {


	public static function get_kses_array() {
		return array(
			'a'                             => array(
				'class'  => array(),
				'href'   => array(),
				'rel'    => array(),
				'title'  => array(),
				'target' => array(),
				'style'  => array(),
			),
			'abbr'                          => array(
				'title' => array(),
			),
			'b'                             => array(
				'class' => array(),
			),
			'blockquote'                    => array(
				'cite' => array(),
			),
			'cite'                          => array(
				'title' => array(),
			),
			'code'                          => array(),
			'pre'                           => array(),
			'del'                           => array(
				'datetime' => array(),
				'title'    => array(),
			),
			'dd'                            => array(),
			'div'                           => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'dl'                            => array(),
			'dt'                            => array(),
			'em'                            => array(),
			'strong'                        => array(),
			'h1'                            => array(
				'class' => array(),
			),
			'h2'                            => array(
				'class' => array(),
			),
			'h3'                            => array(
				'class' => array(),
			),
			'h4'                            => array(
				'class' => array(),
			),
			'h5'                            => array(
				'class' => array(),
			),
			'h6'                            => array(
				'class' => array(),
			),
			'i'                             => array(
				'class' => array(),
			),
			'img'                           => array(
				'alt'     => array(),
				'class'   => array(),
				'height'  => array(),
				'src'     => array(),
				'width'   => array(),
				'style'   => array(),
				'title'   => array(),
				'srcset'  => array(),
				'loading' => array(),
				'sizes'   => array(),
			),
			'figure'                        => array(
				'class' => array(),
			),
			'li'                            => array(
				'class' => array(),
			),
			'ol'                            => array(
				'class' => array(),
			),
			'p'                             => array(
				'class' => array(),
			),
			'q'                             => array(
				'cite'  => array(),
				'title' => array(),
			),
			'span'                          => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'iframe'                        => array(
				'width'       => array(),
				'height'      => array(),
				'scrolling'   => array(),
				'frameborder' => array(),
				'allow'       => array(),
				'src'         => array(),
			),
			'strike'                        => array(),
			'br'                            => array(),
			'table'                         => array(),
			'thead'                         => array(),
			'tbody'                         => array(),
			'tfoot'                         => array(),
			'tr'                            => array(),
			'th'                            => array(
				'class'   => true,
				'colspan' => true,
				'rowspan' => true,
				'style'   => true,
				'id'      => true,
			),
			'td'                            => array(
				'class'   => true,
				'colspan' => true,
				'rowspan' => true,
				'style'   => true,
				'id'      => true,
			),
			'caption'                       => array(),
			'col'                           => array(
				'span'  => true,
				'style' => true,
			),
			'colgroup'                      => array(
				'span'  => true,
				'style' => true,
			),
			'strong'                        => array(),
			'data-wow-duration'             => array(),
			'data-wow-delay'                => array(),
			'data-wallpaper-options'        => array(),
			'data-stellar-background-ratio' => array(),
			'ul'                            => array(
				'class' => array(),
			),
			'svg'                           => array(
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true, // <= Must be lower case! 'preserveaspectratio'=> true,
			),
			'g'                             => array( 'fill' => true ),
			'title'                         => array( 'title' => true ),
			'path'                          => array(
				'd'    => true,
				'fill' => true,
			),
			'input'                         => array(
				'class' => array(),
				'type'  => array(),
				'value' => array(),
			),
		);
	}

	public static function kses( $raw ) {

		$allowed_tags = self::get_kses_array();

		if ( function_exists( 'wp_kses' ) ) { // WP is here
			return wp_kses( $raw, $allowed_tags );
		} else {
			return $raw;
		}
	}

	public static function kspan( $text ) {
		return str_replace( array( '{', '}' ), array( '<span>', '</span>' ), $text );
	}

	public static function lcake_get_ninja_form() {
		$options = array();

		if ( class_exists( 'Ninja_Forms' ) ) {
			$contact_forms = Ninja_Forms()->form()->get_forms();

			if ( ! empty( $contact_forms ) && ! is_wp_error( $contact_forms ) ) {

				$options[0] = esc_html__( 'Select Ninja Form', 'lc-addons-kit-for-elementor' );

				foreach ( $contact_forms as $form ) {
					$options[ $form->get_id() ] = $form->get_setting( 'title' );
				}
			}
		} else {
			$options[0] = esc_html__( 'Create a Form First', 'lc-addons-kit-for-elementor' );
		}

		return $options;
	}

	public static function render_elementor_content_css( $content_id ) {
		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
			$css_file = new \Elementor\Core\Files\CSS\Post( $content_id );
			$css_file->enqueue();
		}
	}

	public static function render_elementor_content( $content_id ) {
		$elementor_instance = \Elementor\Plugin::instance();
		$has_css            = false;

		/**
		 * CSS Print Method Internal and Exteral option support for Header and Footer Builder.
		 */
		if ( ( 'internal' === get_option( 'elementor_css_print_method' ) ) || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$has_css = true;
		}

		return $elementor_instance->frontend->get_builder_content_for_display( $content_id, $has_css );
	}

	public static function render( $content ) {
		if ( stripos( $content, 'lcake-has-license' ) !== false ) {
			return null;
		}

		return $content;
	}

	public static function esc_options( $str, $options = array(), $default = '' ) {
		if ( ! in_array( $str, $options ) ) {
			return $default;
		}

		return $str;
	}

	public static function get_attachment_image_html( $settings, $image_key, $image_size_key = null, $image_attr = array() ) {
		if ( ! $image_key ) {
			$image_key = $image_size_key;
		}

		$image = $settings[ $image_key ];

		$size = $image_size_key;

		$html = '';
		if ( ! empty( $image['id'] ) && $image['id'] != '-1' && get_post( $image['id'] ) ) {
			$html .= wp_get_attachment_image( $image['id'], $size, false, $image_attr );
		} else {
			$html .= sprintf(
				'<img src="%s" title="%s" alt="%s" class="%s" />',
				esc_attr( $image['url'] ),
				\Elementor\Control_Media::get_image_title( $image ),
				\Elementor\Control_Media::get_image_alt( $image ),
				( isset( $image_attr['class'] ) ? esc_attr( $image_attr['class'] ) : '' )
			);
		}

		$html = preg_replace( array( '/max-width:[^"]*;/', '/width:[^"]*;/', '/height:[^"]*;/' ), '', $html );

		return $html;
	}

	public static function swiper_class() {
		return 'lcake-main-swiper swiper';
	}

	public static function remove_special_chars( $string ) {
		return preg_replace( '/[^A-Za-z0-9 ]/', '', $string );
	}

	public static function is_woo_active() {
		return class_exists( 'WooCommerce' );
	}

	public static function get_woo_product( $product_id = 0 ) {
		if ( ! self::is_woo_active() ) {
			return false;
		}

		if ( ! empty( $product_id ) ) {
			return wc_get_product( $product_id );
		}

		global $product;
		if ( $product instanceof \WC_Product ) {
			return $product;
		}

		$queried_id = get_the_ID();
		if ( $queried_id && 'product' === get_post_type( $queried_id ) ) {
			return wc_get_product( $queried_id );
		}

		return false;
	}

	public static function get_woo_product_options() {
		$options = array( 0 => esc_html__( 'Current Product (auto)', 'lc-addons-kit-for-elementor' ) );

		if ( ! self::is_woo_active() ) {
			return $options;
		}

		$products = get_posts(
			array(
				'post_type'      => 'product',
				'posts_per_page' => 200,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);

		foreach ( $products as $product ) {
			$options[ $product->ID ] = $product->post_title;
		}

		return $options;
	}

	public static function woo_inactive_notice() {
		self::plugin_inactive_notice( 'WooCommerce' );
	}

	public static function plugin_inactive_notice( $plugin_name ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		echo '<p class="lcake-plugin-notice">' . sprintf(
			/* translators: %s: plugin name */
			esc_html__( '%s needs to be installed & activated to use this widget.', 'lc-addons-kit-for-elementor' ),
			esc_html( $plugin_name )
		) . '</p>';
	}

	public static function lcake_get_gravity_forms() {
		$options = array( 0 => esc_html__( 'Select Form', 'lc-addons-kit-for-elementor' ) );

		if ( class_exists( 'GFAPI' ) ) {
			$forms = \GFAPI::get_forms();
			foreach ( $forms as $form ) {
				$options[ $form['id'] ] = $form['title'];
			}
		}

		return $options;
	}

	public static function lcake_get_wpforms() {
		$options = array( 0 => esc_html__( 'Select Form', 'lc-addons-kit-for-elementor' ) );

		if ( function_exists( 'wpforms' ) ) {
			$forms = get_posts(
				array(
					'post_type'      => 'wpforms',
					'posts_per_page' => 200,
				)
			);
			foreach ( $forms as $form ) {
				$options[ $form->ID ] = $form->post_title;
			}
		}

		return $options;
	}

	public static function lcake_get_fluent_forms() {
		$options = array( 0 => esc_html__( 'Select Form', 'lc-addons-kit-for-elementor' ) );

		if ( defined( 'FLUENTFORM' ) || function_exists( 'wpFluentForm' ) ) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'fluentform_forms';
			if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ) {
				$forms = $wpdb->get_results( "SELECT id, title FROM $table_name ORDER BY id DESC", ARRAY_A );
				if ( ! empty( $forms ) ) {
					foreach ( $forms as $form ) {
						$options[ $form['id'] ] = $form['title'];
					}
				}
			}
		}

		return $options;
	}

	public static function lcake_get_weforms() {
		$options = array( 0 => esc_html__( 'Select Form', 'lc-addons-kit-for-elementor' ) );

		if ( class_exists( 'WeForms' ) ) {
			$forms = get_posts(
				array(
					'post_type'      => 'wpuf_contact_form',
					'posts_per_page' => 200,
				)
			);
			foreach ( $forms as $form ) {
				$options[ $form->ID ] = $form->post_title;
			}
		}

		return $options;
	}

	public static function lcake_file_enqueue( $scripts, $file ) {
		$register_func = 'wp_register_' . $file;
		$enqueue_func  = 'wp_enqueue_' . $file;
		$folder        = ( $file === 'script' ) ? 'js' : 'css';

		foreach ( $scripts as $handle => $data ) {
			$url = LCAKE_EAK_URL . ( $data['path'] === '' ? 'assets/' . $folder : $data['path'] ) . '/' . $data['file'];

			$deps               = $data['deps'] ?? array();
			$in_footer_or_media = $file === 'script' ? true : ( $data['media'] ?? 'all' );

			$register_func( $handle, $url, $deps, LCAKE_EAK_VERSION, $in_footer_or_media );

			if ( ! empty( $data['enqueue'] ) ) {
				$enqueue_func( $handle );
			}
		}
	}
}
