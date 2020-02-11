<?php

namespace StarterKit\Handlers\PostMeta;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Utils;

class ThemeLayoutsSidebars {
	
	public static function make(): void {
		
		$prefix     = Utils::getConfigSetting( 'settings_prefix', '' );
		$assets_uri = Utils::getConfigSetting( 'assets_uri', get_template_directory_uri() . '/assets/' );
		$images_uri = trailingslashit( $assets_uri ) . 'images/layouts/';
		$post_types = [ 'page', 'post', 'news', 'composerlayout' ];
		
		Container::make( 'post_meta', __( 'Layout/Sidebar Picker', 'starter-kit' ) )
		         ->where( 'post_type', 'IN', $post_types )
		         ->set_context( 'side' )
		         ->set_priority( 'default' )
		         ->set_classes( 'webpage_layout_container' )
		         ->add_fields( [
			         Field::make( 'radio_image', $prefix . 'webpage_layout', __( 'Choose layout', 'starter-kit' ) )
			              ->set_options( [
				              //'default' => $images_uri . 'default.png',
				              'full'    => $images_uri . 'full.png',
				              'right'   => $images_uri . 'right.png',
				              'left'    => $images_uri . 'left.png',
			              ] ),
			         Field::make( 'sidebar', $prefix . 'webpage_sidebar', __( 'Choose sidebar', 'starter-kit' ) )
			              ->disable_add_new()
			              ->set_conditional_logic( [
				              'relation' => 'AND', // Optional, defaults to "AND"
				              [
					              'field'   => $prefix . 'webpage_layout',
					              'value'   => [ 'right', 'left' ], // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
					              'compare' => 'IN', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
				              ],
			              ] ),
		         ] );
	}
}