<?php
/**
 * Heading Shortcode
 *
 **/

use StarterKit\Model\Shortcode;

if ( !class_exists( 'StarterKitShortcode_Heading' ) ) {
	class StarterKitShortcode_Heading extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'title'		        => '',
				'heading' 			=> '',
				'header_color' 		=> '',
				'text_align'        => '',
				'text_transform'    => '',
				'font_style'        => '',
				'font_weight'       => '',
				'letter_spacing'    => '',
				'font_size'         => '',
				'line_height'       => '',
				'font_size_mobile'  => '',
				'line_height_mobile'=> '',
				'css'               => '',
				'classes'           => ''
			], $this->atts($atts), $this->shortcode );

			if ( ! empty( $atts['el_id'] ) ) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id = $this->shortcode . '_' . rand(100000,1000000);
			}

			$inline_css = [];

			if ( $atts['header_color'] <> '' ) {
				$inline_css[] = 'color: ' . $atts['header_color'];
			}

			/** text align **/
			if ( $atts['text_align'] <> '' ) {
				$inline_css[] = 'text-align: ' . $atts['text_align'];
			}

			/** text transform **/
			if ( $atts['text_transform'] <> '' ) {
				$inline_css[] = 'text-transform: ' . $atts['text_transform'];
			}

			/** font style **/
			if ( $atts['font_style'] <> '' ) {
				$inline_css[] = 'font-style: ' . $atts['font_style'];
			}

			/** font weight **/
			if ( $atts['font_weight'] <> '' ) {
				$inline_css[] = 'font-weight: ' . $atts['font_weight'];
			}

			/** letter spacing **/
			if ( $atts['letter_spacing'] <> '' ) {
				$inline_css[] = 'letter-spacing: ' . $atts['letter_spacing'] . 'px';
			}

			/** font size **/
			if ( $atts['font_size'] <> '' ) {
				$inline_css[] = 'font-size: ' . $atts['font_size'] . 'px';
			}

			/** line height **/
			if ( $atts['line_height'] <> '' ) {
				$inline_css[] = 'line-height: ' . $atts['line_height'] . 'px';
			}
			$inline_css = !empty($inline_css) ? '#' . $id . ' { '.implode(';',$inline_css) .' }':'';

			/** font size for mobile devices **/
			if ( $atts['font_size_mobile'] <> '' ) {
				$inline_css .= '@media screen and (max-width: 995px) { #' . $id . ' { font-size: ' . $atts['font_size_mobile'] . 'px;} }';
			}

			/** line height for mobile devices **/
			if ( $atts['line_height_mobile'] <> '' ) {
				$inline_css .= '@media screen and (max-width: 995px) { #' . $id . ' { line-height: ' . $atts['line_height_mobile'] . 'px;} }';
			}

			if ( $inline_css <> '' ) {
				// hack to attach inline style
				wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/style.css', true, Starter_Kit()->config['cache_time'] );
				wp_add_inline_style( 'theme-style', $inline_css );
			}

			$data = $this->data( array(
				'id'      => $id,
				'atts'    => $atts,
				'content' => $content
			));

			return Starter_Kit()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}