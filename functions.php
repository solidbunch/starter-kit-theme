<?php

	/**
	 * Theme functions file
	 **/

	if ( ! isset( $content_width ) ) $content_width = 320;

	// Define necessary constants
	define( '_BVC_CACHE_TIME_', '110820171043' );

	// Instantiate base controller that will autoload
	// all application classes.
	require_once get_template_directory() . '/core/controller/theme-controller.php';

	// Start the core
	$bvc_theme = new bvc_theme_controller();
	$bvc_theme->run();
