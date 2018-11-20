<?php

vc_map(array(
	'name'            => esc_html__( 'Form Email', 'starter-kit' ),
	'base'            => 'shortcode_contact_form_email',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'arroba.svg',
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
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Placeholder', 'starter-kit' ),
			'description' => esc_html__( 'This text will be used as field placeholder', 'starter-kit' ),
			'param_name'  => 'placeholder',
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

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_shortcode_Contact_Form_Email extends WPBakeryShortCode {		
		
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content( $atts, $content = null ) {

			$atts         = vc_map_get_attributes( $this->getShortcode(), $atts );
			$attributes   = array();
			$attributes[] = 'id="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'placeholder="' . esc_attr($atts['placeholder']) . '"';

			if ( filter_var( $atts['required'], FILTER_VALIDATE_BOOLEAN ) ) {
				$attributes[] = 'required="required"';
			}

			$data = array(
				'atts'        => $atts,
				'attributes'  => $attributes,
			);

			return Starter_Kit()->View->load( '/../view/contact_form_email', $data, true, dirname( __FILE__ ) );
						
		}
		
	}
}
