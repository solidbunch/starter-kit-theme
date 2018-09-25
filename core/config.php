<?php

/**
 * Core config
 **/

return array(
	'cache_time'      => '110820171043',
	'assets_uri'  		=> get_template_directory_uri() . '/assets/',
	'shortcodes_dir'  => get_template_directory() . '/core/shortcodes/',
	'shortcodes_uri'  => get_template_directory_uri() . '/core/shortcodes/',
	'widgets_dir'     => get_template_directory() . '/core/widgets/',
	'widgets_uri'     => get_template_directory_uri() . '/core/widgets/',
	'social_profiles' => array(
		'facebook_url'    => esc_html__( 'Facebook URL', 'fruitfulblanktextdomain' ),
		'twitter_url'     => esc_html__( 'Twitter URL', 'fruitfulblanktextdomain' ),
		'instagram_url'   => esc_html__( 'Instagram URL', 'fruitfulblanktextdomain' ),
		'google_plus_url' => esc_html__( 'Google Plus URL', 'fruitfulblanktextdomain' ),
		'pinterest_url'   => esc_html__( 'Pinterest URL', 'fruitfulblanktextdomain' ),
		'linkedin_url'    => esc_html__( 'LinkedIn URL', 'fruitfulblanktextdomain' ),
		'youtube_url'     => esc_html__( 'YouTube URL', 'fruitfulblanktextdomain' ),
		'vimeo_url'       => esc_html__( 'Vimeo URL', 'fruitfulblanktextdomain' ),
		'dribbble_url'    => esc_html__( 'Dribbble URL', 'fruitfulblanktextdomain' ),
		'behance_url'     => esc_html__( 'Behance URL', 'fruitfulblanktextdomain' ),
		'tumblr_url'      => esc_html__( 'Tumblr URL', 'fruitfulblanktextdomain' ),
		'flickr_url'      => esc_html__( 'Flickr URL', 'fruitfulblanktextdomain' ),
		'medium_url'      => esc_html__( 'Medium URL', 'fruitfulblanktextdomain' ),
	),
	'social_icons'    => array(
		'facebook_url'    => 'fa fa-facebook',
		'twitter_url'     => 'fa fa-twitter',
		'instagram_url'   => 'fa fa-instagram',
		'google_plus_url' => 'fa fa-google-plus',
		'pinterest_url'   => 'fa fa-pinterest-p',
		'linkedin_url'    => 'fa fa-linkedin',
		'youtube_url'     => 'fa fa-youtube-play',
		'vimeo_url'       => 'fa fa-vimeo',
		'dribbble_url'    => 'fa fa-dribbble',
		'behance_url'     => 'fa fa-behance',
		'tumblr_url'      => 'fa fa-tumblr',
		'flickr_url'      => 'fa fa-flickr',
		'medium_url'      => 'fa fa-medium',
	),
	'animations'      => array(
		'bounce'            => esc_html__( 'Bounce', 'fruitfulblanktextdomain' ),
		'pulse'             => esc_html__( 'Pulse', 'fruitfulblanktextdomain' ),
		'tada'              => esc_html__( 'Tada', 'fruitfulblanktextdomain' ),
		'wobble'            => esc_html__( 'Wobble', 'fruitfulblanktextdomain' ),
		'jello'             => esc_html__( 'Jello', 'fruitfulblanktextdomain' ),
		'bounceIn'          => esc_html__( 'Bounce In', 'fruitfulblanktextdomain' ),
		'bounceInDown'      => esc_html__( 'Bounce In Down', 'fruitfulblanktextdomain' ),
		'bounceInLeft'      => esc_html__( 'Bounce In Left', 'fruitfulblanktextdomain' ),
		'bounceInRight'     => esc_html__( 'Bounce In Right', 'fruitfulblanktextdomain' ),
		'bounceInUp'        => esc_html__( 'Bounce In Up', 'fruitfulblanktextdomain' ),
		'fadeIn'            => esc_html__( 'Fade In', 'fruitfulblanktextdomain' ),
		'fadeInDown'        => esc_html__( 'Fade In Down', 'fruitfulblanktextdomain' ),
		'fadeInDownBig'     => esc_html__( 'Fade In Down Big', 'fruitfulblanktextdomain' ),
		'fadeInLeft'        => esc_html__( 'Fade In Left', 'fruitfulblanktextdomain' ),
		'fadeInLeftBig'     => esc_html__( 'Fade In Left Big', 'fruitfulblanktextdomain' ),
		'fadeInRight'       => esc_html__( 'Fade In Right', 'fruitfulblanktextdomain' ),
		'fadeInRightBig'    => esc_html__( 'Fade In Right Big', 'fruitfulblanktextdomain' ),
		'fadeInUp'          => esc_html__( 'Fade In Up', 'fruitfulblanktextdomain' ),
		'fadeInUpBig'       => esc_html__( 'Fade In Up Big', 'fruitfulblanktextdomain' ),
		'flip'              => esc_html__( 'Flip', 'fruitfulblanktextdomain' ),
		'flipInX'           => esc_html__( 'Flip in X', 'fruitfulblanktextdomain' ),
		'flipInY'           => esc_html__( 'Flip in Y', 'fruitfulblanktextdomain' ),
		'flipOutX'          => esc_html__( 'Flip out X', 'fruitfulblanktextdomain' ),
		'flipOutY'          => esc_html__( 'Flip out Y', 'fruitfulblanktextdomain' ),
		'lightSpeedIn'      => esc_html__( 'Light Speed In', 'fruitfulblanktextdomain' ),
		'rotateIn'          => esc_html__( 'Rotate In', 'fruitfulblanktextdomain' ),
		'rotateInDownLeft'  => esc_html__( 'Rotate In Down Left', 'fruitfulblanktextdomain' ),
		'rotateInDownRight' => esc_html__( 'Rotate In Down Right', 'fruitfulblanktextdomain' ),
		'rotateInUpLeft'    => esc_html__( 'Rotate In Up Left', 'fruitfulblanktextdomain' ),
		'rotateInUpRight'   => esc_html__( 'Rotate In Up Right', 'fruitfulblanktextdomain' ),
		'slideInUp'         => esc_html__( 'Slide In Up', 'fruitfulblanktextdomain' ),
		'slideInDown'       => esc_html__( 'Slide In Down', 'fruitfulblanktextdomain' ),
		'slideInLeft'       => esc_html__( 'Slide In Left', 'fruitfulblanktextdomain' ),
		'slideInRight'      => esc_html__( 'Slide In Right', 'fruitfulblanktextdomain' ),
		'zoomIn'            => esc_html__( 'Zoom In', 'fruitfulblanktextdomain' ),
		'zoomInDown'        => esc_html__( 'Zoom In Down', 'fruitfulblanktextdomain' ),
		'zoomInLeft'        => esc_html__( 'Zoom In Left', 'fruitfulblanktextdomain' ),
		'zoomInRight'       => esc_html__( 'Zoom In Right', 'fruitfulblanktextdomain' ),
		'zoomInUp'          => esc_html__( 'Zoom In Up', 'fruitfulblanktextdomain' ),
	),
);