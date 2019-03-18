<?php

if ( ! defined( 'FW' ) ) {
	exit;
}

$manifest = [
	'id' => get_option( 'stylesheet' )
];

$manifest['requirements'] = [
	'wordpress'  => [],
	'framework'  => [],
	'extensions' => []
];

$manifest['supported_extensions'] = [
	//'page-builder'	=> array(),
	//'wp-shortcodes' => array(),
	'backups'  => [],
	'sidebars' => [],
	//'portfolio' 		=> array(),
	//'breadcrumbs' 	=> array(),
	//'seo' 					=> array(),
	//'analytics' 		=> array(),
	//'social' 				=> array(),
	//'megamenu'			=> array(),
	//'events' 				=> array(),
];
