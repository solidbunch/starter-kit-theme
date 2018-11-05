<?php
/**
 * Open fields helper
 *
 * PHP version 5.6
 *
 * @category   Wordpress
 * @package    FFBLANK Backend
 * @author     Mates Marketing <hello@matesmarketing.com>
 * @copyright  2018 Mates Marketing LLC
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

namespace ffblank\helper;


class open_fields {

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
