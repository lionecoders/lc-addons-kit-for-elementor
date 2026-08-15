<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Core widget loader class.
 * 
 * Handles discovering, dependency checking, and registering Elementor widgets
 * from the 'lc-kit' and 'lc-header-footer' directories. Also manages asset enqueuing.
 *
 * @since 1.0.0
 */
class LCAKE_Kit_Widget_Loader {


	private $widget_classes   = array();
	private $active_widgets   = array();
	private $excluded_styles  = array();
	private $excluded_scripts = array();

	private $dependencies_checked = false;

	/**
	 * Constructor.
	 * 
	 * Hooks into Elementor core actions to register widgets, categories, and frontend/editor assets.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_categories' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_editor_styles' ) );
	}

	/**
	 * Scans widget directories and maps widget file data to their corresponding class names.
	 *
	 * @since 1.0.0
	 * @return array An associative array of widget classes and their file data.
	 */
	public function load_widget_classes() {
		if ( ! empty( $this->widget_classes ) ) {
			return $this->widget_classes;
		}

		$folders = array(
			'lc-kit'           => 'LCAKE_Kit_',
			'lc-header-footer' => 'LC_Header_Footer_',
		);

		foreach ( $folders as $folder => $prefix ) {
			$path = LCAKE_EAK_PATH . 'includes/widgets/' . $folder . '/';
			if ( ! is_dir( $path ) ) {
				continue;
			}

			// Get all PHP files including those in subdirectories
			$files        = glob( $path . '*.php' );
			$subdir_files = glob( $path . '*/*.php' );
			$all_files    = array_merge( $files ?: array(), $subdir_files ?: array() );

			foreach ( $all_files as $file ) {
				require_once $file;

				// Widget name = filename without extension (e.g., accordion.php → accordion)
				$widget_name = basename( $file, '.php' );

				// Composite ID disambiguates same-named files across folders (e.g. "post-grid"
				// exists in both lc-kit and lc-header-footer). This is what the Widget Manager saves.
				$widget_id = $folder . ':' . $widget_name;

				// Convert to PascalCase for class name (e.g., accordion → LCAKE_Kit_Accordion)
				$class = $prefix . str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $widget_name ) ) );

