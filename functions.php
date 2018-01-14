<?php

	/**
	 * Theme functions file
	 **/

	// https://codex.wordpress.org/Content_Width
	if ( ! isset( $content_width ) ) {
		$content_width = 320;
	}

	// Define necessary constants
	define( '_FBCONSTPREFIX_CACHE_TIME_', '110820171043' );
	define( '_FBCONSTPREFIX_LIBRARY_DIR_', get_template_directory() . '/core/library/' );
	define( '_FBCONSTPREFIX_VIEW_DIR_', get_template_directory() . '/core/view/' );
	define( '_FBCONSTPREFIX_SHORTCODES_DIR_', get_template_directory() . '/core/shortcodes/' );

	// Instantiate base controller that will autoload
	// all application classes.
	require_once get_template_directory() . '/core/controller/theme-controller.php';

	// Start the core
	$fruitfulblankprefix_theme = new fruitfulblankprefix_theme_controller();
	$fruitfulblankprefix_theme->run();
