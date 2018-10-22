<?php

vc_map(array(
	'name'            => esc_html__( 'Form File Uploader', 'fruitfulblanktextdomain' ),
	'base'            => 'shortcode_contact_form_file_uploader',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'fruitfulblanktextdomain' ),
	'as_child'        => array(
		'only' => 'shortcode_contact_form,vc_column_inner'
	),
	'params'          => array(
			
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Field name', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Enter a field name for Humans', 'fruitfulblanktextdomain' ),
			'param_name'  => 'label',
			'holder'	  => 'h2',
			'value'       => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Placeholder', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'This text will be used as field placeholder', 'fruitfulblanktextdomain' ),
			'param_name'  => 'placeholder',
			'value'       => '',
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Field ID', 'fruitfulblanktextdomain' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'description' => esc_html__( 'Used in "name" attribute', 'fruitfulblanktextdomain' ),
		),	
	)
));

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_shortcode_Contact_Form_File_Uploader extends WPBakeryShortCode {
		
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content( $atts, $content = null ){

			$atts         = vc_map_get_attributes( $this->getShortcode(), $atts );
			$attributes   = array();
			$attributes[] = 'id="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'placeholder="' . esc_attr($atts['placeholder']) . '"';

			$data = array(
				'atts'        => $atts,
				'attributes'  => $attributes,
			);

			return FFBLANK()->view->load( '/../view/contact_form_file_uploader', $data, true, dirname( __FILE__ ) );
						
		}
		
	}
}
