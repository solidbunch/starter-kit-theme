<?php
/**
 * Team members post type options array
 **/
$options = array(
	'template' => array(
		'title'		=> esc_html__( 'Template settings', 'bvc' ),
		'type'		=> 'box',
		'options'	=> array(

			'disable_particles_header' => array(
				'label' => esc_html__( 'Disable particles header', 'bvc' ),
				'desc' => esc_html__( 'this option removes particles header', 'bvc' ),
				'type' => 'switch',
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'bvc' )
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'bvc' )
				),
				'value' => 'no',
			),

			'disable_breadcrumbs' => array(
				'label' => esc_html__( 'Disable breadcrumbs', 'bvc' ),
				'desc' => esc_html__( 'this option removes breadcrumbs from current page', 'bvc' ),
				'type' => 'switch',
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'bvc' )
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'bvc' )
				),
				'value' => 'no',
			),

			'disable_particles_footer' => array(
				'label' => esc_html__( 'Disable particles footer', 'bvc' ),
				'desc' => esc_html__( 'this option removes particles footer from page template', 'bvc' ),
				'type' => 'switch',
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'bvc' )
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'bvc' )
				),
				'value' => 'no',
			),

		) 
	),

);