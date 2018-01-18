<?php

/**
 * Backend controller
 **/
class fruitfulblankprefix_backend_controller extends fruitfulblankprefix_theme_controller {

	/**
	 * Constructor
	**/
	function __construct() {

		parent::__construct();
		$this->run();

	}

	/**
	 * Run backend actions
	**/
	function run() {

		// load admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets') );

		// Change admin menu position
		add_action( 'fw_backend_add_custom_settings_menu', array( $this, 'add_theme_options_menu' ));

		// disable VC front-end
		add_action( 'vc_before_init', array( $this, 'setup_vc') );

		// Allow additional mime types
        add_filter( 'upload_mimes', array( $this, 'add_upload_types' ) );
        add_filter( 'wp_check_filetype_and_ext', array( $this, 'ignore_upload_ext' ), 10, 4);

		require_once _FBCONSTPREFIX_LIBRARY_DIR_ . '/tgm/class-tgm-init.php';

	}

	/**
	 * Load admin assets
	**/
	function load_assets() {
		wp_enqueue_style( 'fruitfulblankprefix-backend', get_template_directory_uri() . '/assets/css/admin.css' );
	}

	/**
	 * Add Website Options Menu
	**/
	function add_theme_options_menu( $data ) {

		add_menu_page(
			esc_html__( 'Website Settings', 'fruitfulblanktextdomain' ),
			esc_html__( 'Website Settings', 'fruitfulblanktextdomain' ),
			$data['capability'],
			$data['slug'],
			$data['content_callback']
		);

	}

	/**
	 * Setup Visual Composer
	 * disable front-end mode
	**/
	function setup_vc() {

		if( function_exists( 'vc_disable_frontend') ) {
			vc_disable_frontend();
		}

		if ( function_exists('vc_set_default_editor_post_types')) {
			$list = array(
				'page',
				'composerlayout',
				'forms',
			);
			vc_set_default_editor_post_types( $list );
		}

	}
	
	/**
	 * Allow additional mime types to upload
	 **/
	function add_upload_types( $existing_mimes ) {
		$existing_mimes['ico'] = 'image/vnd.microsoft.icon';
		$existing_mimes['eot'] = 'application/vnd.ms-fontobject';
		$existing_mimes['woff2'] = 'application/x-woff';
		$existing_mimes['woff'] = 'application/x-woff';
		$existing_mimes['ttf'] = 'application/octet-stream';
		$existing_mimes['svg'] = 'image/svg+xml';
		$existing_mimes['mp4'] = 'video/mp4';
		$existing_mimes['ogv'] = 'video/ogg';
		$existing_mimes['webm'] = 'video/webm';
		return $existing_mimes;
	}

	function ignore_upload_ext( $checked, $file, $filename, $mimes ) {

		//we only need to worry if WP failed the first pass
		if(!$checked['type']){
			//rebuild the type info
			$wp_filetype = wp_check_filetype( $filename, $mimes );
			$ext = $wp_filetype['ext'];
			$type = $wp_filetype['type'];
			$proper_filename = $filename;

			//preserve failure for non-svg images
			if($type && 0 === strpos($type, 'image/') && $ext !== 'svg'){
				$ext = $type = false;
			}

			//everything else gets an OK, so e.g. we've disabled the error-prone finfo-related checks WP just went through. whether or not the upload will be allowed depends on the <code>upload_mimes</code>, etc.

			$checked = compact('ext','type','proper_filename');
		}

		return $checked;

	}

}
