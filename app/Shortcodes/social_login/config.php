<?php
/**
 * Social Login Shortcode
 *
 */

use StarterKit\Helper\Utils;

return [
	'name'        => esc_html__( 'Social Login Buttons', 'starter-kit' ),
	'base'        => 'social_login',
	'icon'        => Utils::getConfigSetting( 'shortcodes_icon_uri' ) . 'login.svg',
	'category'    => esc_html__( 'Theme Elements', 'starter-kit' ),
	'description' => esc_html__( 'Add social login buttons', 'starter-kit' ),
	'params'      => []
];
