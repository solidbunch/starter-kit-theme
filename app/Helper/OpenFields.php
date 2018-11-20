<?php
namespace StarterKit\Helper;

/**
 * Open fields helper
 *
 * PHP version 5.6
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     {author}
 * @copyright  {copyright}
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class OpenFields {

	/**
	 * Open files directory fields
	 *
	 * @param string $dir
	 *
	 * @return void
	 */
	static function open_file( $dir = '' ) {

		foreach ( glob( $dir . '/fields/*.php' ) as $file ) {
			include_once $file;
		}

	}

	/**
	 * List name child fields
	 *
	 * @param string $dir
	 *
	 * @return string
	 */
	static function name_fields( $dir = '' ) {

		foreach ( glob( $dir . '/fields/*.php' ) as $file ) {

			$name[] = basename( $file, ".php" );
		};

		$base = implode( ', ', $name ) . ', ';

		return $base;

	}
}
