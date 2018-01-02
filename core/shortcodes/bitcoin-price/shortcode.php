<?php

/**
  * Benefits Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_BVC_Bitcoin_Price extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			$assets_path = get_template_directory_uri() . '/core/shortcodes/bitcoin-price/assets';

			wp_enqueue_style( 'bvc-bitcoin-price', $assets_path . '/style.css', false, _BVC_CACHE_TIME_ );
			wp_enqueue_script( 'animate-number' );
			wp_enqueue_script( 'bvc-bitcoin-price', $assets_path . '/scripts.js', array('jquery', 'animate-number'), _BVC_CACHE_TIME_ );

			$js_vars = array(
				'apiUrl' => str_replace( '{TO}', 'GBP', str_replace( '{FROM}', 'BTC', fw_get_db_settings_option( 'coins_course_api_url') ) )
			);
			wp_localize_script( 'bvc-bitcoin-price', 'bvcBitcoinPriceVars', $js_vars );

			ob_start();
			require 'view/view.php';
			return ob_get_clean();

		}

	}
}
