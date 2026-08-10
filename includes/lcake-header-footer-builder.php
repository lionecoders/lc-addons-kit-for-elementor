<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header / Footer Builder.
 *
 * Registers an Elementor-editable post type for header & footer templates,
 * a display-condition system, and the front-end hooks that render the
 * matching template on every page.
 *
 * @since 1.2.0
 */
class LCAKE_Header_Footer_Builder {

	const POST_TYPE          = 'lcake_hf_template';
	const PARENT_MENU_SLUG   = 'lcake_menu';
	private $matching_header = null;
	private $matching_footer = null;

	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_elementor_support' ) );
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 20 );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post_' . self::POST_TYPE, array( $this, 'save_meta_box' ), 10, 1 );

		add_filter( 'manage_' . self::POST_TYPE . '_posts_columns', array( $this, 'admin_columns' ) );
		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', array( $this, 'render_admin_column' ), 10, 2 );

		add_action( 'wp', array( $this, 'init_frontend_hooks' ) );
	}

	public function register_post_type() {
		register_post_type(
			self::POST_TYPE,
			array(
				'labels'              => array(
					'name'          => esc_html__( 'Header / Footer', 'lc-addons-kit-for-elementor' ),
					'singular_name' => esc_html__( 'Template', 'lc-addons-kit-for-elementor' ),
					'add_new_item'  => esc_html__( 'Add New Template', 'lc-addons-kit-for-elementor' ),
					'edit_item'     => esc_html__( 'Edit Template', 'lc-addons-kit-for-elementor' ),
					'all_items'     => esc_html__( 'Header / Footer', 'lc-addons-kit-for-elementor' ),
					'not_found'     => esc_html__( 'No templates found.', 'lc-addons-kit-for-elementor' ),
				),
				'public'              => false,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'rewrite'             => false,
				'query_var'           => true,
				'capability_type'     => 'post',
				'map_meta_cap'        => true,
				'supports'            => array( 'title', 'thumbnail' ),
			)
		);
	}

	/**
	 * Tell Elementor this post type is editable, without requiring the
	 * site owner to manually enable it under Elementor > Settings.
	 */
	public function register_elementor_support() {
		$supported = get_option( 'elementor_cpt_support', array() );
		if ( ! is_array( $supported ) ) {
			$supported = array();
		}
		if ( ! in_array( self::POST_TYPE, $supported, true ) ) {
			$supported[] = self::POST_TYPE;
			update_option( 'elementor_cpt_support', $supported );
		}
	}

	public function register_admin_menu() {
		add_submenu_page(
			self::PARENT_MENU_SLUG,
			esc_html__( 'Header / Footer Builder', 'lc-addons-kit-for-elementor' ),
			esc_html__( 'Header / Footer', 'lc-addons-kit-for-elementor' ),
			'manage_options',
			'edit.php?post_type=' . self::POST_TYPE
		);

		add_submenu_page(
			self::PARENT_MENU_SLUG,
			esc_html__( 'Add New Template', 'lc-addons-kit-for-elementor' ),
			esc_html__( 'Add New Header/Footer', 'lc-addons-kit-for-elementor' ),
			'manage_options',
			'post-new.php?post_type=' . self::POST_TYPE
		);
	}

	public function add_meta_boxes() {
		add_meta_box(
			'lcake_hf_settings',
			esc_html__( 'Display Settings', 'lc-addons-kit-for-elementor' ),
			array( $this, 'render_meta_box' ),
			self::POST_TYPE,
			'side',
			'high'
		);
	}

	private function get_condition_options() {
		return array(
			'none'               => esc_html__( 'None', 'lc-addons-kit-for-elementor' ),
			'entire_site'        => esc_html__( 'Entire Site', 'lc-addons-kit-for-elementor' ),
			'front_page'         => esc_html__( 'Front Page', 'lc-addons-kit-for-elementor' ),
			'blog_page'          => esc_html__( 'Blog / Posts Page', 'lc-addons-kit-for-elementor' ),
			'singular_all'       => esc_html__( 'All Singular (Posts & Pages)', 'lc-addons-kit-for-elementor' ),
			'specific_pages'     => esc_html__( 'Specific Page(s)', 'lc-addons-kit-for-elementor' ),
			'specific_post_type' => esc_html__( 'Specific Post Type', 'lc-addons-kit-for-elementor' ),
			'archive_all'        => esc_html__( 'All Archives', 'lc-addons-kit-for-elementor' ),
			'search'             => esc_html__( 'Search Results Page', 'lc-addons-kit-for-elementor' ),
			'error_404'          => esc_html__( '404 Page', 'lc-addons-kit-for-elementor' ),
		);
	}

	public function render_meta_box( $post ) {
		wp_nonce_field( 'lcake_hf_save_meta', 'lcake_hf_nonce' );

		$type                = get_post_meta( $post->ID, '_lcake_hf_type', true ) ?: 'header';
		$enabled             = get_post_meta( $post->ID, '_lcake_hf_enabled', true );
		$enabled             = '' === $enabled ? '1' : $enabled;
		$priority            = get_post_meta( $post->ID, '_lcake_hf_priority', true );
		$priority            = '' === $priority ? 10 : (int) $priority;
		$condition           = get_post_meta( $post->ID, '_lcake_hf_condition', true ) ?: 'entire_site';
		$condition_pages     = (array) get_post_meta( $post->ID, '_lcake_hf_condition_pages', true );
		$condition_post_type = get_post_meta( $post->ID, '_lcake_hf_condition_post_type', true ) ?: 'post';

		$pages      = get_pages(
			array(
				'sort_column' => 'post_title',
				'number'      => 300,
			)
		);
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		?>
		<p>
			<label for="lcake_hf_type"><strong><?php esc_html_e( 'Template Type', 'lc-addons-kit-for-elementor' ); ?></strong></label><br>
			<select name="lcake_hf_type" id="lcake_hf_type" style="width:100%;">
				<option value="header" <?php selected( $type, 'header' ); ?>><?php esc_html_e( 'Header', 'lc-addons-kit-for-elementor' ); ?></option>
				<option value="footer" <?php selected( $type, 'footer' ); ?>><?php esc_html_e( 'Footer', 'lc-addons-kit-for-elementor' ); ?></option>
			</select>
		</p>

		<p>
			<label>
				<input type="checkbox" name="lcake_hf_enabled" value="1" <?php checked( $enabled, '1' ); ?>>
				<?php esc_html_e( 'Enabled', 'lc-addons-kit-for-elementor' ); ?>
			</label>
		</p>

		<p>
			<label for="lcake_hf_priority"><strong><?php esc_html_e( 'Priority', 'lc-addons-kit-for-elementor' ); ?></strong></label><br>
			<input type="number" name="lcake_hf_priority" id="lcake_hf_priority" value="<?php echo esc_attr( $priority ); ?>" style="width:100%;">
			<span class="description"><?php esc_html_e( 'Lower number = higher priority when more than one template matches.', 'lc-addons-kit-for-elementor' ); ?></span>
		</p>

		<p>
			<label for="lcake_hf_condition"><strong><?php esc_html_e( 'Display On', 'lc-addons-kit-for-elementor' ); ?></strong></label><br>
			<select name="lcake_hf_condition" id="lcake_hf_condition" style="width:100%;">
				<?php foreach ( $this->get_condition_options() as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $condition, $key ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p class="lcake-hf-condition-field" data-show-for="specific_pages">
			<label for="lcake_hf_condition_pages"><strong><?php esc_html_e( 'Choose Page(s)', 'lc-addons-kit-for-elementor' ); ?></strong></label><br>
			<select name="lcake_hf_condition_pages[]" id="lcake_hf_condition_pages" multiple style="width:100%;height:120px;">
				<?php foreach ( $pages as $page ) : ?>
					<option value="<?php echo esc_attr( $page->ID ); ?>" <?php echo in_array( (string) $page->ID, array_map( 'strval', $condition_pages ), true ) ? 'selected' : ''; ?>>
						<?php echo esc_html( $page->post_title ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>

		<p class="lcake-hf-condition-field" data-show-for="specific_post_type">
			<label for="lcake_hf_condition_post_type"><strong><?php esc_html_e( 'Choose Post Type', 'lc-addons-kit-for-elementor' ); ?></strong></label><br>
			<select name="lcake_hf_condition_post_type" id="lcake_hf_condition_post_type" style="width:100%;">
				<?php foreach ( $post_types as $pt ) : ?>
					<option value="<?php echo esc_attr( $pt->name ); ?>" <?php selected( $condition_post_type, $pt->name ); ?>><?php echo esc_html( $pt->label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<script>
		(function () {
			var select = document.getElementById('lcake_hf_condition');
			var fields = document.querySelectorAll('.lcake-hf-condition-field');

			function toggle() {
				fields.forEach(function (field) {
					field.style.display = (field.getAttribute('data-show-for') === select.value) ? '' : 'none';
				});
			}

			select.addEventListener('change', toggle);
			toggle();
		})();
		</script>
		<?php
	}

	public function save_meta_box( $post_id ) {
		if ( ! isset( $_POST['lcake_hf_nonce'] ) || ! wp_verify_nonce( $_POST['lcake_hf_nonce'], 'lcake_hf_save_meta' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$type = isset( $_POST['lcake_hf_type'] ) && 'footer' === $_POST['lcake_hf_type'] ? 'footer' : 'header';
		update_post_meta( $post_id, '_lcake_hf_type', $type );

		update_post_meta( $post_id, '_lcake_hf_enabled', ! empty( $_POST['lcake_hf_enabled'] ) ? '1' : '' );

		$priority = isset( $_POST['lcake_hf_priority'] ) ? (int) $_POST['lcake_hf_priority'] : 10;
		update_post_meta( $post_id, '_lcake_hf_priority', $priority );

		$condition = isset( $_POST['lcake_hf_condition'] ) ? sanitize_key( $_POST['lcake_hf_condition'] ) : 'entire_site';
		if ( ! array_key_exists( $condition, $this->get_condition_options() ) ) {
			$condition = 'entire_site';
		}
		update_post_meta( $post_id, '_lcake_hf_condition', $condition );

		$pages = isset( $_POST['lcake_hf_condition_pages'] ) && is_array( $_POST['lcake_hf_condition_pages'] )
			? array_map( 'absint', $_POST['lcake_hf_condition_pages'] )
			: array();
		update_post_meta( $post_id, '_lcake_hf_condition_pages', $pages );

		$post_type = isset( $_POST['lcake_hf_condition_post_type'] ) ? sanitize_key( $_POST['lcake_hf_condition_post_type'] ) : 'post';
		if ( ! post_type_exists( $post_type ) ) {
			$post_type = 'post';
		}
		update_post_meta( $post_id, '_lcake_hf_condition_post_type', $post_type );
	}

	public function admin_columns( $columns ) {
		$new_columns = array();
		foreach ( $columns as $key => $label ) {
			$new_columns[ $key ] = $label;
			if ( 'title' === $key ) {
				$new_columns['lcake_hf_type']      = esc_html__( 'Type', 'lc-addons-kit-for-elementor' );
				$new_columns['lcake_hf_condition'] = esc_html__( 'Display Condition', 'lc-addons-kit-for-elementor' );
				$new_columns['lcake_hf_status']    = esc_html__( 'Status', 'lc-addons-kit-for-elementor' );
			}
		}
		return $new_columns;
	}

	public function render_admin_column( $column, $post_id ) {
		if ( 'lcake_hf_type' === $column ) {
			$type = get_post_meta( $post_id, '_lcake_hf_type', true ) ?: 'header';
			echo esc_html( 'footer' === $type ? __( 'Footer', 'lc-addons-kit-for-elementor' ) : __( 'Header', 'lc-addons-kit-for-elementor' ) );
		}

		if ( 'lcake_hf_condition' === $column ) {
			$condition = get_post_meta( $post_id, '_lcake_hf_condition', true ) ?: 'entire_site';
			$options   = $this->get_condition_options();
			echo esc_html( $options[ $condition ] ?? $condition );
		}

		if ( 'lcake_hf_status' === $column ) {
			$enabled  = get_post_meta( $post_id, '_lcake_hf_enabled', true );
			$priority = get_post_meta( $post_id, '_lcake_hf_priority', true ) ?: 10;
			if ( '1' === $enabled || '' === $enabled ) {
				printf(
					/* translators: %d: priority number */
					esc_html__( 'Enabled (priority %d)', 'lc-addons-kit-for-elementor' ),
					(int) $priority
				);
			} else {
				esc_html_e( 'Disabled', 'lc-addons-kit-for-elementor' );
			}
		}
	}

	private function condition_matches( $condition, $condition_pages, $condition_post_type ) {
		switch ( $condition ) {
			case 'none':
				return false;
			case 'entire_site':
				return true;
			case 'front_page':
				return is_front_page();
			case 'blog_page':
				return is_home() && ! is_front_page();
			case 'singular_all':
				return is_singular();
			case 'specific_pages':
				return is_singular() && in_array( get_queried_object_id(), array_map( 'intval', $condition_pages ), true );
			case 'specific_post_type':
				return is_singular( $condition_post_type );
			case 'archive_all':
				return is_archive();
			case 'search':
				return is_search();
			case 'error_404':
				return is_404();
			default:
				return false;
		}
	}

	private function get_matching_template( $type ) {
		$templates = get_posts(
			array(
				'post_type'      => self::POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'   => '_lcake_hf_type',
						'value' => $type,
					),
				),
			)
		);

		if ( empty( $templates ) ) {
			return null;
		}

		usort(
			$templates,
			function ( $a, $b ) {
				$priority_a = (int) ( get_post_meta( $a->ID, '_lcake_hf_priority', true ) ?: 10 );
				$priority_b = (int) ( get_post_meta( $b->ID, '_lcake_hf_priority', true ) ?: 10 );
				return $priority_a <=> $priority_b;
			}
		);

		foreach ( $templates as $template ) {
			$enabled = get_post_meta( $template->ID, '_lcake_hf_enabled', true );
			if ( '' !== $enabled && '1' !== $enabled ) {
				continue;
			}

			$condition           = get_post_meta( $template->ID, '_lcake_hf_condition', true ) ?: 'entire_site';
			$condition_pages     = (array) get_post_meta( $template->ID, '_lcake_hf_condition_pages', true );
			$condition_post_type = get_post_meta( $template->ID, '_lcake_hf_condition_post_type', true ) ?: 'post';

			if ( $this->condition_matches( $condition, $condition_pages, $condition_post_type ) ) {
				return $template;
			}
		}

		return null;
	}

	public function init_frontend_hooks() {
		if ( $this->should_skip_render() ) {
			return;
		}

		$this->matching_header = $this->get_matching_template( 'header' );
		$this->matching_footer = $this->get_matching_template( 'footer' );

		if ( $this->matching_header ) {
			add_action( 'get_header', array( $this, 'get_header' ), 1 );
		}

		if ( $this->matching_footer ) {
			add_action( 'get_footer', array( $this, 'get_footer' ), 1 );
		}
	}

	private function should_skip_render() {
		if ( is_admin() ) {
			return true;
		}
		if ( is_singular( self::POST_TYPE ) ) {
			return true;
		}
		if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->preview ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			if ( isset( $_GET['elementor-preview'] ) && (int) $_GET['elementor-preview'] === get_the_ID() && get_post_type() === self::POST_TYPE ) {
				return true;
			}
		}
		return false;
	}

	private function render_template( $template ) {
		if ( ! $template ) {
			return;
		}

		echo '<div class="lcake-hf-template lcake-hf-template--' . esc_attr( get_post_meta( $template->ID, '_lcake_hf_type', true ) ) . '">';
		echo LCAKE_Kit_Utils::render_elementor_content( $template->ID );
		echo '</div>';
	}

	public function get_header( $name = null ) {
		$template = $this->matching_header ?: $this->get_matching_template( 'header' );
		if ( ! $template ) {
			return;
		}

		// Enqueue Header & Footer Elementor CSS in <head>
		LCAKE_Kit_Utils::render_elementor_content_css( $template->ID );
		$footer_template = $this->matching_footer ?: $this->get_matching_template( 'footer' );
		if ( $footer_template ) {
			LCAKE_Kit_Utils::render_elementor_content_css( $footer_template->ID );
		}

		?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title><?php echo wp_get_document_title(); ?></title>
	<?php endif; ?>
		<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
		<?php
		wp_body_open();
		$this->render_template( $template );

		// Suppress the theme's header.php
		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "header-{$name}.php";
		}
		$templates[] = 'header.php';

		// Avoid running wp_head hooks again inside the theme header
		remove_all_actions( 'wp_head' );

		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	public function get_footer( $name = null ) {
		$template = $this->matching_footer ?: $this->get_matching_template( 'footer' );
		if ( ! $template ) {
			return;
		}

		$this->render_template( $template );
		wp_footer();
		?>
</body>
</html>
		<?php
		// Suppress the theme's footer.php
		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "footer-{$name}.php";
		}
		$templates[] = 'footer.php';

		// Avoid running wp_footer hooks again inside the theme footer
		remove_all_actions( 'wp_footer' );

		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}
}
