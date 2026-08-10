<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LCAKE_Kit_Dependency_Checker {

	/**
	 * Check if all dependencies are active and available.
	 *
	 * @param array $dependencies Array of dependency definitions.
	 * @return bool True if all dependencies are met, false otherwise.
	 */
	public static function check( $dependencies ) {
		if ( empty( $dependencies ) || ! is_array( $dependencies ) ) {
			return true;
		}

		foreach ( $dependencies as $dependency ) {
			if ( ! self::check_single( $dependency ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Check a single dependency.
	 *
	 * @param array $dependency Dependency definition.
	 * @return bool True if dependency is met, false otherwise.
	 */
	public static function check_single( $dependency ) {
		if ( empty( $dependency['type'] ) ) {
			return false;
		}

		$type = $dependency['type'];

		// Extension hook
		$pre_check = apply_filters( "lcake_kit_check_dependency_{$type}", null, $dependency );
		if ( $pre_check !== null ) {
			return (bool) $pre_check;
		}

		switch ( $type ) {
			case 'plugin':
				return self::check_plugin( $dependency );
			case 'post_type':
				return self::check_post_type( $dependency );
			case 'php':
				return self::check_php( $dependency );
			case 'WordPress':
				return self::check_wordpress( $dependency );
			case 'elementor':
				return self::check_elementor( $dependency );
			default:
				return false;
		}
	}

	/**
	 * Check if a plugin dependency is met.
	 */
	private static function check_plugin( $dependency ) {
		if ( ! empty( $dependency['class'] ) && class_exists( $dependency['class'] ) ) {
			return true;
		}

		if ( ! empty( $dependency['function'] ) && function_exists( $dependency['function'] ) ) {
			return true;
		}

		if ( ! empty( $dependency['constant'] ) && defined( $dependency['constant'] ) ) {
			return true;
		}

		if ( ! empty( $dependency['path'] ) ) {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			if ( is_plugin_active( $dependency['path'] ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a post type dependency is met.
	 */
	private static function check_post_type( $dependency ) {
		if ( empty( $dependency['post_type'] ) ) {
			return false;
		}
		return post_type_exists( $dependency['post_type'] );
	}

	/**
	 * Check PHP version.
	 */
	private static function check_php( $dependency ) {
		if ( empty( $dependency['version'] ) ) {
			return true;
		}
		$operator = $dependency['operator'] ?? '>=';
		return version_compare( PHP_VERSION, $dependency['version'], $operator );
	}

	/**
	 * Check WordPress version.
	 */
	private static function check_wordpress( $dependency ) {
		if ( empty( $dependency['version'] ) ) {
			return true;
		}
		global $wp_version;
		$operator = $dependency['operator'] ?? '>=';
		return version_compare( $wp_version, $dependency['version'], $operator );
	}

	/**
	 * Check Elementor version.
	 */
	private static function check_elementor( $dependency ) {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return false;
		}
		if ( empty( $dependency['version'] ) ) {
			return true;
		}
		$operator = $dependency['operator'] ?? '>=';
		return version_compare( ELEMENTOR_VERSION, $dependency['version'], $operator );
	}
}
