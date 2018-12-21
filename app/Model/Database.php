<?php
namespace StarterKit\Model;

/**
 * Database
 *
 * Do stuff common to all model classes
 * that extend this database class
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Database {
	/**
	 * Class vars
	 **/

	/** @var \wpdb null */
	protected $wpdb;

	/** @var array */
	protected $tables = array();

	/**
	 * Make Wordpress dbase object and other
	 * models available to all model classes.
	 * Also, define database tables.
	 **/
	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;

		$this->tables = array(
			'posts' => $this->wpdb->prefix . "posts"
		);

	}
}
