<?php

namespace StarterKit\Handlers;

use StarterKit\Helper\Utils;

/**
 * Optimization Handlers
 *
 * removes unnecessary tags etc.
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Optimization {
	
	public function init() {
		if ( ! is_admin() ) {
			if ( Utils::get_option( 'clean_wp_head', false ) ) {
				$this->head_cleanup();
			}

			if ( Utils::get_option( 'assets_versions', false ) ) {
				$this->assets_versions();
			}
			
			if ( Utils::get_option( 'remove_self_closing_tags', false ) ) {
				$this->_remove_self_closing_tags();
			}
			
			if ( Utils::get_option( 'add_embed_wrap', false ) ) {
				$this->add_embed_wrap();
			}
		}
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
		//Disable feed
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		//Need to feed returns 404
		add_action('do_feed_rdf',  [ $this, 'feed_404' ], 0);
		add_action('do_feed_rss',  [ $this, 'feed_404' ], 0);
		add_action('do_feed_rss2',  [ $this, 'feed_404' ], 0);
		add_action('do_feed_atom',  [ $this, 'feed_404' ], 0);

		//Clean header with ob
		add_action( 'wp_head', 'ob_start', 0, 0 );
		add_action( 'wp_head',  [ $this, 'clean_and_ob_end_clean' ], PHP_INT_MAX, 0 );

		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
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
		add_filter( 'the_generator', '__return_false' );
	}

	/**
	 * Clean up wp_head()
	 *
	 * Remove all 'generator' tags
	 *
	 */
	public function clean_and_ob_end_clean() {

		//Remove all 'generator' tags
		echo preg_replace( '/<meta name(.*)=(.*)"generator"(.*)>/i', '', ob_get_clean() );

	}

	/**
	 * All feed returns 404
	 */
	public function feed_404() {

		global $wp_query;
		$wp_query->set_404();
		status_header(404);
		nocache_headers();
		echo '<?xml version="1.0" encoding="UTF-8" ?><status>' .  __( 'Service unavailable.', 'starter-kit' ) . '</status>';
		exit;

	}
	
	/**
	 * Add embed wrap
	 */
	public function add_embed_wrap() {
		
		add_filter( 'embed_oembed_html', [ $this, 'embed_wrap' ] );
		
	}
	
	/**
	 * Remove self closing tags
	 */
	public function _remove_self_closing_tags() {
		
		add_filter( 'get_avatar', [ $this, 'remove_self_closing_tags' ] ); // <img />
		add_filter( 'comment_id_fields', [ $this, 'remove_self_closing_tags' ] ); // <input />
		add_filter( 'post_thumbnail_html', [ $this, 'remove_self_closing_tags' ] ); // <img />
		
	}
	
	/**
	 * Remove assets versions
	 */
	public function assets_versions() {
		
		add_filter( 'script_loader_src', [ $this, 'remove_script_version' ], 15, 1 );
		add_filter( 'style_loader_src', [ $this, 'remove_script_version' ], 15, 1 );
		
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
		return '<div class="embed-wrapper">' . $cache . '</div>';
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
	 * Remove version query string from all styles and scripts
	 */
	public function remove_script_version( $src ) {
		return $src ? esc_url( remove_query_arg( 'ver', $src ) ) : false;
	}
}
