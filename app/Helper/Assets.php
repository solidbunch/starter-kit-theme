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
	 * Enqueue shortcode style
	 *
	 * @param $handle
	 * @param string $src
	 * @param array $deps
	 * @param mixed $ver
	 * @param string $media
	 */
	public static function enqueue_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
		if ( $ver === false ) {
			/** @var int $ver - timestamp */
			$ver = filemtime( get_stylesheet_directory() . '/dist/css/' . $src );
		}

		$src = get_stylesheet_directory_uri() . '/dist/css/' . $src;

		wp_enqueue_style( $handle, $src, $deps, $ver, $media );
	}

	/**
	 * Enqueue shortcode script
	 *
	 * @param $handle
	 * @param string $src
	 * @param array $deps
	 * @param mixed $ver
	 * @param bool $in_footer
	 */
	public static function enqueue_script( $handle, $src = '', $deps = array(), $ver = false, $in_footer = false ) {
		if ( $ver === false ) {
			/** @var int $ver - timestamp */
			$ver = filemtime( get_stylesheet_directory() . '/dist/js/' . $src );
		}

		$src = get_stylesheet_directory_uri() . '/dist/js/' . $src;

		wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
	}
}
