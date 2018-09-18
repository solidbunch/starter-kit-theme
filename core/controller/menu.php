<?php

namespace ttt\controller;

/**
 * Menu controller
 **/
class menu {
	
	/**
	 * Constructor
	 **/
	function __construct() {

		// register menus
		add_action( 'init', array( $this, 'register_menus' ) );

		// here we can add custom menu fields, modify admin walkers etc

	}
		
	/**
	 * Register theme menus
	 **/
	function register_menus() {
		
		register_nav_menus( array(
			'header_menu'     => esc_html__( 'Header Menu', 'tttextdomain' ),
			'bottom_bar_menu' => esc_html__( 'Bottom Bar Menu', 'tttextdomain' ),
		) );
		
	}
	
}
