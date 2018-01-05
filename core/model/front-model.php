<?php
/**
 * Front data request model
 * 
 **/
class fruitfulblankprefix_front_model {
	/**
	 * Class vars
	 **/
	protected $wpdb = null;
	protected $tables = array();	

	/**
	 * Make Wordpress dbase object and other
	 * models available to all model classes.
	 * Also, define database tables.
	 **/
	function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;		
		
		$this->tables = array(
			'posts' => $this->wpdb->prefix . "posts"
		);
		
	}
	
	function default_layout_query($layout_type = 'header' ) {
		$args = array(
			'post_type'      => 'composerlayout',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'   => '_layouttype',
					'value' => $layout_type,
				),
				array(
					'key'   => '_appointment',
					'value' => 'default',
				),
			
			)
		);
		$default_layout_query = new WP_Query( $args );
		wp_reset_query();
		
		return $default_layout_query;
		
	}

	function layouts($layout_type = 'header' ) {
		
		$args    = array(
			'post_type'      => 'composerlayout',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_query'     => array(
				'composerlayout_layouttype' => array(
					'key'   => '_layouttype',
					'value' => $layout_type,
				),
			),
			'order'          => 'ASC',
		);
		$layouts = new WP_Query( $args );
		wp_reset_query();
		
		return $layouts;
		
	}
}
