<?php
namespace StarterKit\Controller;

use Facebook\Exceptions\FacebookSDKException;

/**
 * Oauth support
 *
 * Controller which add support of Oauth authorization
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class OAuth {

	/**
	 * Constructor
	 **/
	public function __construct() {

		add_action( 'template_redirect', array( $this, 'check_request' ) );

	}

	/**
	 * Check $_GET['oauth'] / $_GET['oauth-callback'] parameter in request
	 **/
	public function check_request() {

		if ( ! session_id() ) {
			@session_start();
		}

		$allowed_methods = array(
			'facebook' => array(
				'auth'     => array( $this, 'auth_facebook' ),
				'callback' => array( $this, 'callback_facebook' ),
			),
			'google'   => array(
				'auth'     => array( $this, 'auth_google' ),
				'callback' => array( $this, 'callback_google' ),
			),
			'twitter'  => array(
				'auth'     => array( $this, 'auth_twitter' ),
				'callback' => array( $this, 'callback_twitter' ),
			),
		);

		if ( isset( $_GET['oauth'] ) && array_key_exists( $_GET['oauth'], $allowed_methods ) ) {

			call_user_func( $allowed_methods[ $_GET['oauth'] ]['auth'] );

		} elseif ( isset( $_GET['oauth-callback'] ) && array_key_exists( $_GET['oauth-callback'], $allowed_methods ) ) {

			call_user_func( $allowed_methods[ $_GET['oauth-callback'] ]['callback'] );

		}

	}

	/**
	 * Auth using Facebook
	 **/
	public function auth_facebook() {

		require_once get_template_directory() . '/vendor/oauth/facebook/autoload.php';

		$fb = new \Facebook\Facebook( [
			'app_id'     => \StarterKit\Helper\Utils::get_option( 'facebook_app_id' ),
			'app_secret' => \StarterKit\Helper\Utils::get_option( 'facebook_app_secret' ),
		] );

		$helper = $fb->getRedirectLoginHelper();

		$permissions = [ 'email', 'name', 'first_name', 'last_name' ];

		$redirect_url = $helper->getLoginUrl( add_query_arg( array(
			'oauth-callback' => 'facebook'
		), add_query_arg( 'oauth-callback', 'facebook', get_permalink( get_the_ID() ) ) ) );

		wp_redirect( $redirect_url );

		die;

	}

	/**
	 * Oauth callback for Facebook
	 **/
	public function callback_facebook() {

		require_once get_template_directory() . '/vendor/oauth/facebook/autoload.php';

		try {
			$fb = new \Facebook\Facebook( [
				'app_id'     => \StarterKit\Helper\Utils::get_option( 'facebook_app_id' ),
				'app_secret' => \StarterKit\Helper\Utils::get_option( 'facebook_app_secret' ),
			] );
		} catch ( FacebookSDKException $e ) {
			// When validation fails or other local issues
			//echo 'Facebook SDK returned an error: ' . $e->getMessage();
			//error_log('['.date("H:i:s").']'.'error:'.print_r($e->getMessage(), true)."\n", 3, get_stylesheet_directory().'/errors.log');
			//exit;
		}

		$helper                  = $fb->getRedirectLoginHelper();
		$_SESSION['FBRLH_state'] = $_GET['state'];

		try {
			$accessToken = $helper->getAccessToken();
		} catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
			// When Graph returns an error
			//echo 'Graph returned an error: ' . $e->getMessage();
			//exit;
		} catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
			// When validation fails or other local issues
			//echo 'Facebook SDK returned an error: ' . $e->getMessage();
			//error_log('['.date("H:i:s").']'.'error:'.print_r($e->getMessage(), true)."\n", 3, get_stylesheet_directory().'/errors.log');
			//exit;
		}

		if ( isset( $accessToken ) ) {

			$fb_profile = $fb->get( '/me?fields=id,name,email,first_name,last_name', $accessToken );

			$facebook_user_data = $fb_profile->getGraphUser();

			$user_login = 'fb_' . $facebook_user_data['id'];
			$user_email = '';

			if ( isset( $facebook_user_data['email'] ) && trim( $facebook_user_data['email'] ) == '' ) {
				$user_email = $facebook_user_data['id'] . '@facebook.com';
			} else {
				$user_email = $facebook_user_data['email'];
			}

			$user_full_name = $facebook_user_data['first_name'] . ' ' . $facebook_user_data['last_name'];

			$user_id = $this->_create_user( $user_login, $user_email, $user_full_name );
			$this->_login_user( $user_id );
			wp_safe_redirect( site_url( '/' ) );
			exit();

		}

	}

	/**
	 * Create a user, of auth user if it exists
	 *
	 * @param $user_login
	 * @param $user_email
	 * @param $full_name
	 *
	 * @return int|\WP_Error
	 */
	private function _create_user( $user_login, $user_email, $full_name ) {

		if ( ! username_exists( $user_login ) && ! email_exists( $user_email ) ) {

			$random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
			$user_id         = wp_create_user( $user_login, $random_password, $user_email );

			$name_array = explode( ' ', $full_name );

			wp_update_user( array(
				'ID'            => $user_id,
				'first_name'    => isset( $name_array[0] ) ? $name_array[0] : $full_name,
				'last_name'     => isset( $name_array[1] ) ? $name_array[1] : '',
				'user_nicename' => $full_name,
				'nickname'      => $full_name,
				'display_name'  => $full_name,
			) );

			update_user_meta( $user_id, 'oauth_user', 'yes' );

		} elseif ( username_exists( $user_login ) ) {

			$user    = get_user_by( 'login', $user_login );
			$user_id = $user->ID;

		} elseif ( email_exists( $user_email ) ) {

			$user    = get_user_by( 'email', $user_login );
			$user_id = $user->ID;

		}

		return $user_id;

	}

	/**
	 * Login user
	 *
	 * @param $user_id
	 */
	private function _login_user( $user_id ) {
		wp_clear_auth_cookie();
		wp_set_current_user( $user_id );
		wp_set_auth_cookie( $user_id );
	}

	/**
	 * Google Plus OAuth request
	 **/
	public function auth_google() {

		$client = $this->_get_google_client();

		$auth_url = $client->createAuthUrl();
		wp_redirect( $auth_url );
		exit;

	}

	/**
	 * Create a Google Client
	 **/
	private function _get_google_client() {

		require_once get_template_directory() . '/vendor/oauth/google/vendor/autoload.php';

		$client = new \Google_Client();
		$client->setAuthConfig( [
			'client_id'     => \StarterKit\Helper\Utils::get_option( 'google_client_id' ),
			'client_secret' => \StarterKit\Helper\Utils::get_option( 'google_client_secret' )
		] );

		$client->setRedirectUri( add_query_arg( 'oauth-callback', 'google', get_permalink( get_the_ID() ) ) );

		$client->addScope( \Google_Service_Plus::USERINFO_PROFILE );
		$client->addScope( \Google_Service_Plus::USERINFO_EMAIL );
		$client->addScope( \Google_Service_Plus::PLUS_ME );

		return $client;

	}

	/**
	 * Google Plus OAuth callback
	 **/
	public function callback_google() {

		if ( ! isset( $_REQUEST['error'] ) && isset( $_REQUEST['code'] ) ) {

			$client = $this->_get_google_client();

			$client->authenticate( $_GET['code'] );

			$google_plus = new \Google_Service_Plus( $client );
			$google_user = $google_plus->people->get( 'me' );

			$user_login     = 'gp_' . $google_user->id;
			$user_email     = $google_user->emails[0]['value'];
			$user_full_name = $google_user->displayName;

			$user_id = $this->_create_user( $user_login, $user_email, $user_full_name );
			$this->_login_user( $user_id );
			wp_safe_redirect( site_url( '/' ) );
			exit();

		}

	}

	/**
	 * Twitter OAuth request
	 **/
	public function auth_twitter() {

		require_once get_template_directory() . '/vendor/oauth/twitter/autoload.php';

		$connection = new \Abraham\TwitterOAuth\TwitterOAuth(
			\StarterKit\Helper\Utils::get_option( 'twitter_consumer_key' ),
			\StarterKit\Helper\Utils::get_option( 'twitter_consumer_secret' )
		);

		$temporary_credentials = $connection->oauth(
			'oauth/request_token',
			[
				"oauth_callback" => add_query_arg(
					[
						'oauth-callback' => 'twitter',
						'oauth-token'    => $temporary_credentials['oauth_token'],
					], get_permalink( get_the_ID() ) )
			]
		);

		$auth_url = $connection->url( "oauth/authorize",
			array( "oauth_token" => $temporary_credentials['oauth_token'] ) );
		wp_redirect( $auth_url );
		exit;

	}

	/**
	 * Twitter OAuth callback
	 **/
	public function callback_twitter() {

		if ( isset( $_GET['denied'] ) ) {
			wp_safe_redirect( site_url( '/' ) );
			exit;
		}

		require_once get_template_directory() . '/vendor/oauth/twitter/autoload.php';

		$oauth_token     = $_GET['oauth-token'];
		$consumer_key    = \StarterKit\Helper\Utils::get_option( 'twitter_consumer_key' );
		$consumer_secret = \StarterKit\Helper\Utils::get_option( 'twitter_consumer_secret' );

		$connection = new \Abraham\TwitterOAuth\TwitterOAuth( $consumer_key, $consumer_secret );

		$params = array(
			'oauth_verifier' => $_GET['oauth_verifier'],
			'oauth_token'    => $_GET['oauth_token']
		);

		$access_token = $connection->oauth( "oauth/access_token", $params );

		//now again create new instance using updated return oauth_token and oauth_token_secret because old one expired if u dont u this u will also get token expired error
		$connection = new \Abraham\TwitterOAuth\TwitterOAuth(
			$consumer_key,
			$consumer_secret,
			$access_token['oauth_token'],
			$access_token['oauth_token_secret']
		);

		$twitter_user = $connection->get( "account/verify_credentials" );

		$user_login     = 't_' . $twitter_user->id;
		$user_email     = isset( $twitter_user->email ) ? $twitter_user->email : $twitter_user->id . '@twitter.com';
		$user_full_name = $twitter_user->name;

		$user_id = $this->_create_user( $user_login, $user_email, $user_full_name );
		$this->_login_user( $user_id );
		wp_safe_redirect( site_url( '/' ) );
		exit();

	}

}
