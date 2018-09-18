<?php

namespace ttt;

use ttt\helper\utils;
use ttt\model\database;
use ttt\view\view;

/**
 * Primary core controller
 **/
class core {
	
	private static $instance = null;
	
	public $config;
	public $controller;
	public $model;
	public $view;
	
	private function __construct() {
	}
	
	/**
	 * @return core , Singleton
	 */
	public static function getInstance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	/**
	 * Run the theme
	 **/
	public function run() {
		
		// Load default config
		$this->config = require get_template_directory() . '/core/config.php';
		
		// Translation support
		load_theme_textdomain( 'tttextdomain', get_template_directory() . '/languages' );
		
		// Load core classes
		$this->_dispatch();
		
	}
	
	/**
	 * Load and instantiate all application
	 * classes neccessary for this theme
	 **/
	private function _dispatch() {
		
		$this->controller = new \stdClass();
		$this->model      = new \stdClass();
		$this->view       = new \stdClass();
		
		// load dependency classes first
		// View
		$this->view = new view();
		
		// Model
		$this->model->database = new database();
		
		// Autoload models
		$this->_load_modules( 'model', '/' );
		
		// Autoload controllers
		$this->_load_modules( 'controller', '/' );
		
		// Autoload widgets
		utils::autoload_dir( get_template_directory() . '/core/widgets', 1 );
		
		// Autoload Visual Composer shortcodes
		add_action( 'vc_after_init', function () {
			utils::autoload_dir( get_template_directory() . '/core/shortcodes', 1 );
		} );
		
	}
	
	/**
	 * Autoload core modules in a specific directory
	 *
	 * @param string
	 * @param string
	 * @param bool
	 **/
	private function _load_modules( $layer, $dir = '/' ) {
		
		$directory = get_template_directory() . '/core/' . $layer . $dir;
		$handle    = opendir( $directory );
		
		while ( false !== ( $file = readdir( $handle ) ) ) {
			
			if ( is_file( $directory . $file ) ) {
				// Figure out class name from file name
				$class = str_replace( '.php', '', $file );
				
				// Avoid recursion
				if ( $class !== get_class( $this ) ) {
					$classPath            = "\\ttt\\{$layer}\\{$class}";
					$this->$layer->$class = new $classPath();
				}
				
			}
		}
		
	}
	
	private function __clone() {
	}
	
}
