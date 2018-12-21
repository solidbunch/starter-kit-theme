<?php

namespace StarterKit;

use StarterKit\Helper\Utils;
use StarterKit\Model\Database;
use StarterKit\View\View;

/**
 * Application Singleton
 *
 * Primary application controller
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class App {
	
	/** @var  $instance - self */
	private static $instance;
	
	/** @var array */
	public $config;
	
	/** @var \stdClass */
	public $Controller;
	
	/** @var \stdClass */
	public $Model;
	
	/** @var view */
	public $View;
	
	private function __construct() {
	}
	
	/**
	 * @return App Singleton
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
		$this->config = require get_template_directory() . '/app/config.php';
		
		// Translation support
		load_theme_textdomain( 'starter-kit', get_template_directory() . '/languages' );
		
		// Load core classes
		$this->_dispatch();
		
	}
	
	/**
	 * Load and instantiate all application
	 * classes necessary for this theme
	 **/
	private function _dispatch() {
		
		$this->Controller = new \stdClass();
		$this->Model      = new \stdClass();
		
		// load dependency classes first
		// View
		$this->View = new View();
		
		// Model
		$this->Model->Database = new Database();
		
		// Autoload models
		$this->_load_modules( 'Model', '/' );
		
		// Autoload controllers
		$this->_load_modules( 'Controller', '/' );
		
		// Autoload widgets
		utils::autoload_dir( get_template_directory() . '/app/Widgets', 1 );
	}
	
	/**
	 * Autoload core modules in a specific directory
	 *
	 * @param string
	 * @param string
	 * @param bool
	 **/
	private function _load_modules( $layer, $dir = '/' ) {
		
		$directory = get_template_directory() . '/app/' . $layer . $dir;
		$handle    = opendir( $directory );
		
		while ( false !== ( $file = readdir( $handle ) ) ) {
			
			if ( is_file( $directory . $file ) ) {
				// Figure out class name from file name
				$class = str_replace( '.php', '', $file );
				
				// Avoid recursion
				if ( $class !== get_class( $this ) ) {
					$classPath            = "\\StarterKit\\{$layer}\\{$class}";
					$this->$layer->$class = new $classPath();
				}
				
			}
		}
		
	}
	
	private function __clone() {
	}
	
}
