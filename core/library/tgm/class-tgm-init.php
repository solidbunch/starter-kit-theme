<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Anaglyh
 * @version    2.6.1
 * @author     Thomas Griffin <thomasgriffinmedia.com>
 * @author     Gary Jones <gamajo.com>
 * @copyright  Copyright (c) 2014, Thomas Griffin
 * @license    https://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function theme_register_required_plugins() {
	$plugins = array(

		array(
			'name' => 'Unyson',
			'slug' => 'unyson',
			'required' => true
		),

		array(
			'name' => 'WPBakery Page Builder',
			'slug' => 'js_composer',
			'source' => 'https://fruitfulcode.com/themeforest/js_composer.zip',
			'required' => true,
			'version' => '',
			'external_url' => '',
		),

	);

	// it is not necessairy to provide custom language config for TGM, so just leave it default
	tgmpa( $plugins );

}
