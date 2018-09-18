<?php
// helper functions for developers
require_once( get_theme_file_path( 'core/dev.php' ) );

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
	$prefix = 'ttt\\';
	
	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/core/';
	
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

// https://codex.wordpress.org/Content_Width
if ( ! isset( $content_width ) ) {
	$content_width = 320;
}


// Global point of enter
if ( ! function_exists( 'TTT' ) ) {
	
	function TTT() {
		return \ttt\core::getInstance();
	}
	
}

// Run the theme
TTT()->run();

/**
 * Examples to use:
 * ======================================================================
 * Controllers::
 * TTT()->controller->front->your_method();
 * TTT()->controller->backend->your_method();
 * TTT()->controller->test->your_method();
 * TTT()->controller->shortcodes->your_method();
 *
 * Model / View::
 * TTT()->model->post->get_random_posts( 'portfolio', 5 );
 * TTT()->view->load('/front/my_template', array( 'foo' => 'bar' ));
 *
 * Config::
 * TTT()->config['social_profiles']
 *
 * Helpers::
 * \ttt\helper\front::get_grid_class();
 * \ttt\helper\media::img_resize();
 * ======================================================================
 **/
