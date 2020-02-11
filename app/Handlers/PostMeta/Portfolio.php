<?php

namespace StarterKit\Handlers\PostMeta;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Utils;


class Portfolio {
	
	public static function make(): void {
		
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		
		Container::make( 'post_meta', __( 'Portfolio Details', 'starter-kit' ) )
		         ->where( 'post_type', '=', 'portfolio' )
		         ->set_priority( 'default' )
		         ->add_fields( [
			         Field::make( 'media_gallery', $prefix . 'images', __( 'Gallery Images', 'starter-kit' ) )
			              ->set_type( [ 'image' ] ),
		         ] );
	}
	
}
