<?php

vc_map(array(
	'name'            => esc_html__( 'Form File Uploader', 'starter-kit' ),
	'base'            => 'shortcode_contact_form_file_uploader',
	'icon'        => Starter_Kit()->config['shortcodes_icon_uri'] . 'file.svg',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'starter-kit' ),
	'as_child'        => array(
		'only' => 'shortcode_contact_form,vc_column_inner'
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
	class WPBakeryShortCode_shortcode_Contact_Form_File_Uploader extends WPBakeryShortCode {
		
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content( $atts, $content = null ){

			/** init style **/
			$this->enqueue_scripts();

			$atts         = vc_map_get_attributes( $this->getShortcode(), $atts );
			$attributes   = array();
			$attributes[] = 'id="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'placeholder="' . esc_attr($atts['placeholder']) . '"';

			$data = array(
				'atts'        => $atts,
				'attributes'  => $attributes,
			);

			return Starter_Kit()->View->load( '/../view/contact_form_file_uploader', $data, true, dirname( __FILE__ ) );
						
		}

		/**
		 *
		 * Add Styles and scripts
		 *		 		 
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			
			
			/** scripts **/
			wp_register_script( 'shortcode-uploader', \StarterKit\Helper\Utils::get_shortcodes_uri( basename( dirname( __FILE__ ) ) ). '../form/assets/uploader.js', array('jquery'), Starter_Kit()->config['cache_time'], true );
			wp_enqueue_script( 'shortcode-uploader' );
		}
		
	}
}
