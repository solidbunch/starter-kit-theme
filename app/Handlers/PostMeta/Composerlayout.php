<?php

namespace StarterKit\Handlers\PostMeta;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Utils;


class Composerlayout {
	
	public static function make(): void {
		
		$prefix = Utils::getConfigSetting( 'settings_prefix', '' );
		
		Container::make( 'post_meta', __( 'Settings', 'starter-kit' ) )
		         ->where( 'post_type', '=', 'composerlayout' )
		         ->set_priority( 'default' )
		         ->add_fields( [
			         Field::make( 'radio', $prefix . '_layouttype', __( 'Layout type', 'starter-kit' ) )
			              ->add_options( [
				              'header' => __( 'Header', 'starter-kit' ),
				              'footer' => __( 'Footer', 'starter-kit' ),
			              ] ),
			         Field::make( 'select', $prefix . '_appointment', __( 'Placement', 'starter-kit' ) )
			              ->add_options( [ __CLASS__, 'getAppointmentChoices' ] )
			              ->set_help_text( __( 'Where this Header/Footer will be shown', 'starter-kit' ) ),
		         ] );
	}
	
	
	
	public static function getAppointmentChoices(): array {
		$args = [
			'public'          => true,
			'capability_type' => 'page',
		];
		
		$post_types_cap_page = get_post_types( $args, 'objects' );
		
		$args = [
			'public'             => true,
			'publicly_queryable' => true,
			'capability_type'    => 'post',
		];
		
		$post_types_cap_post = get_post_types( $args, 'objects' );
		
		$post_types = array_merge( $post_types_cap_page, $post_types_cap_post );
		
		$choices = [
			'default'           => esc_html__( 'Default', 'starter-kit' ),
			'for-manual-select' => esc_html__( 'For manual select', 'starter-kit' ),
			'is-home'           => esc_html__( 'Blog page', 'starter-kit' ),
			'is-search'         => esc_html__( 'Search results page', 'starter-kit' ),
			'is-archive'        => esc_html__( 'Archive page', 'starter-kit' ),
			'is-404'            => esc_html__( '404 page', 'starter-kit' ),
		];
		
		foreach ( $post_types as $post_type ) {
			$choices[ $post_type->name ] = $post_type->label;
		}
		
		return $choices;
	}
}
