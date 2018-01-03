<?php

/**
  * Coins Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_FBCONSTPREFIX_Coins extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$codes_buy = array();
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
			
			$coins_course_api_url = fw_get_db_settings_option( 'coins_course_api_url');
			$coins_course_api = parse_url($coins_course_api_url);
			parse_str($coins_course_api['query'], $coins_course_api_query);

			if (!empty($coins_course_api_url)) {
				$api_url = !empty($coins_course_api['scheme']) ? $coins_course_api['scheme'] . '://' : 'http://';
				$api_url .= $coins_course_api['host'];
				$api_url .= $coins_course_api['path'];
			}

			if( !isset( $atts['el_id'] ) ) {
				$atts['el_id'] = uniqid();
			}
			
			if (!empty($atts['el_id'])) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id='';
			}

			$assets_path = get_template_directory_uri() . '/core/shortcodes/coins/assets';

			wp_enqueue_style( 'bvc-coins', $assets_path . '/style.css', false, _FBCONSTPREFIX_CACHE_TIME_ );

			wp_register_script( 'bvc-coins', $assets_path . '/scripts.js', array( 'jquery' ), array(), 2 );
			wp_enqueue_script( 'bvc-coins' );
			
			// for meta margin
			$items_for_meta_margin = get_posts( array(
				'post_type' => 'coins',
				'post_status' => 'publish',
				'posts_per_page' => -1
			));
			
			$coints_ids = $coins_margin_arr = array();
			if ($items_for_meta_margin && is_array($items_for_meta_margin)) {
				foreach ($items_for_meta_margin as $coin_item) {
					$coints_ids[] = $coin_item->ID;
				}
			}
			
			if ($coints_ids) {
				foreach ($coints_ids as $coin_id) {
					
					$coins_margin_default = fw_get_db_settings_option('coins_margin');
					$coins_margin_default = ($coins_margin_default === '0' || ($coins_margin_default !== '' && (float)$coins_margin_default))
						? (float)$coins_margin_default : null;
					
					$coins_margin_meta = fw_get_db_post_option($coin_id, 'the_coin_margin');
					$coins_margin_meta = ($coins_margin_meta === '0' || ($coins_margin_meta !== '' && (float)$coins_margin_meta))
						? (float)$coins_margin_meta : null;
					
					$coins_margin = ($coins_margin_meta !== null && $coins_margin_meta >= 0)
						? $coins_margin_meta : (($coins_margin_default !== null && $coins_margin_default >= 0)
							? $coins_margin_default : 0);
					
					$coins_code = fw_get_db_post_option( $coin_id, 'code' ) ?: null;
					
					if($coins_code) {
						$coins_margin_arr[$coins_code] = $coins_margin;
					}
				}
			}

			$js_vars = array(
				'api_url' => $api_url,
				'code_sell' => 'GBP',
				'api_query' => $coins_course_api_query,
				'coins_margin_obj' => $coins_margin_arr,
			);
			wp_localize_script('bvc-coins', 'bvcCoins', $js_vars);
			// :end for meta margin
			
			$q_array = array(
				'post_type' => 'coins',
				'post_status' => 'publish',
				'posts_per_page' => absint( $atts['posts_per_page'] ),
				'order' => $atts['order'],
				'orderby' => $atts['orderby'],
			);
			
			$items = new WP_Query( $q_array );

			ob_start();
			require 'view/view.php';
			return ob_get_clean();
      
		}

	}
}