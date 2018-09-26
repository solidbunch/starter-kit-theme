<?php
/**
 * Database
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

namespace ffblank\model;

/**
 * Database
 *
 * Do stuff common to all model classes
 * that extend this database class
 *
 * @category   Wordpress
 * @package    FFBLANK Backend
 * @author     Mates Marketing <hellp@matesmarketing.com>
 * @copyright  2018 Mates Marketing LLC
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class database {
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
