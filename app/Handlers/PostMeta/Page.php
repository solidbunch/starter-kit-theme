<?php

namespace StarterKit\Handlers\PostMeta;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Utils;
use StarterKit\Repository\ComposerLayoutRepository;


class Page {
	
	public static function make(): void {
		
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		
		Container::make( 'post_meta', __( 'Header & Footer options', 'starter-kit' ) )
		         ->where( 'post_type', '=', 'page' )
		         ->set_priority( 'default' )
		         ->add_fields( [
			         Field::make( 'select', $prefix . '_this_header', __( 'Page Header', 'starter-kit' ) )
			              ->add_options( [ __CLASS__, 'getHeaderChoices' ] ),
			         Field::make( 'select', $prefix . '_this_footer', __( 'Page Footer', 'starter-kit' ) )
			              ->add_options( [ __CLASS__, 'getFooterChoices' ] ),
		         ] );
	}
	
	
	
	public static function getHeaderChoices(): array {
		$headers = ComposerLayoutRepository::get_layouts( 'header' );
		
		$choices = [
			''       => esc_html__( 'Inherit', 'starter-kit' ),
			'_none_' => esc_html__( 'None', 'starter-kit' ),
		];
		
		foreach ( $headers->posts as $header ) {
			$choices[ $header->ID ] = $header->post_title;
		}
		
		return $choices;
	}
	
	
	
	public static function getFooterChoices(): array {
		$footers = ComposerLayoutRepository::get_layouts( 'footer' );
		
		$choices = [
			''       => esc_html__( 'Inherit', 'starter-kit' ),
			'_none_' => esc_html__( 'None', 'starter-kit' ),
		];
		
		foreach ( $footers->posts as $footer ) {
			$choices[ $footer->ID ] = $footer->post_title;
		}
		
		return $choices;
	}
}
