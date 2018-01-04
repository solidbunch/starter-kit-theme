<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 10.11.2017
 * Time: 12:27
 */
/**
 * Ordering Steps Shortcode
 **/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_FBCONSTPREFIX_Ordering_steps extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {

            $atts = vc_map_get_attributes( $this->getShortcode(), $atts );


            $assets_path = get_template_directory_uri() . '/core/shortcodes/ordering_steps/assets';

            wp_enqueue_style( 'fruitfulblankprefix-ordering-steps', $assets_path . '/style.css', false, _FBCONSTPREFIX_CACHE_TIME_ );

            ob_start();
            require 'view/view.php';
            return ob_get_clean();

        }

    }
}