<?php
/**
 * Adding Custom Menus
 *
 * PHP version 5.6
 *
 * @category   Wordpress
 * @package    FFBLANK Backend
 * @author     Mates Marketing <hellp@matesmarketing.com>
 * @copyright  2018 Mates Marketing LLC
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace ffblank\controller;

/**
 * Adding Custom Menus
 *
 * Controller which add support of custom menus positions
 *
 * @category   Wordpress
 * @package    FFBLANK Backend
 * @author     Mates Marketing <hellp@matesmarketing.com>
 * @copyright  2018 Mates Marketing LLC
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class menu {

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
			'header_menu'     => esc_html__( 'Header Menu', 'fruitfulblanktextdomain' ),
			'bottom_bar_menu' => esc_html__( 'Bottom Bar Menu', 'fruitfulblanktextdomain' ),
		) );

	}

}
