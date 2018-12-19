<?php
/**
 * Social Login Shortcode
 *
 */

return array(
	'name'        => esc_html__( 'Social Login Buttons', 'starter-kit' ),
	'base'        => 'social_login',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'login.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Add social login buttons', 'starter-kit' ),
	'params'      => array()
);
