<?php

namespace StarterKit\Controller;

use StarterKit\Helper\Utils;

/**
 * Class security
 *
 * Provides some security options
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.1.0
 * @since      Class available since Release 1.1.0
 */
class Security {

	public function __construct() {

		add_action( 'init', function () {
			if ( ! Utils::get_option( 'enable_xmlrpc', false ) ) {
				$this->disable_xmlrpc();
			}

			if ( Utils::get_option( 'disable_trackbacks', false ) ) {
				$this->disable_trackbacks();
			}
		} );
	}

	/**
	 * Disables xmlrpc
	 */
	public function disable_xmlrpc() {
		add_filter( 'xmlrpc_enabled', '__return_false' );
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


}