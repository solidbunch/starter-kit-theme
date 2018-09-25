<?php

namespace ffblank\model;

/**
 * Do stuff common to all model classes
 * that extend this database class
 **/
class database {
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
}
