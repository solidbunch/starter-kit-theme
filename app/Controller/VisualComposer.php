<?php
namespace StarterKit\Controller;

/**
 * Visual Composer
 *
 * Rewrite default Visual Composer functions
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class VisualComposer {

	/**
	 * Constructor
	 **/
	public function __construct() {

		// replace default VC grid classes
		add_filter( 'vc_shortcodes_css_class', array( $this, 'custom_css_classes_for_vc_grid' ), 10, 2 );

		// Remove default VC elements
		add_action( 'vc_after_init', array( $this, 'setup_vc' ) );

	}


	/**
	 * Set Bootstrap 4 classes for VC Grid
	 **/
	public function custom_css_classes_for_vc_grid( $class_string, $tag ) {

		if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
			$class_string = str_replace( 'vc_row-fluid', 'row-fluid', $class_string );
			$class_string = str_replace( 'vc_row', 'row', $class_string );
			$class_string = str_replace( 'wpb_row', '', $class_string );
			$class_string = str_replace( 'row-o-content-bottom', 'align-items-end', $class_string );
			$class_string = str_replace( 'row-o-content-middle', 'align-items-center', $class_string );
		}

		if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {

			$class_string = str_replace( 'vc_col-sm-', 'col-md-', $class_string );
			$class_string = str_replace( 'vc_col-', 'col-', $class_string );
			//Todo
			//$class_string = preg_replace( '/vc_hidden\-([a-z]{2})/', 'd-$1-none', $class_string );

		}

		return $class_string;
	}

	/**
	 * Remove default VC shortcodes and some unused options
	 **/
	public function setup_vc() {

		/**
		 * if( function_exists( 'vc_disable_frontend') ) {
		 * vc_disable_frontend();
		 * }
		 **/

		if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
			$list = array(
				'page',
				'composerlayout',
			);
			vc_set_default_editor_post_types( $list );
		}

		vc_remove_element( 'vc_btn' );
		vc_remove_element( 'vc_separator' );
		vc_remove_element( 'vc_section' );
		vc_remove_element( 'vc_icon' );
		vc_remove_element( 'vc_zigzag' );
		vc_remove_element( 'vc_text_separator' );
		vc_remove_element( 'vc_message' );
		vc_remove_element( 'vc_hoverbox' );
		vc_remove_element( 'vc_facebook' );
		vc_remove_element( 'vc_tweetmeme' );
		vc_remove_element( 'vc_googleplus' );
		vc_remove_element( 'vc_pinterest' );
		vc_remove_element( 'vc_gallery' );
		vc_remove_element( 'vc_images_carousel' );
		vc_remove_element( 'vc_tta_tabs' );
		vc_remove_element( 'vc_tta_tour' );
		vc_remove_element( 'vc_tta_accordion' );
		vc_remove_element( 'vc_tta_pageable' );
		vc_remove_element( 'vc_cta' );
		vc_remove_element( 'vc_flickr' );
		vc_remove_element( 'vc_progress_bar' );
		vc_remove_element( 'vc_pie' );
		vc_remove_element( 'vc_round_chart' );
		vc_remove_element( 'vc_basic_grid' );
		vc_remove_element( 'vc_media_grid' );
		vc_remove_element( 'vc_masonry_grid' );
		vc_remove_element( 'vc_masonry_media_grid' );
		vc_remove_element( 'vc_tabs' );
		vc_remove_element( 'vc_tour' );
		vc_remove_element( 'vc_accordion' );
		vc_remove_element( 'vc_custom_heading' );
		vc_remove_element( 'vc_toggle' );
		vc_remove_element( 'vc_line_chart' );
		vc_remove_element( 'vc_posts_slider' );
		vc_remove_element( 'vc_gmaps' );

		vc_remove_param( 'vc_row', 'gap' );

		vc_disable_frontend();
	}

}
