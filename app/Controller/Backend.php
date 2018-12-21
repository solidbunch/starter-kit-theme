<?php
namespace StarterKit\Controller;

/**
 * Backend controller
 *
 * Controller which loading only on backend (admin panel)
 * contains all needed additional hooks,methods
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Backend {

	/**
	 * Constructor - add all needed actions
	 *
	 * @return void
	 **/
	public function __construct() {

		// load admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );

		// install required plugins
		require_once get_template_directory() . '/vendor/tgm/class-tgm-plugin-activation.php';
		add_action( 'tgmpa_register', array( $this, 'tgmpa_register' ) );

		// Change theme options default menu position
		add_action( 'fw_backend_add_custom_settings_menu', array( $this, 'add_theme_options_menu' ) );

	}

	/**
	 * Load admin assets
	 *
	 * @return void
	 **/
	public function load_assets() {
		wp_enqueue_style( 'starter-kit-backend', get_template_directory_uri() . '/assets/css/admin/admin.css',
			false, Starter_Kit()->config['cache_time'] );
	}

	/**
	 * Install required plugins
	 *
	 * @return void
	 **/
	public function tgmpa_register() {

		$plugins = array(

			array(
				'name'     => 'Unyson',
				'slug'     => 'unyson',
				'required' => false
			),

			array(
				'name'         => 'WPBakery Page Builder',
				'slug'         => 'js_composer',
				'source'       => 'https://solidbunch.com/required_plugins/js_composer.zip',
				'required'     => false,
				'version'      => '',
				'external_url' => '',
			),

		);

		// it is not necessairy to provide custom language config for TGM, so just leave it default
		tgmpa( $plugins );

	}

	/**
	 * Add Website Options Menu
	 *
	 * @param array $data - options menu information
	 *
	 * @return void
	 */
	public function add_theme_options_menu( array $data ) {

		add_theme_page(
			esc_html__( 'Website Settings', 'starter-kit' ),
			esc_html__( 'Website Settings', 'starter-kit' ),
			$data['capability'],
			$data['slug'],
			$data['content_callback']
		);

	}

}
