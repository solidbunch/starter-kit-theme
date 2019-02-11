<?php

namespace StarterKit\Helper;

/**
 * Assets
 *
 * Helper to work with assets processed by webpack
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Assets {

	/**
	 * Enqueue style from dist folder
	 *
	 * @param $handle
	 * @param string $src
	 * @param array $deps
	 * @param mixed $ver
	 * @param string $media
	 */
	public static function enqueue_style_dist(
		$handle,
		$src = '',
		$deps = array(),
		$ver = false,
		$media = 'all'
	) {
		self::enqueue_style( $handle, 'dist/css/' . $src, $deps, $ver, $media );
	}

	/**
	 * Enqueue style
	 *
	 * @param $handle
	 * @param string $src
	 * @param array $deps
	 * @param mixed $ver
	 * @param string $media
	 */
	public static function enqueue_style(
		$handle,
		$src = '',
		$deps = array(),
		$ver = false,
		$media = 'all'
	) {
		if ( !self::isFullUrl( $src, false ) ) {
			$stylePath = get_stylesheet_directory() . '/' . $src;
			if ( file_exists( $stylePath ) ) {
				$ver = self::add_version( $stylePath, $ver );
				/** @var string|bool $src */
				$src = self::isFullUrl( $src );

			}
		}
		wp_enqueue_style( $handle, $src, $deps, $ver, $media );
	}

	/**
	 * Check is $src is url
	 *
	 * @param string $src
	 *
	 * @param bool $returnUrl
	 *
	 * @return bool|string
	 */
	protected static function isFullUrl( $src, $returnUrl = true ) {
		$filter = filter_var( $src, FILTER_VALIDATE_URL );
		if ( ! $returnUrl ) {
			return $filter ? true : false;
		}

		return $filter ? $src : get_stylesheet_directory_uri() . '/' . $src;
	}

	/**
	 * set timestamp to $ver var if false provided
	 *
	 * @param $srcPath
	 * @param $ver
	 *
	 * @return int
	 */
	protected static function add_version( $srcPath, $ver ) {
		$remove_versions = utils::get_option( 'assets_versions', false );
		if ( $ver === false && ! $remove_versions ) {
			/** @var int $ver - timestamp */
			$ver = filemtime( $srcPath );
		}

		return $ver;
	}

	/**
	 * register script for usage in future
	 *
	 * @param $handle
	 * @param string $src
	 * @param array $deps
	 * @param mixed $ver
	 * @param bool $in_footer
	 */
	public static function register_script(
		$handle,
		$src = '',
		$deps = array(),
		$ver = false,
		$in_footer = false
	) {
		if ( !self::isFullUrl( $src, false ) ) {
			$scriptPath = get_stylesheet_directory() . '/' . $src;
			$ver        = self::add_version( $scriptPath, $ver );
			if ( file_exists( $scriptPath ) ) {
				$src = self::isFullUrl( $src );
			}
		}
		wp_register_script( $handle, $src, $deps, $ver, $in_footer );
	}

	/**
	 * register style for usage in future
	 *
	 * @param $handle
	 * @param string $src
	 * @param array $deps
	 * @param mixed $ver
	 * @param string $media
	 */
	public static function register_style(
		$handle,
		$src = '',
		$deps = array(),
		$ver = false,
		$media = 'all'
	) {
		if ( !self::isFullUrl( $src, false ) ) {
			$stylePath = get_stylesheet_directory() . '/' . $src;
			if ( file_exists( $stylePath ) ) {
				$ver = self::add_version( $stylePath, $ver );
				$src = self::isFullUrl( $src );
			}
		}
		wp_register_style( $handle, $src, $deps, $ver, $media );
	}

	/**
	 * Enqueue script from dist folder
	 *
	 * @param $handle
	 * @param string $src
	 * @param array $deps
	 * @param mixed $ver
	 * @param bool $in_footer
	 */
	public static function enqueue_script_dist(
		$handle,
		$src = '',
		$deps = array(),
		$ver = false,
		$in_footer = false
	) {
		self::enqueue_script( $handle, 'dist/js/' . $src, $deps, $ver, $in_footer );
	}

	/**
	 * Enqueue script
	 *
	 * @param $handle
	 * @param string $src
	 * @param array $deps
	 * @param mixed $ver
	 * @param bool $in_footer
	 */
	public static function enqueue_script(
		$handle,
		$src = '',
		$deps = array(),
		$ver = false,
		$in_footer = false
	) {
		if ( !self::isFullUrl( $src, false ) ) {
			$scriptPath = get_stylesheet_directory() . '/' . $src;
			if ( file_exists( $scriptPath ) ) {
				$ver = self::add_version( $scriptPath, $ver );
				$src = self::isFullUrl( $src );
			}
		}
		wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
	}

	/**
	 * Add inline script
	 *
	 * @param $handle
	 * @param $data
	 * @param string $position
	 */
	public static function add_inline_script( $handle, $data, $position = 'after' ) {
		wp_add_inline_script( $handle, $data, $position );
	}

	/**
	 * Localize script
	 *
	 * @param $handle
	 * @param $object_name
	 * @param $l10n
	 */
	public static function localize_script( $handle, $object_name, $l10n ) {
		wp_localize_script( $handle, $object_name, $l10n );
	}

	/**
	 * Add inline style
	 *
	 * @param $handler
	 * @param $style
	 */
	public static function add_inline_style( $handler, $style ) {
		wp_add_inline_style( $handler , $style );
	}
}
