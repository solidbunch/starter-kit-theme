<?php
/**
 * Page options array
 **/

use StarterKit\Repository\ComposerLayoutRepository;

$headers = ComposerLayoutRepository::get_default_layout( 'header' );
$footers = ComposerLayoutRepository::get_default_layout( 'footer' );

$choices_headers = $choices_footers = [
	''       => esc_html__( 'Inherit', 'starter-kit' ),
	'_none_' => esc_html__( 'None', 'starter-kit' ),
];

foreach ( $headers->posts as $header ) {
	$choices_headers[ $header->ID ] = $header->post_title;
}

foreach ( $footers->posts as $footer ) {
	$choices_footers[ $footer->ID ] = $footer->post_title;
}

$options = [
	'settings' => [
		'title'   => esc_html__( 'Header & Footer options', 'starter-kit' ),
		'type'    => 'box',
		'options' => [
			
			'_this_header' => [
				'label'      => esc_html__( 'Page Header', 'starter-kit' ),
				'type'       => 'select',
				'value'      => '',
				'choices'    => $choices_headers,
				'fw-storage' => [
					'type'      => 'post-meta',
					'post-meta' => '_this_header',
				],
			
			],
			'_this_footer' => [
				'label'      => esc_html__( 'Page Footer', 'starter-kit' ),
				'type'       => 'select',
				'value'      => '',
				'choices'    => $choices_footers,
				'fw-storage' => [
					'type'      => 'post-meta',
					'post-meta' => '_this_footer',
				],
			
			]
		
		]
	],
];
