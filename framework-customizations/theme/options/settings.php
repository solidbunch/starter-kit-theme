<?php

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = [
	
	fw()->theme->get_options( 'general' ),
	fw()->theme->get_options( 'social' ),
	fw()->theme->get_options( 'footer' ),
	fw()->theme->get_options( 'analytics' ),
	fw()->theme->get_options( 'security' ),
	fw()->theme->get_options( 'performance' ),

];
