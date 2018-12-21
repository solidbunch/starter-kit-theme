<?php
namespace StarterKit\Controller;

use StarterKit\Helper\Utils;

/**
 * Class optimization
 *
 * Controller which removes unnecessary tags
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.1
 * @since      Class available since Release 1.0.1
 */
class Optimization {

	public function __construct() {

		add_action( 'init', function () {
			if ( utils::get_option( 'clean_wp_head', false ) ) {
				$this->head_cleanup();
			}
			if ( utils::get_option( 'disable_trackbacks', false ) ) {
				$this->disable_trackbacks();
			}

			if ( utils::get_option( 'assets_versions', false ) ) {
				add_filter( 'script_loader_src', [ $this, 'remove_script_version' ], 15, 1 );
				add_filter( 'style_loader_src', [ $this, 'remove_script_version' ], 15, 1 );
			}
		} );
	}

	/**
	 * Clean up wp_head()
	 *
	 * Remove unnecessary <link>'s
	 * Remove inline CSS and JS from WP emoji support
	 * Remove inline CSS used by Recent Comments widget
	 * Remove inline CSS used by posts with galleries
	 * Remove self-closing tag
	 */
	public function head_cleanup() {
		// Originally from http://wpengineer.com/1438/wordpress-header/
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		add_action( 'wp_head', 'ob_start', 1, 0 );
		add_action( 'wp_head', function () {
			$pattern = '/.*';
			$pattern .= preg_quote( esc_url( get_feed_link( 'comments_' . get_default_feed() ) ), '/' );
			$pattern .= '.*[\r\n]+/';
			echo preg_replace( $pattern, '', ob_get_clean() );
		}, 3, 0 );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_generator' );
		if ( function_exists( 'visual_composer' ) ) {
			remove_action( 'wp_head', array( visual_composer(), 'addMetaData' ) );
		}
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'use_default_gallery_style', '__return_false' );
		add_filter( 'emoji_svg_url', '__return_false' );
		add_filter( 'show_recent_comments_widget_style', '__return_false' );
		add_filter( 'embed_oembed_html', [ $this, 'embed_wrap' ] );
		add_filter( 'the_generator', '__return_false' );
		add_filter( 'style_loader_tag', [ $this, 'clean_style_tag' ] );
		add_filter( 'get_avatar', [ $this, 'remove_self_closing_tags' ] ); // <img />
		add_filter( 'comment_id_fields', [ $this, 'remove_self_closing_tags' ] ); // <input />
		add_filter( 'post_thumbnail_html', [ $this, 'remove_self_closing_tags' ] ); // <img />
		add_filter( 'get_bloginfo_rss', [ $this, 'remove_default_description' ] );
	}

	/**
	 * Disables trackbacks/pingbacks
	 */
	public function disable_trackbacks() {
		add_filter( 'xmlrpc_methods', [ $this, 'filter_xmlrpc_method' ], 10, 1 );
		add_filter( 'wp_headers', [ $this, 'filter_headers' ], 10, 1 );
		add_filter( 'rewrite_rules_array', [ $this, 'filter_rewrites' ] );
		add_filter( 'bloginfo_url', [ $this, 'kill_pingback_url' ], 10, 2 );
		add_action( 'xmlrpc_call', [ $this, 'kill_xmlrpc' ] );
	}

	/**
	 * Clean up output of stylesheet <link> tags
	 */
	public function clean_style_tag( $input ) {
		preg_match_all(
			"!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!",
			$input,
			$matches
		);
		if ( empty( $matches[2] ) ) {
			return $input;
		}
		// Only display media if it is meaningful
		$media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';

		return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
	}

	/**
	 * Clean up output of <script> tags
	 *
	 * @param $input
	 *
	 * @return mixed
	 */
	public function clean_script_tag( $input ) {
		return str_replace( array( "type='text/javascript' ", "'" ), array( '', '"' ), $input );
	}

	/**
	 * Wrap embedded media as suggested by Readability
	 *
	 * @link https://gist.github.com/965956
	 * @link http://www.readability.com/publishers/guidelines#publisher
	 *
	 * @param $cache
	 *
	 * @return string
	 */
	public function embed_wrap( $cache ) {
		return '<div class="entry-content-asset">' . $cache . '</div>';
	}

	/**
	 * Remove unnecessary self-closing tags
	 *
	 * @param $input
	 *
	 * @return mixed
	 */
	public function remove_self_closing_tags( $input ) {
		return str_replace( ' />', '>', $input );
	}

	/**
	 * Don't return the default description in the RSS feed if it hasn't been changed
	 *
	 * @param $bloginfo
	 *
	 * @return string
	 */
	public function remove_default_description( $bloginfo ) {
		$default_tagline = 'Just another WordPress site';

		return ( $bloginfo === $default_tagline ) ? '' : $bloginfo;
	}

	/**
	 * Disable pingback XMLRPC method
	 *
	 * @param $methods
	 *
	 * @return mixed
	 */
	public function filter_xmlrpc_method( $methods ) {
		unset( $methods['pingback.ping'] );

		return $methods;
	}

	/**
	 * Remove pingback header
	 *
	 * @param $headers
	 *
	 * @return mixed
	 */
	public function filter_headers( $headers ) {
		if ( isset( $headers['X-Pingback'] ) ) {
			unset( $headers['X-Pingback'] );
		}

		return $headers;
	}

	/**
	 * Kill trackback rewrite rule
	 *
	 * @param $rules
	 *
	 * @return mixed
	 */
	public function filter_rewrites( $rules ) {
		foreach ( $rules as $rule => $rewrite ) {
			if ( preg_match( '/trackback\/\?\$$/i', $rule ) ) {
				unset( $rules[ $rule ] );
			}
		}

		return $rules;
	}

	/**
	 * Kill bloginfo('pingback_url')
	 *
	 * @param $output
	 * @param $show
	 *
	 * @return string
	 */
	public function kill_pingback_url( $output, $show ) {
		if ( $show === 'pingback_url' ) {
			$output = '';
		}

		return $output;
	}

	/**
	 * Disable XMLRPC call
	 *
	 * @param $action
	 */
	public function kill_xmlrpc( $action ) {
		if ( $action === 'pingback.ping' ) {
			wp_die( 'Pingbacks are not supported', 'Not Allowed!', [ 'response' => 403 ] );
		}
	}

	/**
	 * Remove version query string from all styles and scripts
	 */
	public function remove_script_version( $src ) {
		return $src ? esc_url( remove_query_arg( 'ver', $src ) ) : false;
	}
}
