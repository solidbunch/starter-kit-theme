<?php
/**
 * @category   WP_CLI commands functions helper
 * @package    fruitfulblank
 * @author     Mates Marketing <hello@matesmarketing.com>
 * @author     Nikita Bolotov <nikita.bolotov@matesmarketing.com>
 * @copyright  2018 Nikita Bolotov
 * @license    https://opensource.org/licenses/OSL-3.0
 */

/**
 * check if directory exists and create new
 *
 * @param $parent_dir - path pto dir in which we creates new directory
 * @param $name - name new directory
 *
 * @throws \RuntimeException
 *
 * @return string - path to new dir
 */
function create_dir( $parent_dir, $name ) {
	if ( ! mkdir( $concurrentDirectory = $parent_dir . $name ) && ! is_dir( $concurrentDirectory ) ) {
		throw new \RuntimeException( sprintf( 'Directory "%s" was not created', $concurrentDirectory ) );
	}

	return $concurrentDirectory;
}

/**
 * create file in directory and put content in it
 *
 * @param $template_path - path to file template
 * @param array $search - search what replace
 * @param array $replace - with what we need replace template parts
 * @param $file_name - full file path to create (with name)
 */
function create_file( $template_path, array $search, array $replace, $file_name ) {
	$template = str_replace( $search, $replace, file_get_contents( $template_path ) );

	$handle = fopen( $file_name, 'wb' );

	if ( $handle && fwrite( $handle, $template ) ) {
		WP_CLI::success( "Shortcode file $file_name created " );
	}
}
