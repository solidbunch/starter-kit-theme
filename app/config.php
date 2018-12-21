<?php
/**
 * Application config
 *
 * Return an array with predefined config values
 *
 * PHP version 5.6
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
return array(
	'cache_time'          => '201812022311',
	'assets_uri'          => get_template_directory_uri() . '/assets/',
	'shortcodes_dir'      => get_template_directory() . '/app/Shortcodes/',
	'shortcodes_uri'      => get_template_directory_uri() . '/app/Shortcodes/',
	'shortcodes_icon_uri' => get_template_directory_uri() . '/assets/images/icon/',
	'widgets_dir'         => get_template_directory() . '/app/Widgets/',
	'widgets_uri'         => get_template_directory_uri() . '/app/Widgets/',
	'social_profiles'     => array(
		'facebook_url'    => esc_html__( 'Facebook URL', 'starter-kit' ),
		'twitter_url'     => esc_html__( 'Twitter URL', 'starter-kit' ),
		'instagram_url'   => esc_html__( 'Instagram URL', 'starter-kit' ),
		'google_plus_url' => esc_html__( 'Google Plus URL', 'starter-kit' ),
		'pinterest_url'   => esc_html__( 'Pinterest URL', 'starter-kit' ),
		'linkedin_url'    => esc_html__( 'LinkedIn URL', 'starter-kit' ),
		'youtube_url'     => esc_html__( 'YouTube URL', 'starter-kit' ),
		'vimeo_url'       => esc_html__( 'Vimeo URL', 'starter-kit' ),
		'dribbble_url'    => esc_html__( 'Dribbble URL', 'starter-kit' ),
		'behance_url'     => esc_html__( 'Behance URL', 'starter-kit' ),
		'tumblr_url'      => esc_html__( 'Tumblr URL', 'starter-kit' ),
		'flickr_url'      => esc_html__( 'Flickr URL', 'starter-kit' ),
		'medium_url'      => esc_html__( 'Medium URL', 'starter-kit' ),
	),
	'social_icons'        => array(
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
	'animations'          => array(
		'bounce'            => esc_html__( 'Bounce', 'starter-kit' ),
		'pulse'             => esc_html__( 'Pulse', 'starter-kit' ),
		'tada'              => esc_html__( 'Tada', 'starter-kit' ),
		'wobble'            => esc_html__( 'Wobble', 'starter-kit' ),
		'jello'             => esc_html__( 'Jello', 'starter-kit' ),
		'bounceIn'          => esc_html__( 'Bounce In', 'starter-kit' ),
		'bounceInDown'      => esc_html__( 'Bounce In Down', 'starter-kit' ),
		'bounceInLeft'      => esc_html__( 'Bounce In Left', 'starter-kit' ),
		'bounceInRight'     => esc_html__( 'Bounce In Right', 'starter-kit' ),
		'bounceInUp'        => esc_html__( 'Bounce In Up', 'starter-kit' ),
		'fadeIn'            => esc_html__( 'Fade In', 'starter-kit' ),
		'fadeInDown'        => esc_html__( 'Fade In Down', 'starter-kit' ),
		'fadeInDownBig'     => esc_html__( 'Fade In Down Big', 'starter-kit' ),
		'fadeInLeft'        => esc_html__( 'Fade In Left', 'starter-kit' ),
		'fadeInLeftBig'     => esc_html__( 'Fade In Left Big', 'starter-kit' ),
		'fadeInRight'       => esc_html__( 'Fade In Right', 'starter-kit' ),
		'fadeInRightBig'    => esc_html__( 'Fade In Right Big', 'starter-kit' ),
		'fadeInUp'          => esc_html__( 'Fade In Up', 'starter-kit' ),
		'fadeInUpBig'       => esc_html__( 'Fade In Up Big', 'starter-kit' ),
		'flip'              => esc_html__( 'Flip', 'starter-kit' ),
		'flipInX'           => esc_html__( 'Flip in X', 'starter-kit' ),
		'flipInY'           => esc_html__( 'Flip in Y', 'starter-kit' ),
		'flipOutX'          => esc_html__( 'Flip out X', 'starter-kit' ),
		'flipOutY'          => esc_html__( 'Flip out Y', 'starter-kit' ),
		'lightSpeedIn'      => esc_html__( 'Light Speed In', 'starter-kit' ),
		'rotateIn'          => esc_html__( 'Rotate In', 'starter-kit' ),
		'rotateInDownLeft'  => esc_html__( 'Rotate In Down Left', 'starter-kit' ),
		'rotateInDownRight' => esc_html__( 'Rotate In Down Right', 'starter-kit' ),
		'rotateInUpLeft'    => esc_html__( 'Rotate In Up Left', 'starter-kit' ),
		'rotateInUpRight'   => esc_html__( 'Rotate In Up Right', 'starter-kit' ),
		'slideInUp'         => esc_html__( 'Slide In Up', 'starter-kit' ),
		'slideInDown'       => esc_html__( 'Slide In Down', 'starter-kit' ),
		'slideInLeft'       => esc_html__( 'Slide In Left', 'starter-kit' ),
		'slideInRight'      => esc_html__( 'Slide In Right', 'starter-kit' ),
		'zoomIn'            => esc_html__( 'Zoom In', 'starter-kit' ),
		'zoomInDown'        => esc_html__( 'Zoom In Down', 'starter-kit' ),
		'zoomInLeft'        => esc_html__( 'Zoom In Left', 'starter-kit' ),
		'zoomInRight'       => esc_html__( 'Zoom In Right', 'starter-kit' ),
		'zoomInUp'          => esc_html__( 'Zoom In Up', 'starter-kit' ),
	),
);
