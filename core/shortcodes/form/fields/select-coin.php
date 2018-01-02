<?php
/**
 * @param array $currencies - https://gist.github.com/zenzora/8089557
 */
$currency_codes = array("GBP","AFA", "ALL", "DZD", "USD", "EUR", "AOA", "XCD", "NOK", "ARA", "AMD", "AWG", "AUD", "AZM", "BSD", "BHD", "BDT", "BBD", "BYR", "BZD", "XAF", "BMD", "BTN", "BOB", "BAM", "BWP", "BRL", "BND", "BGN", "BIF", "KHR", "CAD", "CVE", "KYD", "CLF", "CNY", "COP", "KMF", "CDZ", "NZD", "CRC", "HRK", "CUP", "CZK", "DKK", "DJF", "DOP", "TPE", "EGP", "ERN", "EEK", "ETB", "FKP", "FJD", "XPF", "GMD", "GEL", "GHC", "GIP", "GTQ", "GNS", "GWP", "GYD", "HTG", "HNL", "HKD", "HUF", "ISK", "INR", "IDR", "IRR", "IQD", "ILS", "JMD", "JPY", "JOD", "KZT", "KES", "KPW", "KRW", "KWD", "KGS", "LAK", "LVL", "LBP", "LSL", "LRD", "LYD", "CHF", "LTL", "MOP", "MKD", "MGF", "MWK", "MYR", "MVR", "MRO", "MUR", "MXN", "MDL", "MNT", "MAD", "MZM", "MMK", "NAD", "NPR", "ANG", "NIC", "XOF", "NGN", "OMR", "PKR", "PAB", "PGK", "PYG", "PEI", "PHP", "PLN", "QAR", "ROL", "RUB", "RWF", "WST", "STD", "SAR", "SCR", "SLL", "SGD", "SBD", "SOS", "ZAR", "LKR", "SHP", "SDG", "SRG", "SZL", "SEK", "SYP", "TWD", "TJR", "TZS", "THB", "TOP", "TTD", "TND", "TRY", "TMM", "UGS", "UAH", "SUR", "AED", "UYU", "UZS", "VUV", "VEF", "VND", "ZMK");

//prepare array for autocomplete values
$currencies_arr = array();
foreach ($currency_codes as $currency_code) {
    $currencies_arr[] = array(
        "label" => $currency_code,
        "value" => $currency_code
    );
}