				if ( class_exists( $class ) ) {
					$this->widget_classes[ $widget_id ] = array(
						'class'  => $class,
						'name'   => $widget_name,
						'folder' => $folder,
						'file'   => $file,
					);
				}
			}
		}

		return $this->widget_classes;
	}

	/**
	 * Verifies third-party plugin dependencies for all discovered widgets.
	 * 
	 * If a widget's dependencies (e.g., WooCommerce) are unmet, it excludes the widget's
	 * specific assets (CSS/JS) from being enqueued.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function check_all_widget_dependencies() {
		if ( $this->dependencies_checked ) {
			return;
		}

		if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
			return;
		}

		$this->dependencies_checked = true;
		$widget_data                = $this->load_widget_classes();

		foreach ( $widget_data as $widget_id => $data ) {
			$class        = $data['class'];
			$dependencies = array();

			if ( class_exists( $class ) ) {
				$widget_instance = new $class();
				if ( method_exists( $widget_instance, 'get_required_dependencies' ) ) {
					$dependencies = (array) $widget_instance->get_required_dependencies();
				}

				if ( LCAKE_Kit_Dependency_Checker::check( $dependencies ) ) {
					$this->active_widgets[ $widget_id ] = $class;
				} else {
					if ( method_exists( $widget_instance, 'get_style_depends' ) ) {
						$this->excluded_styles = array_merge( $this->excluded_styles, (array) $widget_instance->get_style_depends() );
					}
					if ( method_exists( $widget_instance, 'get_script_depends' ) ) {
						$this->excluded_scripts = array_merge( $this->excluded_scripts, (array) $widget_instance->get_script_depends() );
					}
				}
			}
		}
	}

	/**
	 * Registers custom categories in the Elementor panel.
	 * 
	 * Adds 'LC Page Kit' and 'LC Header Footer kit' and reorders them to appear at the top.
	 *
	 * @since 1.0.0
	 * @param \Elementor\Elements_Manager $elements_manager The Elementor elements manager instance.
	 * @return void
	 */
	public function register_categories( $elements_manager ) {
		$elements_manager->add_category(
			'lcake-page-kit',
			array(
				'title' => __( 'LC Page Kit', 'lc-addons-kit-for-elementor' ),
				'icon'  => 'eicon-folder',
			)
		);

		$elements_manager->add_category(
			'lc-header-footer-kit',
			array(
				'title' => __( 'LC Header Footer kit', 'lc-addons-kit-for-elementor' ),
				'icon'  => 'eicon-header',
			)
		);

		// Prepend our custom categories to move them to the top of the Elementor panel.
		// We use Closure Binding to safely access and modify the private $categories property of Elements_Manager.
		$reorder = function () {
			if ( isset( $this->categories ) ) {
				$my_categories = array(
					'lcake-page-kit'       => array(
						'title' => __( 'LC Page Kit', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-folder',
					),
					'lc-header-footer-kit' => array(
						'title' => __( 'LC Header Footer kit', 'lc-addons-kit-for-elementor' ),
						'icon'  => 'eicon-header',
					),
				);

				$existing = array_diff_key( $this->categories, $my_categories );

				if ( isset( $existing['favorites'] ) ) {
					$top              = array( 'favorites' => $existing['favorites'] );
					$rest             = array_diff_key( $existing, array( 'favorites' => true ) );
					$this->categories = array_merge( $top, $my_categories, $rest );
				} else {
					$this->categories = array_merge( $my_categories, $existing );
				}
			}
		};

		$bound_reorder = \Closure::bind( $reorder, $elements_manager, $elements_manager );
		if ( $bound_reorder ) {
			$bound_reorder();
		}
	}

	/**
	 * Registers widgets with Elementor based on user settings and unmet dependencies.
	 *
	 * @since 1.0.0
	 * @param \Elementor\Widgets_Manager $widgets_manager The Elementor widgets manager instance.
	 * @return void
	 */
	public function register_widgets( $widgets_manager ) {
		$this->check_all_widget_dependencies();

		// Get the saved list of enabled widget names (IDs) from the database.
		// Returns null if the option has never been saved yet.
		$enabled_widgets = get_option( 'lcake_kit_enabled_widgets', null );
		$widget_data     = $this->load_widget_classes();

		foreach ( $this->active_widgets as $widget_id => $class ) {
			if ( ! isset( $widget_data[ $widget_id ] ) ) {
				continue;
			}

			$data        = $widget_data[ $widget_id ];
			$widget_name = $data['name'];
			$folder      = $data['folder'];

			// If no specific selection saved (first run / never saved), register all by default
			if ( $enabled_widgets === null ) {
				$widgets_manager->register( new $class() );
				continue;
			}

			// Otherwise, only register if enabled in settings. Accept the legacy bare
			// filename too (pre-composite-ID saves only ever covered the lc-kit folder).
			$is_enabled = is_array( $enabled_widgets ) && (
				in_array( $widget_id, $enabled_widgets, true )
				|| ( 'lc-kit' === $folder && in_array( $widget_name, $enabled_widgets, true ) )
			);

			if ( $is_enabled ) {
				$widgets_manager->register( new $class() );
			}
		}
	}
	public function register_widget_scripts() {
		$this->check_all_widget_dependencies();

		if ( ! wp_script_is( 'smartmenus', 'registered' ) ) {
			wp_register_script( 'smartmenus', LCAKE_EAK_URL . 'assets/lib/smartmenus/lc-jquery.smartmenus.min.js', array( 'jquery' ), '1.0.1', true );
		}

		$scripts = array(
			'lcake-kit-jquery-event-move'       => array(
				'file'    => 'lc-jquery.event.move.min.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-twentytwenty'            => array(
				'file'    => 'lc-jquery.twentytwenty.min.js',
				'deps'    => array( 'jquery', 'lcake-kit-jquery-event-move' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-image-comparison'        => array(
				'file'    => 'lcake-kit-image-comparison.js',
				'deps'    => array( 'jquery', 'elementor-frontend', 'lcake-kit-twentytwenty' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-tab-js'                  => array(
				'file'    => 'lcake-kit-tab.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-accordion'               => array(
				'file'    => 'lcake-kit-accordion.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-faq-js'                  => array(
				'file'    => 'lcake-kit-faq.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-pie-chart-js'            => array(
				'file'    => 'lcake-kit-pie-chart.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-testimonial-js'          => array(
				'file'    => 'lcake-kit-testimonial.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-progress-bar-js'         => array(
				'file'    => 'lcake-kit-progress-bar.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-team-js'                     => array(
				'file'    => 'lcake-team.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-chart-js'                    => array(
				'file'    => 'lcake-chart.min.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => true,
				'path'    => '',
				'module'  => true,
			),
			'lcake-btsp-js'                     => array(
				'file'    => 'lc-bootstrap.bundle.min.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-dialog-js'                   => array(
				'file'    => 'lc-dialog.min.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-image-accordion'         => array(
				'file'    => 'lcake-kit-image-accordion.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-swiper-js'                   => array(
				'file'    => 'lc-swiper-bundle.min.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-funfact-js'              => array(
				'file'    => 'lcake-kit-funfact.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-countdown-timer-js'      => array(
				'file'    => 'lcake-kit-countdown-timer.js',
				'deps'    => array( 'jquery', 'elementor-frontend', 'lcake-kit-countdown-js' ),
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-countdown-js'            => array(
				'file'    => 'lc-jquery.countdown.min.js',
				'deps'    => array( 'jquery' ),
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-lottie-js'               => array(
				'file'    => 'lcake-kit-lottie.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-fancy-text-js'           => array(
				'file'    => 'lcake-kit-fancy-text.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-svg-draw-js'             => array(
				'file'    => 'lcake-kit-svg-draw.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-code-snippet-js'         => array(
				'file'    => 'lcake-kit-code-snippet.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-filterable-gallery-js'   => array(
				'file'    => 'lcake-kit-filterable-gallery.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-sticky-video-js'         => array(
				'file'    => 'lcake-kit-sticky-video.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-advanced-data-table-js'  => array(
				'file'    => 'lcake-kit-advanced-data-table.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-carousel-js' => array(
				'file'    => 'lcake-kit-woo-product-carousel.js',
				'deps'    => array( 'jquery', 'elementor-frontend', 'lcake-swiper-js' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-images-js'   => array(
				'file'    => 'lcake-kit-woo-product-images.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-type-form-js'            => array(
				'file'    => 'lcake-kit-type-form.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-twitter-feed-js'         => array(
				'file'    => 'lcake-kit-twitter-feed.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-login-register-js'       => array(
				'file'    => 'lcake-kit-login-register.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-event-calendar-js'       => array(
				'file'    => 'lcake-kit-event-calendar.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lc-header-footer-nav-menu-js'      => array(
				'file'    => 'lc-header-footer-nav-menu.js',
				'deps'    => array( 'jquery', 'elementor-frontend', 'smartmenus' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lc-header-footer-search-toggle-js' => array(
				'file'    => 'lc-header-footer-search-toggle.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
			'lc-header-footer-cart-icon-js'     => array(
				'file'    => 'lc-header-footer-cart-icon.js',
				'deps'    => array( 'jquery', 'elementor-frontend' ),
				'enqueue' => false,
				'path'    => '',
			),
		);

		if ( ! empty( $this->excluded_scripts ) ) {
			$scripts = array_diff_key( $scripts, array_flip( $this->excluded_scripts ) );
		}

		LCAKE_Kit_Utils::lcake_file_enqueue( $scripts, 'script' );
	}

	public function enqueue_editor_styles() {
		wp_enqueue_style(
			'lcake-kit-editor-css',
			LCAKE_EAK_URL . 'assets/css/lcake-editor.css',
			array(),
			LCAKE_EAK_VERSION
		);
	}

	public function register_widget_styles() {
		$this->check_all_widget_dependencies();

		$styles = array(
			'lcake-kit-twentytwenty'                      => array(
				'file'    => 'lc-twentytwenty.min.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-accordion'                         => array(
				'file'    => 'lcake-kit-accordion.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-button'                            => array(
				'file'    => 'lcake-kit-button.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-business-hours'                    => array(
				'file'    => 'lcake-kit-business-hours.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-price-table'                       => array(
				'file'    => 'lcake-kit-price-table.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-social-icons'                      => array(
				'file'    => 'lcake-kit-social-icons.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-image-comparison'                  => array(
				'file'    => 'lcake-kit-image-comparison.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-faq-css'                           => array(
				'file'    => 'lcake-kit-faq.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-pie-chart-css'                     => array(
				'file'    => 'lceak-kit-pie-chart.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-testimonial-css'                   => array(
				'file'    => 'lcake-kit-testimonial.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-team-css'                              => array(
				'file'    => 'lcake-team.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-tab-css'                           => array(
				'file'    => 'lcake-kit-tab.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-progress-bar-css'                  => array(
				'file'    => 'lcake-kit-progress-bar.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-btsp-css'                              => array(
				'file'    => 'lc-bootstrap.min.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-swiper-css'                            => array(
				'file'    => 'lc-swiper-bundle.min.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcakeicons'                                  => array(
				'file'    => 'lcakeicons.css',
				'enqueue' => true,
				'path'    => 'assets/icons',
			),
			'lcake-kit-image-accordion'                   => array(
				'file'    => 'lcake-kit-image-accordion.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-countdown-timer-css'               => array(
				'file'    => 'lcake-kit-countdown-timer.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-drop-caps-css'                     => array(
				'file'    => 'lcake-kit-drop-caps.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-heading-css'                       => array(
				'file'    => 'lcake-kit-heading.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-image-box-css'                     => array(
				'file'    => 'lcake-kit-image-box.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-icon-box-css'                      => array(
				'file'    => 'lcake-kit-icon-box.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-lottie-css'                        => array(
				'file'    => 'lcake-kit-lottie.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-video-css'                         => array(
				'file'    => 'lcake-kit-video.css',
				'enqueue' => true,
				'path'    => '',
			),
			'lcake-kit-breadcrumbs-css'                   => array(
				'file'    => 'lcake-kit-breadcrumbs.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-cta-box-css'                       => array(
				'file'    => 'lcake-kit-cta-box.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-flip-box-css'                      => array(
				'file'    => 'lcake-kit-flip-box.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-feature-list-css'                  => array(
				'file'    => 'lcake-kit-feature-list.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-tooltip-css'                       => array(
				'file'    => 'lcake-kit-tooltip.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-dual-color-header-css'             => array(
				'file'    => 'lcake-kit-dual-color-header.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-fancy-text-css'                    => array(
				'file'    => 'lcake-kit-fancy-text.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-content-ticker-css'                => array(
				'file'    => 'lcake-kit-content-ticker.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-simple-menu-css'                   => array(
				'file'    => 'lcake-kit-simple-menu.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-svg-draw-css'                      => array(
				'file'    => 'lcake-kit-svg-draw.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-code-snippet-css'                  => array(
				'file'    => 'lcake-kit-code-snippet.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-interactive-circle-css'            => array(
				'file'    => 'lcake-kit-interactive-circle.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-filterable-gallery-css'            => array(
				'file'    => 'lcake-kit-filterable-gallery.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-nft-gallery-css'                   => array(
				'file'    => 'lcake-kit-nft-gallery.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-sticky-video-css'                  => array(
				'file'    => 'lcake-kit-sticky-video.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-post-grid-css'                     => array(
				'file'    => 'lcake-kit-post-grid.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-post-timeline-css'                 => array(
				'file'    => 'lcake-kit-post-timeline.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-data-table-css'                    => array(
				'file'    => 'lcake-kit-data-table.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-advanced-data-table-css'           => array(
				'file'    => 'lcake-kit-advanced-data-table.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-business-reviews-css'              => array(
				'file'    => 'lcake-kit-business-reviews.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-product-grid-css'                  => array(
				'file'    => 'lcake-kit-product-grid.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-list-css'              => array(
				'file'    => 'lcake-kit-woo-product-list.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-carousel-css'          => array(
				'file'    => 'lcake-kit-woo-product-carousel.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-title-css'             => array(
				'file'    => 'lcake-kit-woo-product-title.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-price-css'             => array(
				'file'    => 'lcake-kit-woo-product-price.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-rating-css'            => array(
				'file'    => 'lcake-kit-woo-product-rating.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-short-description-css' => array(
				'file'    => 'lcake-kit-woo-product-short-description.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-description-css'       => array(
				'file'    => 'lcake-kit-woo-product-description.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-tabs-css'              => array(
				'file'    => 'lcake-kit-woo-product-tabs.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-gallery-css'           => array(
				'file'    => 'lcake-kit-woo-product-gallery.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-images-css'            => array(
				'file'    => 'lcake-kit-woo-product-images.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-add-to-cart-css'               => array(
				'file'    => 'lcake-kit-woo-add-to-cart.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-cart-css'                      => array(
				'file'    => 'lcake-kit-woo-cart.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-checkout-css'                  => array(
				'file'    => 'lcake-kit-woo-checkout.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-woo-product-compare-css'           => array(
				'file'    => 'lcake-kit-woo-product-compare.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-gravity-forms-css'                 => array(
				'file'    => 'lcake-kit-gravity-forms.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-ninja-forms-css'                   => array(
				'file'    => 'lcake-kit-ninja-forms.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-wp-forms-css'                      => array(
				'file'    => 'lcake-kit-wp-forms.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-fluent-form-css'                   => array(
				'file'    => 'lcake-kit-fluent-form.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-we-forms-css'                      => array(
				'file'    => 'lcake-kit-we-forms.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-formstack-css'                     => array(
				'file'    => 'lcake-kit-formstack.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-type-form-css'                     => array(
				'file'    => 'lcake-kit-type-form.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-mailchimp-css'                     => array(
				'file'    => 'lcake-kit-mailchimp.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-facebook-feed-css'                 => array(
				'file'    => 'lcake-kit-facebook-feed.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-twitter-feed-css'                  => array(
				'file'    => 'lcake-kit-twitter-feed.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-login-register-css'                => array(
				'file'    => 'lcake-kit-login-register.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-event-calendar-css'                => array(
				'file'    => 'lcake-kit-event-calendar.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-embed-press-css'                   => array(
				'file'    => 'lcake-kit-embed-press.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-betterdocs-category-box-css'       => array(
				'file'    => 'lcake-kit-betterdocs-category-box.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-betterdocs-category-grid-css'      => array(
				'file'    => 'lcake-kit-betterdocs-category-grid.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lcake-kit-betterdocs-search-form-css'        => array(
				'file'    => 'lcake-kit-betterdocs-search-form.css',
				'enqueue' => false,
				'path'    => '',
			),

			'lc-header-footer-site-logo-css'              => array(
				'file'    => 'lc-header-footer-site-logo.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lc-header-footer-site-title-css'             => array(
				'file'    => 'lc-header-footer-site-title.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lc-header-footer-nav-menu-css'               => array(
				'file'    => 'lc-header-footer-nav-menu.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lc-header-footer-search-toggle-css'          => array(
				'file'    => 'lc-header-footer-search-toggle.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lc-header-footer-cart-icon-css'              => array(
				'file'    => 'lc-header-footer-cart-icon.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lc-header-footer-contact-info-css'           => array(
				'file'    => 'lc-header-footer-contact-info.css',
				'enqueue' => false,
				'path'    => '',
			),
			'lc-header-footer-copyright-text-css'         => array(
				'file'    => 'lc-header-footer-copyright-text.css',
				'enqueue' => false,
				'path'    => '',
			),
		);

		if ( ! empty( $this->excluded_styles ) ) {
			$styles = array_diff_key( $styles, array_flip( $this->excluded_styles ) );
		}

		LCAKE_Kit_Utils::lcake_file_enqueue( $styles, 'style' );
	}
}
