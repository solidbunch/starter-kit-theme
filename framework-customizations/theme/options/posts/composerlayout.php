<?php
/**
 * Team composerlayout post type options array
 **/

$args = array(
	'public'          => true,
	'capability_type' => 'page',
);

$post_types_cap_page = get_post_types( $args, 'objects' );

$args = array(
	'public'             => true,
	'publicly_queryable' => true,
	'capability_type'    => 'post',
);

$post_types_cap_post = get_post_types( $args, 'objects' );

$post_types = array_merge( $post_types_cap_page, $post_types_cap_post );

$choices = array(
	'default'           => esc_html__( 'Default', 'tttextdomain' ),
	'for-manual-select' => esc_html__( 'For manual select', 'tttextdomain' ),
	'is-home'           => esc_html__( 'Blog page', 'tttextdomain' ),
	'is-search'         => esc_html__( 'Search results page', 'tttextdomain' ),
	'is-archive'        => esc_html__( 'Archive page', 'tttextdomain' ),
	'is-404'            => esc_html__( '404 page', 'tttextdomain' ),
);

foreach ( $post_types as $post_type ) {
	$choices[ $post_type->name ] = $post_type->label;
}

$options = array(
	'settings' => array(
		'title'   => esc_html__( 'Settings', 'tttextdomain' ),
		'type'    => 'box',
		'options' => array(
			
			'_layouttype'  => array(
				'label'      => esc_html__( 'Layout type', 'tttextdomain' ),
				'type'       => 'radio',
				'value'      => 'header',
				'choices'    => array(
					'header' => esc_html__( 'Header', 'tttextdomain' ),
					'footer' => esc_html__( 'Footer', 'tttextdomain' ),
				),
				'fw-storage' => array(
					'type'      => 'post-meta',
					'post-meta' => '_layouttype',
				),
			),
			'_appointment' => array(
				'type'       => 'select',
				'label'      => esc_html__( 'Placement', 'tttextdomain' ),
				'value'      => 'default',
				'desc'       => esc_html__( 'Where this Header/Footer will be shown', 'tttextdomain' ),
				'choices'    => $choices,
				'fw-storage' => array(
					'type'      => 'post-meta',
					'post-meta' => '_appointment',
				),
			)
		
		)
	),

);