vc_map(array(
	'name' => esc_html__('Select Coin Field', 'bvc'),
	'base' => 'bvc_contact_form_coin_select',
	'content_element' => true,
	'category' => esc_html__('Form Fields', 'bvc'),
	'as_child' => array('only' => 'bvc_contact_form,vc_column_inner'),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Field name', 'bvc'),
			'description' => esc_html__('Enter a field name for Humans', 'bvc'),
			'param_name' => 'label',
			'holder'		=> 'h2',
			'value' => '',
		),
        array(
            'type' => 'autocomplete',
            'heading' => esc_html__('Sell currency', 'bvc'),
            'description' => esc_html__('Enter currency code to sell. *** If empty - GBP by default.', 'bvc'),
            'param_name' => 'sell',
            'value' => $currencies_arr[0],
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'unique_values' => true,
                'display_inline' => true,
                'min_length' => 1,
                'delay' => 100,
                'auto_focus' => true,
                'values' => $currencies_arr,
            ),
        ),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Mandatory Field', 'bvc'),
			'description' => esc_html__('Make this field mandatory?', 'bvc'),
			'param_name' => 'required',
			'value' => array(esc_html__('Yes', 'bvc') => 'yes'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Minimum ordered value', 'bvc'),
			'description' => esc_html__('Enter minimum order', 'bvc'),
			'param_name' => 'min_order',
			'value' => '500',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Minimum ordered message', 'bvc'),
			'description' => esc_html__('Enter minimum order alert message', 'bvc'),
			'param_name' => 'min_order_msg',
			'value' => 'Minimum Order Value is %d. If you want to invest less, <a target="_blank" href="http://partners.etoro.com/B9157_A62794_TClick_S2738.aspx">visit eToro</a>',
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__('Field ID', 'bvc'),
			'param_name' => 'el_id',
			'settings' => array(
				'auto_generate' => true,
			),
			'description' => esc_html__('Used in "name" attribute', 'bvc'),
		),
	
	)
));

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_bvc_Contact_Form_Coin_Select extends WPBakeryShortCode
	{
		
		protected function content($atts, $content = null) {
			global $ff_bvc_core, $post;
			$api_url = $code_sell = $code_buy = $coins_course_api_query = $coins_margin = $min_order = $min_order_msg = $required = '';
			
			$atts = vc_map_get_attributes($this->getShortcode(), $atts);
			
			$min_order = $atts['min_order'];
			$min_order_msg = $atts['min_order_msg'];
			$shortcode_path = __DIR__ . DIRECTORY_SEPARATOR;
			$shortcode_uri =  get_template_directory_uri() . '/core/shortcodes/form/';

			$coins_course_api_url = fw_get_db_settings_option( 'coins_course_api_url');
			
			$coins_margin_default = fw_get_db_settings_option('coins_margin');
			$coins_margin_default = ($coins_margin_default === '0' || ($coins_margin_default !== '' && (float)$coins_margin_default))
				? (float)$coins_margin_default : null;
			
			$coins_margin_meta = fw_get_db_post_option($coin_id, 'the_coin_margin');
			$coins_margin_meta = ($coins_margin_meta === '0' || ($coins_margin_meta !== '' && (float)$coins_margin_meta))
				? (float)$coins_margin_meta : null;
			
			$coins_margin = ($coins_margin_meta !== null && $coins_margin_meta >= 0)
				? $coins_margin_meta : (($coins_margin_default !== null && $coins_margin_default >= 0)
					? $coins_margin_default : 0);
			
			$coins_course_api = parse_url($coins_course_api_url);
			parse_str($coins_course_api['query'], $coins_course_api_query);

			if (!empty($coins_course_api_url)) {
				$api_url = !empty($coins_course_api['scheme']) ? $coins_course_api['scheme'] . '://' : 'http://';
				$api_url .= $coins_course_api['host'];
				$api_url .= $coins_course_api['path'];
			}

			$attributes = array();
			$attributes[] = 'id="field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name="field_' . esc_attr($atts['el_id']) . '"';

			if (filter_var($atts['required'], FILTER_VALIDATE_BOOLEAN)) {
				$required = 'required="required"';
			}

			$qw_args = array(
				'post_type' => 'coins',
				'posts_per_page' => -1,
				'meta_query' => array(
					array(
						'key' => 'fw_options',
						'compare' => 'LIKE',
						'value' => '"code"'
					)
				),
				'orderby' => 'menu_order',
				'order'=> 'ASC'
			);
			$coins = new WP_Query($qw_args);

			$code_sell = (empty($atts['sell'])) ? 'GBP' : esc_attr($atts['sell']);

            /**
             * @param array $select_input_items - array for <select> input values. Used in ../view/contact_form_select_coin.php
             */
            $select_input_items = explode(',', $code_sell);

			$code_buy =  fw_get_db_post_option( $coins->posts[0]->ID, 'code' );
			
			if (!empty($post->ID)) {
				$code = fw_get_db_post_option( $post->ID, 'code' );
				if (!empty($code)) {
					$code_buy = $code;
				}
			}
			
			/** scripts **/
			wp_enqueue_script('bvc-contact-form-select-coin', $shortcode_uri . 'assets/select-coin.js', array(), 4);

			$js_vars = array(
				'api_url' => $api_url,
				'code_sell' => $code_sell,
				'code_buy' => $code_buy,
				'api_query' => $coins_course_api_query,
				'coins_margin' => $coins_margin,
				'min_order' => $min_order,
				'min_order_msg' => sprintf( $min_order_msg, $min_order ),
			);
			wp_localize_script('bvc-contact-form-select-coin', 'bvcSelectCoin', $js_vars);
			
			ob_start();
			require get_template_directory() . '/core/shortcodes/form/view/contact_form_select_coin.php';
			return ob_get_clean();
			
		}
		
	}
}
