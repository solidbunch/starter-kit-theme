<?php

/**
 * Primary core controller
 **/
class fruitfulblankprefix_theme_controller {

	public $controller;
	public $model;
	public $view;

	public function __construct() {

	}

	/**
	 * Enter point for a framework
	 * @param array
	 **/
	public function run() {

		// Translation support
		load_theme_textdomain( 'fruitfulblanktextdomain', get_template_directory() . '/languages' );

		// Load core classes
		$this->_dispatch();

	}

	public function get_option( $option_name, $default = null ) {
		return isset( $this->options[ $option_name ] ) ? $this->options[ $option_name ] : $default;
	}

	/**
	 * Load and instantiate all application
	 * classes neccessary for this theme
	 **/
	private function _dispatch() {

		$this->controller = new stdClass();
		$this->model = new stdClass();
		$this->view = new stdClass();

		// Manually load dependency classes first

		// View
		require_once get_template_directory() . '/core/view/view.php';
		$this->view = new fruitfulblankprefix_core_view();

		// Models
		require_once get_template_directory() . '/core/model/database.php';
		$this->model->database = new fruitfulblankprefix_database();

		require_once get_template_directory() . '/core/model/post.php';
		$this->model->post = new fruitfulblankprefix_post_model();

		// Autoload helpers
		$this->_autoload_directory( 'helper', '/', false );

		// Controller
		$this->controller->base = $this;

		require_once get_template_directory() . '/core/controller/shared/init-controller.php';
		$this->controller->init = new fruitfulblankprefix_init_controller();

		if( is_admin() ) {

			// Controllers for admin part only
			require_once get_template_directory() . '/core/controller/admin/backend-controller.php';
			$this->controller->backend = new fruitfulblankprefix_backend_controller();

		} else {

			// Controllers for front-end part only

			require_once get_template_directory() . '/core/controller/front/front-controller.php';
			$this->controller->front = new fruitfulblankprefix_front_controller();

		}

		require_once get_template_directory() . '/core/controller/shared/shortcodes-controller.php';
		$this->controller->shortcodes = new fruitfulblankprefix_shortcodes_controller();

		// Inject models, view and controllers from this base controller into all OTHER controllers & models
		foreach ( $this->controller as $controller ) {
			$controller->_inject_application_classes( $this->model, $this->view, $this->controller );
		}

	}

	/**
	 * Autoload all scripts in a directory
	 * @param string
	 * @param string
	 * @param bool
	 **/
	private function _autoload_directory( $layer, $dir = '/', $load_class = true ) {

		$directory = get_template_directory() . '/core/' . $layer . $dir;
		$handle = opendir( $directory );

		while ( false !== ( $file = readdir( $handle))) {

			if ( is_file( $directory . $file)) {
				// Figure out class name from file name
				$class = str_replace('.php', '', $file);

				$class = 'fruitfulblankprefix_' . str_replace('-', '_', $class ) . '';
				$shortClass = str_replace( 'fruitfulblankprefix_', '', $class );
				$shortClass = str_replace( '_' . $layer, '', $shortClass);

				if( $load_class ) {
					// Avoid recursion
					if ( $class != get_class( $this) ) {
						// Include and instantiate class
						require_once $directory . $file;
						$this->$layer->$shortClass = new $class();
					}
				} else {
					require_once $directory . $file;
				}

			} 
		}

	}

	/**
	 * Inject models, view and controllers
	 * into all other controllers to make
	 * them callable from there
	**/
	private function _inject_application_classes( $model, $view, $controller ) {

		$this->model = $model;
		$this->view = $view;
		$this->controller = $controller;

	}

}
