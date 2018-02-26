<?php

/**
  * Post Simple Shortcode
  * Example shortcode
**/

// Map VC shortcode
require_once 'config.php';

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_fruitfulblankprefix_PostSimple extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			$id = 'shortcode-' . $atts['el_id'];

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


			$assets_path = get_template_directory_uri() . '/core/shortcodes/post_simple/assets';
			
			// Add shortcode style
			wp_enqueue_style( 'fruitfulblankprefix-postsimple', $assets_path . '/style.css', false, _FBCONSTPREFIX_CACHE_TIME_ );
			
			// Add shortcode inline style
			if( $inline_css <> '' ) {
				wp_add_inline_style( 'fruitfulblankprefix-postsimple', $inline_css );
			}
			
			// Add shortcode script
			wp_enqueue_script( 'fruitfulblankprefix-postsimple', $assets_path . '/scripts.js', array( 'jquery' ) );
			
			// Add shortcode inline script
			$js_vars = array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'strSuccess' => esc_html__('Success', 'fruitfulblanktextdomain'),
				'strError' => esc_html__('Error', 'fruitfulblanktextdomain'),
				'strAJAXError' => esc_html__('An AJAX error occurred when performing a query. Please contact support if the problem persists.', 'fruitfulblanktextdomain'),
				'strServerResponseError' => esc_html__('The script have received an invalid response from the server. Please contact support if the problem persists.', 'fruitfulblanktextdomain'),
				'strFormError' => esc_html__('Form validation error. Please check all required fields and try again.', 'fruitfulblanktextdomain'),
			);
			
			wp_localize_script('fruitfulblankprefix-postsimple', 'PostSimpleVars', $js_vars);


			$items = $this->get_postsimple($atts);

			/** Shortcode data to output **/
			$data = array(
				'id' => $id,
				'css_class' => ' '.$atts['classes'],
				'items' => $items,
				'load_more' => $atts['load_more'],
				'load_more_text' => $atts['load_more_text'],
			);
			
			return apply_filters( 'load_shortcode_tpl', 'view', $data, dirname( __FILE__ ).'/view/' );
      
		}
		
		protected function get_postsimple($atts) {
			
			$q_array = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => absint( $atts['posts_per_page'] ),
				'order' => $atts['order'],
				'orderby' => $atts['orderby'],
			);

			return new WP_Query( $q_array );
		}

	}
}