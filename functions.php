<?php
// helper functions for developers
require_once __DIR__ . '/core/dev.php';

if(class_exists('WP_CLI')) {
	//define theme root directory for future commands
	define('THEME_ROOT_DIRECTORY' , __DIR__);
	//load commands for dir
	foreach (glob(__DIR__ . '/bin/*.php') as $file) {
		require $file;
	}
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
	$prefix = 'ffblank\\';
	
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
if ( ! function_exists( 'FFBLANK' ) ) {
	
	function FFBLANK() {
		return \ffblank\core::getInstance();
	}
	
}

// Run the theme
FFBLANK()->run();

/**
 * Examples to use:
 * ======================================================================
 * Controllers::
 * FFBLANK()->controller->front->your_method();
 * FFBLANK()->controller->backend->your_method();
 * FFBLANK()->controller->test->your_method();
 * FFBLANK()->controller->shortcodes->your_method();
 *
 * Model / View::
 * FFBLANK()->model->post->get_random_posts( 'portfolio', 5 );
 * FFBLANK()->view->load('/front/my_template', array( 'foo' => 'bar' ));
 *
 * Config::
 * FFBLANK()->config['social_profiles']
 *
 * Helpers::
 * \ffblank\helper\front::get_grid_class();
 * \ffblank\helper\media::img_resize();
 * ======================================================================
 **/
