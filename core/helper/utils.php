<?php

namespace ffblank\helper;

/**
 * Utils helper
 **/
class utils {
	
	/**
	 * Get Global Option
	 **/
	public static function get_option( $option_name, $default_value = null ) {
		return self::is_unyson() ? fw_get_db_settings_option( $option_name, $default_value ) : $default_value;
	}
	
	/**
	 * Get Global Option
	 **/
	public static function get_post_option( $post_id, $option_name, $default_value = null ) {
		return self::is_unyson() ? fw_get_db_post_option( $post_id, $option_name, $default_value ) : $default_value;
	}
	
	/**
	 * Autoload PHP files in directory
	 **/
	public static function autoload_dir( $dir, $max_scan_depth = 0, $load_file = '', $current_depth = 0 ) {
		if ( $current_depth > $max_scan_depth ) {
			return;
		}
		
		// require all php files
		$scan = glob( "$dir" . DIRECTORY_SEPARATOR . "*" );
		
		foreach ( $scan as $path ) {
			
			if ( preg_match( '/\.php$/', $path ) ) {
				
				if ( is_string( $load_file ) && $load_file <> '' ) {
					
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
		return in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}
	
	/**
	 * Make sure that Unyson Framework plugin is active
	 **/
	public static function is_unyson() {
		return in_array( 'unyson/unyson.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}
	
	/**
	 * Make sure that WooCommerce plugin is active
	 **/
	public static function is_woocommerce() {
		return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}
	
	/**
	 * Returns shortcodes uri / path
	 **/
	public static function get_shortcodes_uri( $shortcode_name, $path = '' ) {
		return FFBLANK()->config['shortcodes_uri'] . '/' . $shortcode_name . '/' . $path;
	}
	
	public static function get_shortcodes_dir( $shortcode_name, $path = '' ) {
		return FFBLANK()->config['shortcodes_dir'] . '/' . $shortcode_name . '/' . $path;
	}
	
	/**
	 * Returns widgets uri / path
	 **/
	public static function get_widgets_uri( $widget_name, $path = '' ) {
		return FFBLANK()->config['widgets_uri'] . '/' . $widget_name . '/' . $path;
	}
	
	public static function get_widgets_dir( $widget_name, $path = '' ) {
		return FFBLANK()->config['widgets_uri'] . '/' . $widget_name . '/' . $path;
	}
	
	/**
	 * Get Unyson Framework config for available social icons
	 **/
	public static function get_social_cfg_usyon() {
		
		$config = array();
		
		foreach ( FFBLANK()->config['social_profiles'] as $k => $v ) {
			$config[ $k ] = array(
				'type'  => 'text',
				'label' => $v,
				'value' => ''
			);
		}
		
		return $config;
		
	}
	
	/**
	 * Sanitize text params from array
	 **/
	public static function sanitize_array_text_params( $params ) {
		
		$sanitized_params = array();
		
		foreach ( $params as $k => $v ) {
			
			if ( is_string( $v ) || is_numeric( $v ) ) {
				$sanitized_params[ $k ] = sanitize_text_field( $v );
			}
			
		}
		
		return $sanitized_params;
		
	}
	
	/**
	 * Sanitize URL
	 **/
	public static function sanitize_uri( $url ) {
		if ( filter_var( $url, FILTER_VALIDATE_URL ) === false ) {
			$protocol = is_ssl() ? 'https:' : 'http:';
			if ( $url <> '' ) {
				$url = $protocol . $url;
			}
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
		return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
	}
	
	
	public static function is_attachment_svg($attachment_id, $attachment_url) {
		
		$attachment_id  = (int)    $attachment_id;
		$attachment_url = (string) $attachment_url;
		
		$is_attachment_svg_by_mime = $is_attachment_svg_by_ext = false;
		
		if ($attachment_id > 0) {
			$mime = get_post_mime_type($attachment_id);
			$is_attachment_svg_by_mime = ($mime === 'image/svg+xml');
		}
		
		if ($attachment_url) {
			$path      = parse_url($attachment_url, PHP_URL_PATH);   // get path from url
			$extension = pathinfo($path, PATHINFO_EXTENSION);        // get ext from path
			$is_attachment_svg_by_ext = strtolower($extension) === 'svg';
		}
		
		
		return $is_attachment_svg_by_mime || $is_attachment_svg_by_ext;
	}
}
