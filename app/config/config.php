<?php
/**
 * Application config
 *
 * Return an array with predefined config values
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
return [
	'cache_time'          => '201812022311',
	'assets_uri'          => get_template_directory_uri() . '/assets/',
	'shortcodes_dir'      => get_template_directory() . '/app/Shortcodes/',
	'shortcodes_uri'      => get_template_directory_uri() . '/app/Shortcodes/',
	'shortcodes_icon_uri' => get_template_directory_uri() . '/assets/images/icon/',
	'widgets_dir'         => get_template_directory() . '/app/Widgets/',
	'widgets_uri'         => get_template_directory_uri() . '/app/Widgets/',
	'social_profiles'     => include '_social_profiles.php',
	'social_icons'        => include '_social_icons.php',
	'animations'          => include '_animations.php',
];
