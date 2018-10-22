<?php

use ffblank\helper\currcodes;


$currency_codes  = currcodes::get_currency_codes();
$currencies_arr  = array();

foreach ( $currency_codes as $currency_code ) {
    $currencies_arr[] = array(
        "label" => $currency_code,
        "value" => $currency_code
    );
}

vc_map(array(
	'name'            => esc_html__( 'Select Coin Field', 'fruitfulblanktextdomain' ),
	'base'            => 'shortcode_contact_form_coin_select',
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
            'type'        => 'autocomplete',
            'heading'     => esc_html__( 'Currency', 'fruitfulblanktextdomain' ),
            'description' => esc_html__( 'Enter currency code to sell. *** If empty - GBP by default.', 'fruitfulblanktextdomain' ),
            'param_name'  => 'sell',
            'value'       => $currencies_arr[0],
            'settings'    => array(
                'multiple'       => true,
                'sortable'       => true,
                'unique_values'  => true,
                'display_inline' => true,
                'min_length'     => 1,
                'delay'          => 100,
                'auto_focus'     => true,
                'values'         => $currencies_arr,
            ),
        ),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Buy or Sell?', 'fruitfulblanktextdomain' ),
			'param_name' => 'operation',
			'value'      => array(
				esc_html__( 'BUY', 'fruitfulblanktextdomain' )  => 'BUY',
				esc_html__( 'SELL', 'fruitfulblanktextdomain' ) => 'SELL',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show all Coins', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Show or hide Coins only for Landing page', 'fruitfulblanktextdomain' ),
			'param_name'  => 'show_all',
			'value'       => array( esc_html__('Yes', 'fruitfulblanktextdomain') => 'yes' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Mandatory Field', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Make this field mandatory?', 'fruitfulblanktextdomain' ),
			'param_name'  => 'required',
			'value'       => array(esc_html__( 'Yes', 'fruitfulblanktextdomain') => 'yes' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Minimum ordered value', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Enter minimum order', 'fruitfulblanktextdomain' ),
			'param_name'  => 'min_order',
			'value'       => '500',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Minimum ordered message', 'fruitfulblanktextdomain' ),
			'description' => esc_html__( 'Enter minimum order alert message', 'fruitfulblanktextdomain' ),
			'param_name'  => 'min_order_msg',
			'value'       => esc_html__( 'Minimum Order Value is %d. If you want to invest less, <a target="_blank" href="http://partners.etoro.com/B9157_A62794_TClick_S2738.aspx">visit eToro</a>', 'fruitfulblanktextdomain' ),
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
	class WPBakeryShortCode_shortcode_Contact_Form_Coin_Select extends WPBakeryShortCode {		

		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return bool|mixed|string
		 */
		protected function content($atts, $content = null) {					

			global $ff_shortcode_core, $post;
			$api_url = $code_sell = $code_buy = $coins_course_api_query = $coins_margin = $min_order = $min_order_msg = $required = '';
			
			$atts           = vc_map_get_attributes( $this->getShortcode(), $atts );			
			$min_order      = $atts['min_order'];
			$min_order_msg  = $atts['min_order_msg'];
			$shortcode_path = __DIR__ . DIRECTORY_SEPARATOR;			

			$coins_course_api_url = fw_get_db_settings_option( 'coins_course_api_url');	
			$coins_margin_default = fw_get_db_settings_option('coins_margin');
			$coins_margin_default = ($coins_margin_default === '0' || ($coins_margin_default !== '' && (float)$coins_margin_default))
				? (float)$coins_margin_default : null;			
			$coins_course_api = parse_url( $coins_course_api_url );
			parse_str( $coins_course_api['query'], $coins_course_api_query );

			if ( ! empty( $coins_course_api_url ) ) {
				$api_url = !empty( $coins_course_api['scheme'] ) ? $coins_course_api['scheme'] . '://' : 'http://';
				$api_url .= $coins_course_api['host'];
				$api_url .= $coins_course_api['path'];
			}

			$attributes   = array();
			$attributes[] = 'id="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name="field_' . esc_attr($atts['el_id']) . '"';

			if ( filter_var( $atts['required'], FILTER_VALIDATE_BOOLEAN ) ) {
				$required = 'required="required"';
			}
			
			$meta_query = array(
				array(
					'key'     => 'fw_options',
					'compare' => 'LIKE',
					'value'   => '"code"'
				),
			);
					
			if ( $atts['show_all'] != 'yes' ) {
				$meta_query['relation'] = 'AND';
				$meta_query[] = array(
					'relation' => 'OR',
					array(
						'key'   => 'only_in_landing',
						'value' => 'no',
					),
					array(
						'key'     => 'only_in_landing',
						'compare' => 'NOT EXISTS',
					),
				);
			}

			$qw_args = array(
				'post_type'      => 'coins',
				'posts_per_page' => -1,
				'meta_query'     => $meta_query,
				'orderby'        => 'menu_order',
				'order'          => 'ASC'
			);

			$coins       = new WP_Query($qw_args);
			$code_sell   = ( empty( $atts['sell'] ) ) ? 'GBP' : esc_attr($atts['sell']);
			$sell_symbol = $currency_codes = currcodes::get_currency_symbol($code_sell);;

			/**
			 * @param array $select_input_items - array for <select> input values. Used in ../view/contact_form_select_coin.php
			 */			
			$select_input_items = explode( ',', $code_sell );		
			$code_buy =  fw_get_db_post_option( $coins->posts[0]->ID, 'code' );
			
			if ( ! empty( $_GET['currency'] ) ) {
				$code_buy = $_GET['currency'];
			}	

			$info = array(
				'api_url'              => $api_url,
				'code_sell'            => $code_sell,
				'code_buy'             => $code_buy,
				'sell_symbol'          => $sell_symbol,
				'api_query'            => $coins_course_api_query,
				'coins_margin_default' => $coins_margin_default,
				'min_order'            => $min_order,
				'min_order_msg'        => sprintf( $min_order_msg, $min_order ),
				'operation'            => $atts['operation'],
			);	

			/** init scripts **/	
			$this->enqueue_scripts($info);		
			
			$data = array(
				'attributes'         => $attributes,
				'atts'               => $atts,
				'select_input_items' => $select_input_items,
				'coins'              => $coins,
				'required'           => $required,
				'code_buy'           => $code_buy,
			);	
				
			return FFBLANK()->view->load( '/../view/contact_form_select_coin', $data, true, dirname( __FILE__ ) );	
			
		}

		/**
		 *
		 * Add Styles and scripts
		 *
		 * @param array $info 		 
		 *
		 * @return void
		 */
		public function enqueue_scripts( $info ) {

			$shortcode_uri  =  get_template_directory_uri() . '/core/shortcodes/form/';

			/** scripts **/
			wp_enqueue_script( 'shortcode-contact-form-select-coin', $shortcode_uri . 'assets/select-coin.js', array(), 4 );

			wp_localize_script( 'shortcode-contact-form-select-coin', 'shortcodeSelectCoin', $info );
		}
		
	}
}
