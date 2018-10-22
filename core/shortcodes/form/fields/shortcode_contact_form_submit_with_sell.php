<?php

vc_map(array(
	'name'            => esc_html__( 'Form Submit with Sell', 'fruitfulblanktextdomain' ),
	'base'            => 'shortcode_contact_form_submit_with_sell',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'fruitfulblanktextdomain' ),
	'as_child'        => array(
		'only' => 'shortcode_contact_form,vc_column_inner',
	),
	'params'          => array(
		
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Label Buy', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'This text will appear in submit button', 'fruitfulblanktextdomain' ),
			'param_name'  => 'buy_button_text',
			'holder'	  => 'h2',
			'value'       => esc_html__( 'Buy', 'fruitfulblanktextdomain' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Text Buy', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'This text will appear in Buy link', 'fruitfulblanktextdomain' ),
			'param_name'  => 'buy_link_text',
			'value'       => esc_html__( 'Wanna buy?', 'fruitfulblanktextdomain' ),
			'dependency'  => array(
				'element' => 'sell',
				'not_empty' => true,
			),
		),
 		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Enable Sell button', 'fruitfulblanktextdomain' ),
			'param_name'  => 'sell',
			'description' => esc_html__( 'Enable Sell button func', 'fruitfulblanktextdomain' ),
			'value'       => array( esc_html__('Yes', 'fruitfulblanktextdomain') => 'yes' ),
			'std'         => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Label Sell', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'This text will appear in submit button', 'fruitfulblanktextdomain' ),
			'param_name'  => 'sell_button_text',
			'value'       => esc_html__( 'Sell', 'fruitfulblanktextdomain' ),
			'dependency'  => array(
				'element'   => 'sell',
				'not_empty' => true,
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Text Sell', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'This text will appear in submit button', 'fruitfulblanktextdomain' ),
			'param_name'  => 'sell_link_text',
			'holder'	  => 'h2',
			'value'       => esc_html__( 'Open Sell currency form', 'fruitfulblanktextdomain' ),
			'dependency'  => array(
				'element'   => 'sell',
				'not_empty' => true,
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
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Data field Label', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Enter a field name for Humans', 'fruitfulblanktextdomain' ),
			'param_name'  => 'input_label',
			'value'       => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Data field ID', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Used in "name" attribute', 'fruitfulblanktextdomain' ),
			'param_name'  => 'input_id',
			'value'       => '',
		),
	
	)
));

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_shortcode_Contact_Form_Submit_with_sell extends WPBakeryShortCode {
		

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content($atts, $content = null) {			

			if ( !empty($_GET['operation']) ) {
				$operation = $_GET['operation'];
			} else {
				$operation = 'BUY';
			}

			/** init scripts **/
			$this->enqueue_scripts($operation);
			
			$data = vc_map_get_attributes( $this->getShortcode(), $atts ); 
			 

			return FFBLANK()->view->load( '/../view/contact_form_submit_with_sell', $data, true, dirname( __FILE__ ) );

		}

		/**
		 *
		 * Add Styles and scripts
		 *		 
		 * @param string
		 *
		 * @return void
		 */
		public function enqueue_scripts($operation) {

			$shortcode_uri =  get_template_directory_uri() . '/core/shortcodes/form/';
			
			/** scripts **/
			wp_enqueue_script('shortcode-submit-with-sell', $shortcode_uri . 'assets/submit-with-sell.js',array('jquery'), FFBLANK()->config['cache_time']);
			
			wp_localize_script('shortcode-submit-with-sell', 'ShortcodeSubmitWithSell', array(
				'operation_to' => $operation,
				)
			);		
		}
		
	}
}
