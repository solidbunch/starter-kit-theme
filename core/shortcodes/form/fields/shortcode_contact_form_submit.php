<?php

vc_map(array(
	'name'            => esc_html__( 'Form Submit', 'fruitfulblanktextdomain' ),
	'base'            => 'shortcode_contact_form_submit',
	'icon'        => FFBLANK()->config['shortcodes_icon_uri'] . 'enter.svg',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'fruitfulblanktextdomain' ),
	'as_child'        => array(
		'only' => 'shortcode_contact_form,vc_column_inner'
	),
	'params'          => array(
		
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Label', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'This text will appear in submit button', 'fruitfulblanktextdomain' ),
			'param_name'  => 'submit_button_text',
			'holder'	  => 'h2',
			'value'       => esc_html__( 'Send', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Button Align', 'fruitfulblanktextdomain' ),
			'param_name'  => 'align',
			'save_always' => true,
			'value'       => array(
				esc_html__( 'None', 'wplab-bvc-core' )   => '',
				esc_html__( 'Left', 'wplab-bvc-core' )   => 'left',
				esc_html__( 'Center', 'wplab-bvc-core' ) => 'center',
				esc_html__( 'Right', 'wplab-bvc-core' )  => 'right',
			),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Button ID', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Here you can set unique identifier for this button', 'fruitfulblanktextdomain' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'value'       => '',
		),	
	)
));

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Shortcode_Contact_Form_Submit extends WPBakeryShortCode{		
		
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content( $atts, $content = null ){

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			$data = $atts;
			
			return FFBLANK()->view->load( '/../view/contact_form_submit', $data, true, dirname( __FILE__ ) );
			
		}
		
	}
}
