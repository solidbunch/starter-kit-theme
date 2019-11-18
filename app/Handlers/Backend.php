<?php

namespace StarterKit\Handlers;

use StarterKit\Helper\Assets;

/**
 * Backend handlers
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class Backend {
	
	/**
	 * Load admin assets
	 *
	 * @return void
	 **/
	public static function load_assets() {
		Assets::enqueue_style_dist( 'starter-kit-backend', 'admin.css' );
	}
	
	
	/**
	 * Install required plugins
	 *
	 * @return void
	 **/
	public static function tgmpa_register() {
		
		$plugins = [
			
			[
				'name'     => 'Unyson',
				'slug'     => 'unyson',
				'required' => false,
			],
			
			[
				'name'         => 'WPBakery Page Builder',
				'slug'         => 'js_composer',
				'source'       => 'https://solidbunch.com/required_plugins/js_composer.zip',
				'required'     => false,
				'version'      => '',
				'external_url' => '',
			],
		
		];
		
		// it is not necessary to provide custom language config for TGM, so just leave it default
		tgmpa( $plugins );
		
	}
	
	
	/**
	 * Add Website Options Menu
	 *
	 * @param array $data - options menu information
	 *
	 * @return void
	 */
	public static function add_theme_options_menu( array $data ) {
		
		add_theme_page(
			esc_html__( 'Website Settings', 'starter-kit' ),
			esc_html__( 'Website Settings', 'starter-kit' ),
			$data['capability'],
			$data['slug'],
			$data['content_callback']
		);
		
	}
}
