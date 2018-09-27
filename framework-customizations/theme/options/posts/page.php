<?php
/**
 * Page options array
 **/

$headers = FFBLANK()->model->layout->get_default_layout( 'header' );
$footers = FFBLANK()->model->layout->get_default_layout( 'footer' );

$choices_headers = $choices_footers = array(
	''       => esc_html__( 'Inherit', 'fruitfulblanktextdomain' ),
	'_none_' => esc_html__( 'None', 'fruitfulblanktextdomain' ),
);

foreach ( $headers->posts as $header ) {
	$choices_headers[ $header->ID ] = $header->post_title;
}

foreach ( $footers->posts as $footer ) {
	$choices_footers[ $footer->ID ] = $footer->post_title;
}

$options = array(
	'settings' => array(
		'title'   => esc_html__( 'Header & Footer options', 'fruitfulblanktextdomain' ),
		'type'    => 'box',
		'options' => array(

			'_this_header' => array(
				'label'      => esc_html__( 'Page Header', 'fruitfulblanktextdomain' ),
				'type'       => 'select',
				'value'      => '',
				'choices'    => $choices_headers,
				'fw-storage' => array(
					'type'      => 'post-meta',
					'post-meta' => '_this_header',
				),

			),
			'_this_footer' => array(
				'label'      => esc_html__( 'Page Footer', 'fruitfulblanktextdomain' ),
				'type'       => 'select',
				'value'      => '',
				'choices'    => $choices_footers,
				'fw-storage' => array(
					'type'      => 'post-meta',
					'post-meta' => '_this_footer',
				),

			)

		)
	),
);
