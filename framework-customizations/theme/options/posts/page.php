<?php
/**
 * Team members post type options array
 **/
$options = array(
	'template' => array(
		'title'		=> esc_html__( 'Template settings', 'fruitfulblanktextdomain' ),
		'type'		=> 'box',
		'options'	=> array(

			'disable_particles_header' => array(
				'label' => esc_html__( 'Disable particles header', 'fruitfulblanktextdomain' ),
				'desc' => esc_html__( 'this option removes particles header', 'fruitfulblanktextdomain' ),
				'type' => 'switch',
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'fruitfulblanktextdomain' )
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'fruitfulblanktextdomain' )
				),
				'value' => 'no',
			),

			'disable_breadcrumbs' => array(
				'label' => esc_html__( 'Disable breadcrumbs', 'fruitfulblanktextdomain' ),
				'desc' => esc_html__( 'this option removes breadcrumbs from current page', 'fruitfulblanktextdomain' ),
				'type' => 'switch',
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'fruitfulblanktextdomain' )
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'fruitfulblanktextdomain' )
				),
				'value' => 'no',
			),

			'disable_particles_footer' => array(
				'label' => esc_html__( 'Disable particles footer', 'fruitfulblanktextdomain' ),
				'desc' => esc_html__( 'this option removes particles footer from page template', 'fruitfulblanktextdomain' ),
				'type' => 'switch',
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'fruitfulblanktextdomain' )
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'fruitfulblanktextdomain' )
				),
				'value' => 'no',
			),

		) 
	),

);