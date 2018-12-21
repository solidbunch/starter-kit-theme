<?php
namespace StarterKit\Controller;

use StarterKit\Helper\Utils;

/**
 * Class HTTP2
 *
 * Controller which add supports of HTTP2 server push functionality
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.1
 * @since      Class available since Release 1.0.1
 */
class HTTP2 {

	/**
	 * Cloudflare gives an HTTP 520 error when more than 8k of headers are present. Limiting $this
	 * plugin's output to 4k should keep those errors away.
	 */
	const HTTP2_MAX_HEADER_SIZE = 1024 * 400;
	protected $http2_header_size_accumulator = 0;
	/** @var array */
	protected $assets = [];

	/**
	 * http2_push constructor.
	 */
	public function __construct() {
		add_action( 'init', function () {
			$scripts = utils::get_option( 'http2_scripts_enable', false );
			$styles  = utils::get_option( 'http2_styles_enable', false );

			if ( ( $scripts || $styles ) && ! is_admin() ) {
				$this->http2_ob_start();
				if ( $scripts ) {
					add_filter( 'script_loader_src', array( $this, 'http2_link_preload_header' ), PHP_INT_MAX, 1 );
				}

				if ( $styles ) {
					add_filter( 'style_loader_src', array( $this, 'http2_link_preload_header' ), PHP_INT_MAX, 1 );
				}

				if ( $this->http2_should_render_prefetch_headers() ) {
					add_action( 'wp_head', array( $this, 'http2_resource_hints' ), PHP_INT_MAX, 1 );
				}
			}
		} );

	}

	/**
	 * Determine if the plugin should render its own resource hints, or defer to WordPress.
	 * WordPress natively supports resource hints since 4.6. Can be overridden with
	 * 'http2_render_resource_hints' filter.
	 * @return boolean true if the plugin should render resource hints.
	 */
	public function http2_should_render_prefetch_headers() {
		return apply_filters( 'http2_render_resource_hints', ! function_exists( 'wp_resource_hints' ) );
	}

	/**
	 * Start an output buffer so this plugin can call header() later without errors.
	 * Need to use a function here instead of calling ob_start in the template_redirect
	 * action as WordPress will pass an empty string as the first (only?) parameter
	 * and PHP will try to use that as a function name.
	 */
	public function http2_ob_start() {
		ob_start();
	}

	/**
	 * @param string $src URL
	 *
	 * @return string
	 */
	public function http2_link_preload_header( $src ) {
		if ( strpos( $src, site_url() ) !== false ) {
			$preload_src = apply_filters( 'http2_link_preload_src', $src );
			if ( ! empty( $preload_src ) ) {
				$header = sprintf(
					'Link: <%s>; rel=preload; as=%s',
					esc_url( $this->http2_link_url_to_relative_path( $preload_src ) ),
					sanitize_html_class( $this->http2_link_resource_hint_as( current_filter() ) )
				);
				// Make sure we haven't hit the header limit
				if ( ( $this->http2_header_size_accumulator + strlen( $header ) ) < self::HTTP2_MAX_HEADER_SIZE ) {
					$this->http2_header_size_accumulator += strlen( $header );
					header( $header, false );
				}

				$this->assets[ 'http2_' . $this->http2_link_resource_hint_as( current_filter() ) . '_srcs' ][] = $this->http2_link_url_to_relative_path( $preload_src );

			}
		}

		return $src;
	}

	/**
	 * Convert an URL with authority to a relative path
	 *
	 * @param string $src URL
	 *
	 * @return string mixed relative path
	 */
	public function http2_link_url_to_relative_path( $src ) {
		if ( strpos( $src, '//' ) === 0 ) {
			return preg_replace( '/^\/\/([^\/]*)\//', '/', $src );
		}

		return preg_replace( '/^http(s)?:\/\/[^\/]*/', '', $src );
	}

	/**
	 * Maps a WordPress hook to an "as" parameter in a resource hint
	 *
	 * @param string $current_hook pass current_filter()
	 *
	 * @return string 'style' or 'script'
	 */
	public function http2_link_resource_hint_as( $current_hook ) {
		return 'style_loader_src' === $current_hook ? 'style' : 'script';
	}

	/**
	 * Render "resource hints" in the <head> section of the page. These encourage preload/prefetch behavior
	 * when HTTP/2 support is lacking.
	 */
	public function http2_resource_hints() {
		$resource_types = array( 'script', 'style' );
		array_walk( $resource_types, function ( $resource_type ) {
			$resources = $this->http2_get_resources( $resource_type );
			array_walk( $resources, function ( $src ) use ( $resource_type ) {
				printf( '<link rel="preload" href="%s" as="%s">', esc_url( $src ), esc_html( $resource_type ) );
			} );
		} );
	}

	/**
	 * Get resources of a certain type that have been enqueued through the WordPress API.
	 * Needed because some plugins mangle these global values
	 *
	 * @param string $resource_type resource type (script, style)
	 *
	 * @return array
	 */
	public function http2_get_resources( $resource_type ) {
		$resource_type_key = "http2_{$resource_type}_srcs";

		if ( ! ( is_array( $this->assets ) && isset( $this->assets[ $resource_type_key ] ) ) ) {
			return array();
		}

		if ( ! is_array( $this->assets[ $resource_type_key ] ) ) {
			return array( $this->assets[ $resource_type_key ] );
		}

		return $this->assets[ $resource_type_key ];
	}
}
