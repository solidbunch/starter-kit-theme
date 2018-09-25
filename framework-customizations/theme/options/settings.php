<?php

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

	fw()->theme->get_options( 'general' ),
	fw()->theme->get_options( 'social' ),
	fw()->theme->get_options( 'footer' ),

);
