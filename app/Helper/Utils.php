<?php

namespace StarterKit\Helper;

/**
 * Utilities
 *
 * Helper functions
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Utils {
	
	/**
	 * Get Theme Option
	 *
	 * @param string $option_name
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_option( $option_name, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$prefix = "_{$prefix}";
		$value  = \get_option( $prefix . $option_name, $default_value );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get Theme Option with framework functionality
	 * for specific cases, reduce performance
	 *
	 * @param string $option_name
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_option_fw( $option_name, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$value  = \carbon_get_theme_option( $prefix . $option_name );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get Network Theme Option
	 *
	 * @param int $site_id
	 * @param string $option_name
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_network_option( $site_id, $option_name, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$prefix = "_{$prefix}";
		$value  = \get_network_option( $site_id, $prefix . $option_name, $default_value );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get Network Theme Option with framework functionality
	 * for specific cases, reduce performance
	 *
	 * @param int $site_id
	 * @param string $option_name
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_network_option_fw( $site_id, $option_name, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$value  = \carbon_get_network_option( $site_id, $prefix . $option_name );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get Post Meta
	 *
	 * @param $post_id
	 * @param string $meta_key
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_post_meta( $post_id, $meta_key, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$prefix = "_{$prefix}";
		$value  = \get_post_meta( $post_id, $prefix . $meta_key, true );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get Post Meta with framework functionality
	 *
	 * @param $post_id
	 * @param string $meta_key
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_post_meta_fw( $post_id, $meta_key, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$value  = \carbon_get_post_meta( $post_id, $prefix . $meta_key );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get Term Meta
	 *
	 * @param $term_id
	 * @param string $meta_key
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_term_meta( $term_id, $meta_key, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$prefix = "_{$prefix}";
		$value  = \get_term_meta( $term_id, $prefix . $meta_key, true );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get Term Meta with framework functionality
	 *
	 * @param $term_id
	 * @param string $meta_key
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_term_meta_fw( $term_id, $meta_key, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$value  = \carbon_get_term_meta( $term_id, $prefix . $meta_key );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get Comment Meta
	 *
	 * @param $comment_id
	 * @param string $meta_key
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_comment_meta( $comment_id, $meta_key, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$prefix = "_{$prefix}";
		$value  = \get_comment_meta( $comment_id, $prefix . $meta_key, true );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get Comment Meta with framework functionality
	 *
	 * @param $comment_id
	 * @param string $meta_key
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_comment_meta_fw( $comment_id, $meta_key, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$value  = \carbon_get_comment_meta( $comment_id, $prefix . $meta_key );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get User Meta
	 *
	 * @param $user_id
	 * @param string $meta_key
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_user_meta( $user_id, $meta_key, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$prefix = "_{$prefix}";
		$value  = \get_user_meta( $user_id, $prefix . $meta_key, true );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Get User Meta with framework functionality
	 *
	 * @param $user_id
	 * @param string $meta_key
	 * @param mixed $default_value
	 *
	 * @return mixed
	 */
	public static function get_user_meta_fw( $user_id, $meta_key, $default_value = null ) {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$value  = \carbon_get_user_meta( $user_id, $prefix . $meta_key );
		
		return $value ?? $default_value;
	}
	
	
	
	/**
	 * Autoload PHP files in directory
	 *
	 * @param $dir
	 * @param int $max_scan_depth
	 * @param string $load_file
	 * @param int $current_depth
	 */
	public static function autoload_dir( $dir, $max_scan_depth = 0, $load_file = '', $current_depth = 0 ) {
		if ( $current_depth > $max_scan_depth ) {
			return;
		}
		
		// require all php files
		$scan = glob( trailingslashit( $dir ) . '*' );
		
		foreach ( $scan as $path ) {
			
			if ( preg_match( '/\.php$/', $path ) ) {
				
				if ( is_string( $load_file ) && $load_file !== '' ) {
					
					// load specific file
					
					$dir  = dirname( $path );
					$file = $dir . '/' . $load_file;
					
					if ( is_file( $file ) ) {
						require_once $file;
					}
					
				} else {
					
					// load all PHP files in folder
					require_once $path;
					
				}
				
			} elseif ( is_dir( $path ) ) {
				
				self::autoload_dir( $path, $max_scan_depth, $load_file, $current_depth + 1 );
				
			}
		}
	}
	
	/**
	 * Make sure that Visual Composer is active
	 **/
	public static function is_vc() {
		return in_array( 'js_composer/js_composer.php',
			\apply_filters( 'active_plugins', \get_option( 'active_plugins' ) ), true );
	}
	
	/**
	 * Make sure that Carbon_Fields Framework is exists
	 **/
	public static function is_carbon_fields() {
		return class_exists( \Carbon_Fields\Carbon_Fields::class );
	}
	
	/**
	 * Make sure that WooCommerce plugin is active
	 **/
	public static function is_woocommerce() {
		return in_array( 'woocommerce/woocommerce.php',
			\apply_filters( 'active_plugins', \get_option( 'active_plugins' ) ), true );
	}
	
	/**
	 * Returns shortcodes uri
	 *
	 * @param $shortcode_name
	 * @param string $path
	 *
	 * @return string
	 */
	public static function get_shortcodes_uri( $shortcode_name, $path = '' ) {
		return trailingslashit( self::getConfigSetting( 'shortcodes_uri' ) ) . $shortcode_name . '/' . $path;
	}
	
	/**
	 * Returns shortcodes path
	 *
	 * @param $shortcode_name
	 * @param string $path
	 *
	 * @return string
	 */
	public static function get_shortcodes_dir( $shortcode_name, $path = '' ) {
		return trailingslashit( self::getConfigSetting( 'shortcodes_dir' ) ) . $shortcode_name . '/' . $path;
	}
	
	/**
	 * Returns widgets uri
	 *
	 * @param $widget_name
	 * @param string $path
	 *
	 * @return string
	 */
	public static function get_widgets_uri( $widget_name, $path = '' ) {
		return trailingslashit( self::getConfigSetting( 'widgets_uri' ) ) . $widget_name . '/' . $path;
	}
	
	/**
	 * Returns widgets path
	 *
	 * @param $widget_name
	 * @param string $path
	 *
	 * @return string
	 */
	public static function get_widgets_dir( $widget_name, $path = '' ) {
		return trailingslashit( self::getConfigSetting( 'widgets_dir' ) ) . $widget_name . '/' . $path;
	}
	
	
	/**
	 * Sanitize text params from array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public static function sanitize_array_text_params( $params ) {
		
		$sanitized_params = array();
		
		foreach ( $params as $k => $v ) {
			
			if ( is_string( $v ) || is_numeric( $v ) ) {
				$sanitized_params[ $k ] = \sanitize_text_field( $v );
			}
			
		}
		
		return $sanitized_params;
		
	}
	
	/**
	 * Add protocol to URL
	 *
	 * @param $url
	 *
	 * @return string
	 */
	public static function add_protocol_to_uri( $url ) {
		
		if ( strpos( $url, '//' ) === 0 ) {
			$protocol = \is_ssl() ? 'https:' : 'http:';
			$url      = $protocol . $url;
		}
		
		return $url;
	}
	
	/**
	 * Determine whether this is an AMP response.
	 *
	 * Note that this must only be called after the parse_query action.
	 *
	 * @link https://github.com/Automattic/amp-wp
	 * @return bool Is AMP endpoint (and AMP plugin is active).
	 */
	public static function is_amp() {
		return function_exists( '\is_amp_endpoint' ) && \is_amp_endpoint();
	}
	
	
	/**
	 * Check if attachment if SVG
	 *
	 * @param $attachment_id
	 * @param $attachment_url
	 *
	 * @return bool
	 */
	public static function is_attachment_svg( $attachment_id, $attachment_url ) {
		
		$attachment_id  = (int) $attachment_id;
		$attachment_url = (string) $attachment_url;
		
		$is_attachment_svg_by_mime = $is_attachment_svg_by_ext = false;
		
		if ( $attachment_id > 0 ) {
			$mime                      = \get_post_mime_type( $attachment_id );
			$is_attachment_svg_by_mime = ( $mime === 'image/svg+xml' );
		}
		
		if ( $attachment_url ) {
			$path                     = parse_url( $attachment_url, PHP_URL_PATH );   // get path from url
			$extension                = pathinfo( $path, PATHINFO_EXTENSION );        // get ext from path
			$is_attachment_svg_by_ext = ( strtolower( $extension ) === 'svg' );
		}
		
		
		return $is_attachment_svg_by_mime || $is_attachment_svg_by_ext;
	}
	
	
	
	/**
	 * Get settings from App configuration
	 *
	 * @param $name
	 * @param $default
	 * @param bool $direct
	 *
	 * @return mixed
	 */
	public static function getConfigSetting( $name, $default = null, $direct = false ) {
		$parts = explode( '/', $name );
		
		$config = $direct
			? apply_filters( 'StarterKit/config', require get_template_directory() . '/app/config/config.php' )
			: Starter_Kit()->getConfig();
		
		if ( ! isset( $config[ $parts[0] ] ) ) {
			return $default;
		}
		
		$value = $config[ array_shift( $parts ) ];
		
		foreach ( $parts as $part ) {
			if ( is_array( $value ) && isset( $value[ $part ] ) ) {
				$value = $value[ $part ];
			} else {
				return $default;
			}
		}
		
		return $value;
	}
	
}
