<?php

/**
  * Heading Shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_fruitfulblankprefix_Heading extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if (!empty($atts['el_id'])) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id='';
			}
			$inline_css = '';

			if( $atts['header_color'] <> '' ) {
				$inline_css .= '#' . $id . ' { color: ' . $atts['header_color'] . ';}';
			}

			/** text align **/
			if( $atts['text_align'] <> '' ) {
				$inline_css .= '#' . $id . ' { text-align: ' . $atts['text_align'] . ';}';
			}

			/** text transform **/
			if( $atts['text_transform'] <> '' ) {
				$inline_css .= '#' . $id . ' { text-transform: ' . $atts['text_transform'] . ';}';
			}

			/** font style **/
			if( $atts['font_style'] <> '' ) {
				$inline_css .= '#' . $id . ' { font-style: ' . $atts['font_style'] . ';}';
			}

			/** font weight **/
			if( $atts['font_weight'] <> '' ) {
				$inline_css .= '#' . $id . ' { font-weight: ' . $atts['font_weight'] . ';}';
			}

			/** letter spacing **/
			if( $atts['letter_spacing'] <> '' ) {
				$inline_css .= '#' . $id . ' { letter-spacing: ' . $atts['letter_spacing'] . 'px;}';
			}

			/** font size **/
			if( $atts['font_size'] <> '' ) {
				$inline_css .= '#' . $id . ' { font-size: ' . $atts['font_size'] . 'px;}';
			}

			/** line height **/
			if( $atts['line_height'] <> '' ) {
				$inline_css .= '#' . $id . ' { line-height: ' . $atts['line_height'] . 'px;}';
			}

			/** font size for mobile devices **/
			if( $atts['font_size_mobile'] <> '' ) {
				$inline_css .= '@media screen and (max-width: 995px) { #' . $id . ' { font-size: ' . $atts['font_size_mobile'] . 'px;} }';
			}

			/** line height for mobile devices **/
			if( $atts['line_height_mobile'] <> '' ) {
				$inline_css .= '@media screen and (max-width: 995px) { #' . $id . ' { line-height: ' . $atts['line_height_mobile'] . 'px;} }';
			}

			if( $inline_css <> '' ) {
				// hack to attach inline style
				wp_enqueue_style( 'fruitfulblankprefix-theme-style', get_template_directory_uri() . '/style.css', true, _FBCONSTPREFIX_CACHE_TIME_ );
				wp_add_inline_style( 'fruitfulblankprefix-theme-style', $inline_css );
			}
			
			/** Shortcode data to output **/
			$data = array(
				'id' => $id,
				'css_class' => $atts['classes'],
				'heading' => $atts['heading'],
				'title' => $atts['title'],
			);
			
			return apply_filters('theme_get_template', 'view', $data, dirname( __FILE__ ).'/view/');
      
		}

	}
}