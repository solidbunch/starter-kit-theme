<?php

vc_map(array(
	'name'            => esc_html__( 'Checkbox Field', 'starter-kit' ),
	'base'            => 'shortcode_contact_form_checkbox',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'checked.svg',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'starter-kit' ),
	'as_child'        => array( 
		'only' => 'shortcode_contact_form, vc_column_inner'
	),
	'params'          => array(

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Field name', 'starter-kit' ),
			'description' => esc_html__( 'Enter a field name for Humans', 'starter-kit' ),
			'param_name'  => 'label',
			'holder'	  => 'h2',
			'value'       => '',
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Mandatory Field', 'starter-kit' ),
			'description' => esc_html__( 'Make this field mandatory?', 'starter-kit' ),
			'param_name'  => 'required',
			'value'       => array( esc_html__('Yes', 'starter-kit') => 'yes' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Field ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'description' => esc_html__( 'Used in "name" attribute', 'starter-kit' ),
		),	
	)
));

if ( class_exists('WPBakeryShortCode') ) {
	class WPBakeryShortCode_shortcode_Contact_Form_Checkbox extends WPBakeryShortCode {

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content($atts, $content = null){
			
			$atts         = vc_map_get_attributes($this->getShortcode(), $atts);
			$attributes   = array();
			$attributes[] = 'id="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name="field_' . esc_attr($atts['el_id']) . '"';

			if ( filter_var( $atts['required'], FILTER_VALIDATE_BOOLEAN) ) {
				$attributes[] = 'required="required"';
			} 
			
			$data = array(
				'atts'       => $atts,
				'content'    => $content,
				'attributes' => $attributes,
			);
				
			return Starter_Kit()->View->load( '/../view/contact_form_checkbox', $data, true, dirname( __FILE__ ) );
			
		}
		
	}
}
