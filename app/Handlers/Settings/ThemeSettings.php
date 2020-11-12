<?php

namespace StarterKit\Handlers\Settings;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Media;
use StarterKit\Helper\Utils;

class ThemeSettings {
	
	public static function make(): void {
		
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		
		$container = Container::make(
			'theme_options',  // type
			'theme_settings', // id
			__( 'Theme Settings', 'starter-kit' ) // desc
		)->set_page_parent( 'themes.php' ); // id of the "Appearance" admin section
		
		
		// General
		
		$container->add_tab( __( 'General', 'starter-kit' ),
			[
				Field::make( 'separator', $prefix . 'sep_general_header', __( 'Header', 'starter-kit' ) ),
				Field::make( 'checkbox', $prefix . 'fixed_header', __( 'Fixed header', 'starter-kit' ) )
				     ->set_option_value( '1' )
				     ->set_default_value( '' ),
			]
		);
		
		
		// Social
		
		$container->add_tab( __( 'Social', 'starter-kit' ),
			array_merge(
				[
					Field::make( 'separator', $prefix . 'sep_social_login', __( 'Social Login', 'starter-kit' ) ),
					Field::make( 'text', $prefix . 'facebook_app_id', __( 'Facebook Application ID', 'starter-kit' ) )->set_width( 50 ),
					Field::make( 'text', $prefix . 'facebook_app_secret', __( 'Facebook Application Secret', 'starter-kit' ) )->set_width( 50 ),
					Field::make( 'text', $prefix . 'google_client_id', __( 'Google Client ID', 'starter-kit' ) )->set_width( 50 ),
					Field::make( 'text', $prefix . 'google_client_secret', __( 'Google Client Secret', 'starter-kit' ) )->set_width( 50 ),
					Field::make( 'text', $prefix . 'twitter_consumer_key', __( 'Twitter Consumer Key', 'starter-kit' ) )->set_width( 50 ),
					Field::make( 'text', $prefix . 'twitter_consumer_secret', __( 'Twitter Consumer Secret', 'starter-kit' ) )->set_width( 50 ),
				],
				self::makeSocialProfileFields()
			) );
		
		
		// Footer
		
		$container->add_tab( __( 'Footer', 'starter-kit' ),
			[
				Field::make( 'separator', $prefix . 'sep_footer_bottom_bar', __( 'Bottom Bar', 'starter-kit' ) ),
				Field::make( 'text', $prefix . 'bottom_bar_text', __( 'Bottom bar text', 'starter-kit' ) )
				     ->set_default_value( '{year} &copy; Copyright' ),
			]
		);
		
		
		// Analytics
		
		$container->add_tab( __( 'Analytics', 'starter-kit' ),
			[
				Field::make( 'separator', $prefix . 'sep_analytics_google', __( 'Google', 'starter-kit' ) ),
				
				Field::make( 'text', $prefix . 'tag_manager_code', __( 'Tag Manager Code', 'starter-kit' ) )
				     ->set_attribute( 'placeholder', 'GTM-XXXXXXX' )
				     ->set_width( 50 ),
				
				Field::make( 'text', $prefix . 'analytics_code', __( 'Analytics Code', 'starter-kit' ) )
				     ->set_attribute( 'placeholder', 'UA-XXXXXXXXX-X' )
				     ->set_help_text( __( 'For a better speed performance, please insert the analytics code through the tag manager. Turn on google Analytics Scripts Local Load option',
					     'starter-kit' ) )
				     ->set_width( 50 ),
				/*
				Field::make( 'checkbox', $prefix . 'analytics_js_lazy_load', __( 'Analytics Scripts Local Load', 'starter-kit' ) )
				     ->set_option_value( '1' )
				     ->set_default_value( '' )
				     ->set_help_text( __( 'Load Tag Manager and Analytics scripts from local directory', 'starter-kit' ) ),
				*/
			]
		);
		
		
		// Security
		
		$container->add_tab( __( 'Security', 'starter-kit' ),
			[
				Field::make( 'separator', $prefix . 'sep_security_antispam', __( 'Antispam', 'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'forms_antispam', __( 'Antispam', 'starter-kit' ) )
				     ->set_option_value( '1' )
				     ->set_default_value( '' )
				     ->set_help_text( __( 'Antispam for all Email Forms', 'starter-kit' ) ),
				//-----------------------------------------------------------------------
				Field::make( 'separator', $prefix . 'sep_security_xmlrpc', __( 'XML-RPC settings', 'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'enable_xmlrpc', __( 'XML-RPC enable', 'starter-kit' ) )
				     ->set_option_value( '1' )
				     ->set_default_value( '' )
				     ->set_help_text( __( 'Enable XML-RPC API remote procedure call (RPC), which is disabled by default', 'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'disable_pingbacks', __( 'Trackbacks/Pingbacks', 'starter-kit' ) )
				     ->set_option_value( '1' )
				     ->set_default_value( '' )
				     ->set_help_text( __( 'Disables trackbacks/pingbacks', 'starter-kit' ) ),
			]
		);
		
		
		// Performance
		
		$container->add_tab( __( 'Performance', 'starter-kit' ),
			[
				Field::make( 'separator', $prefix . 'sep_performance_ll', __( 'Images Lazy Load Options', 'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'img_lazy_load', __( 'Lazy Load', 'starter-kit' ) )
				     ->set_option_value( '1' )
				     ->set_default_value( '' )
				     ->set_help_text( __( 'Lazy Load Images on/off', 'starter-kit' ) ),
				
				Field::make( 'text', $prefix . 'lazy_img_min_width', __( 'Image min width (px)', 'starter-kit' ) )
				     ->set_attribute( 'type', 'number' )->set_attribute( 'min', 0 )->set_attribute( 'max', '5000' )
				     ->set_default_value( 24 )
				     ->set_width( 50 ),
				
				Field::make( 'text', $prefix . 'lazy_img_min_height', __( 'Image min height (px)', 'starter-kit' ) )
				     ->set_attribute( 'type', 'number' )->set_attribute( 'min', 0 )->set_attribute( 'max', '5000' )
				     ->set_default_value( 24 )
				     ->set_width( 50 ),
				
				Field::make( 'color', $prefix . 'placeholder_color', __( 'Placeholder color', 'starter-kit' ) )
				     ->set_default_value( '#555555' )
					//->set_alpha_enabled( true ),
					 ->set_help_text( __( 'Image preloader color', 'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'lazy_load_get_sizes_with_getimagesize', __( 'Lazy load get sizes with getimagesize', 'starter-kit' ) )
				     ->set_option_value( '1' )
				     ->set_default_value( '' )
				     ->set_help_text( __( 'Try to get image sizes with getimagesize() if there is no width and heght attributes.
						 Attantion! php function getimagesize() can significantly slow down your site speed. Use neatly', 'starter-kit' ) ),
				//-----------------------------------------------------------------------
				
				Field::make( 'separator', 'sep_image_sizes', __( 'Image sizes', 'starter-kit' ) ),
				Field::make( 'set', $prefix . 'disable_img_sizes', __( 'Check image sizes to disable', 'starter-kit' ) )
				     ->set_options( Media::getAllInitedImageSizesFormatted() )
				     ->set_default_value(
					     array_filter(
						     array_keys( Media::getAllInitedImageSizesFormatted() ),
						     function ( $value ) {
							     return ! in_array( $value, [ 'thumbnail', 'medium' ], true );
						     } )
				     ),
				
				//-----------------------------------------------------------------------
				
				Field::make( 'separator', $prefix . 'sep_performance_http2', __( 'HTTP/2 Preload Options', 'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'http2_styles_enable', __( 'Enable/Disable HTTP/2 Preload for styles', 'starter-kit' ) )
				     ->set_option_value( '1' )->set_default_value( '' ),
				
				Field::make( 'checkbox', $prefix . 'http2_scripts_enable', __( 'Enable/Disable HTTP/2 Preload for scripts', 'starter-kit' ) )
				     ->set_option_value( '1' )->set_default_value( '' ),
				//-----------------------------------------------------------------------
				
				Field::make( 'separator', $prefix . 'sep_performance_head', __( 'WP Head Options', 'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'clean_wp_head', __( 'Clean Up WP head', 'starter-kit' ) )
				     ->set_option_value( '1' )->set_default_value( '' )
				     ->set_help_text( __( 'Remove unnecessary link\'s ,Remove inline CSS and JS from WP emoji support, Remove inline CSS used by Recent Comments widget, Remove inline CSS used by posts with galleries, Remove self-closing tag',
					     'starter-kit' ) ),
				
				//-----------------------------------------------------------------------
				
				Field::make( 'separator', $prefix . 'sep_performance_assets', __( 'HTML/Js/Css additional', 'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'inline_critical_css', __( 'Inline critical css', 'starter-kit' ) )
				     ->set_option_value( '1' )->set_default_value( '' )
				     ->set_help_text( __( 'Connect critical.css inline. Turn Off if WP Rocket Optimize CSS delivery is On',
					     'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'add_embed_wrap', __( 'Add wrapper to embed code', 'starter-kit' ) )
				     ->set_option_value( '1' )->set_default_value( '' )
				     ->set_help_text( __( 'Enclose embedded media in a &lt;div class=&quot;embed-wrapper&quot;&gt;',
					     'starter-kit' ) ),
				
				Field::make( 'checkbox', $prefix . 'remove_self_closing_tags', __( 'Remove self closing tags', 'starter-kit' ) )
				     ->set_option_value( '1' )->set_default_value( '' )
				     ->set_help_text( __( 'In HTML5 it is not strictly necessary to close certain HTML tags. &lt;img /&gt;, &lt;input /&gt; etc.',
					     'starter-kit' ) ),

				Field::make( 'checkbox', $prefix . 'assets_versions', __( 'Remove Versions', 'starter-kit' ) )
				     ->set_option_value( '1' )->set_default_value( '' )
				     ->set_help_text( __( 'Resources with a "?" in the URL are not cached by some proxy caching servers.',
					     'starter-kit' ) ),
			
			]
		);
		
	}
	
	
	
	private static function makeSocialProfileFields() {
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		$fields = [ Field::make( 'separator', 'sep_social_profiles', __( 'Social Profiles', 'starter-kit' ) ) ];
		foreach ( Utils::getConfigSetting( 'social_profiles' ) as $k => $v ) {
			$fields[] = Field::make( 'text', $prefix . $k, $v )->set_width( 50 );
		}
		
		return $fields;
	}
}