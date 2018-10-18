<?php

vc_map( array(
	'name'        => esc_html__( 'Social Login Buttons', 'fruitfulblanktextdomain' ),
	'base'        => 'social_login',
	'icon'        => FFBLANK()->config['shortcodes_icon_uri'] . 'social-icons.png',
	'category'    => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add social login buttons', 'fruitfulblanktextdomain' ),
	'params'      => array()
) );
