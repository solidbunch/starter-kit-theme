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
		self::enqueue_style( $handle, '/dist/css' . $src, $deps, $ver, $media );
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
		$src = get_stylesheet_directory_uri() . '/' . $src;
		$ver = self::add_version( $src, $ver );

		if ( file_exists( $src ) ) {
			wp_enqueue_style( $handle, $src, $deps, $ver, $media );
		}
	}

	/**
	 * set timestamp to $ver var if false provided
	 *
	 * @param $src
	 * @param $ver
	 *
	 * @return int
	 */
	protected static function add_version( $src, $ver ) {
		$remove_versions = utils::get_option( 'assets_versions', false );
		if ( $ver === false && file_exists( $src ) && ! $remove_versions ) {
			/** @var int $ver - timestamp */
			$ver = filemtime( $src );
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
		$src = get_stylesheet_directory_uri() . '/' . $src;
		$ver = self::add_version( $src, $ver );
		if ( file_exists( $src ) ) {
			wp_register_script( $handle, $src, $deps, $ver, $in_footer );
		}
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
		$src = get_stylesheet_directory_uri() . '/' . $src;
		$ver = self::add_version( $src, $ver );

		if ( file_exists( $src ) ) {
			wp_register_style( $handle, $src, $deps, $ver, $media );
		}
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
		self::enqueue_script( $handle, '/dist/js' . $src, $deps, $ver, $in_footer );
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
		$src = get_stylesheet_directory_uri() . '/' . $src;
		$ver = self::add_version( $src, $ver );
		if ( file_exists( $src ) ) {
			wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
		}
	}
}
