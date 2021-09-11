<?php
// helper functions for developers
require_once __DIR__ . '/app/dev.php';

if ( PHP_VERSION_ID < 70200 ) {
	wp_die( sprintf( __( 'Theme require at least PHP 7.2.0 ( You are using PHP %s ) ' ), PHP_VERSION ) );
}

if ( class_exists( 'WP_CLI' ) ) {
	//define theme root directory for future commands
	define( 'THEME_ROOT_DIRECTORY', __DIR__ );
	//load commands for dir
	foreach ( glob( __DIR__ . '/dev/cli/*.php' ) as $file ) {
		require $file;
	}
}

/**
 * If we don't have composer autoload register own PSR-4 autoload
 * Else use composer autoload
 */
if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	if ( ! defined( 'VENDOR_DIR' ) ) {
		define( 'VENDOR_DIR', 'vendor-custom' );
	}
	
	/**
	 * After registering this autoload function with SPL, the following line
	 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
	 * from /path/to/project/src/Baz/Qux.php:
	 *
	 *      new \Foo\Bar\Baz\Qux;
	 *
	 * @param string $class The fully-qualified class name.
	 *
	 * @return void
	 */
	spl_autoload_register( function ( $class ) {
		
		// project-specific namespace prefix
		$prefix = 'StarterKit\\';
		
		// base directory for the namespace prefix
		$base_dir = __DIR__ . '/app/';
		
		// does the class use the namespace prefix?
		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			// no, move to the next registered autoloader
			return;
		}
		
		// get the relative class name
		$relative_class = substr( $class, $len );
		
		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
		
		// if the file exists, require it
		if ( file_exists( $file ) ) {
			require $file;
		}
	} );
} else {
	require __DIR__ . '/vendor/autoload.php';
}

// https://codex.wordpress.org/Content_Width , https://developer.wordpress.com/themes/content-width/
if ( ! isset( $content_width ) ) {
	$content_width = 320;
}


// Global point of enter
if ( ! function_exists( 'Starter_Kit' ) ) {
	
	function Starter_Kit() {
		return \StarterKit\App::instance();
	}
	
}

$config = apply_filters( 'StarterKit/config', require __DIR__ . '/app/config/config.php' );

// Run the theme
try {
	Starter_Kit()->run( $config );
} catch ( Exception $exception ) {
	wlog( $exception );
	header( 'HTTP/1.1 503 Service Temporarily Unavailable' );
	header( 'Status: 503 Service Temporarily Unavailable' );
	header( 'Retry-After: 300' );// 300 seconds.
	die();
}
