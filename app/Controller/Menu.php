<?php
namespace StarterKit\Controller;

/**
 * Custom Menus
 *
 * Controller which add support of custom menus positions
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Menu {

	/**
	 * Constructor
	 **/
	public function __construct() {

		// register menus
		add_action( 'init', array( $this, 'register_menus' ) );

		// here we can add custom menu fields, modify admin walkers etc

	}

	/**
	 * Register theme menus
	 **/
	public function register_menus() {

		register_nav_menus( array(
			'header_menu'     => esc_html__( 'Header Menu', 'starter-kit' ),
			'bottom_bar_menu' => esc_html__( 'Bottom Bar Menu', 'starter-kit' ),
		) );

	}

}
