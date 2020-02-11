<?php

namespace StarterKit\Handlers;

/**
 * builds global theme layout using actions
 **/
class LayoutGlobal {
	
	/**
	 * Template layout hook
	 * StarterKit/before_header
	 */
	public static function before_header() {
		get_template_part( '/template-parts/header/top-bar' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/header
	 */
	public static function header() {
		get_template_part( '/template-parts/header/header-default' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/after_header
	 */
	public static function after_header() {
		get_template_part( '/template-parts/header/breadcrumbs' );
		get_template_part( '/template-parts/header/composer-header' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/before_footer
	 */
	public static function before_footer() {
	}
	
	/**
	 * Template layout hook
	 * StarterKit/footer
	 */
	public static function footer() {
		get_template_part( '/template-parts/footer/footer-default' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/after_footer
	 */
	public static function after_footer() {
		get_template_part( '/template-parts/footer/composer-footer' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/layout_start
	 */
	public static function layout_start() {
		get_template_part( '/template-parts/layout/start' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/layout_end
	 */
	public static function layout_end() {
		get_template_part( '/template-parts/layout/end' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/sidebar
	 */
	public static function sidebar() {
		get_template_part( '/template-parts/sidebar' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/before_page_404_content
	 */
	public static function before_page_404_content() {
	}
	
	/**
	 * Template layout hook
	 * StarterKit/page_404_content
	 */
	public static function page_404_content() {
		get_template_part( '/template-parts/page_404_content' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/after_page_404_content
	 */
	public static function after_page_404_content() {
	}
	
	/**
	 * Template layout hook
	 * StarterKit/before_loop
	 */
	public static function before_loop() {
		get_template_part( '/template-parts/loop/before' );
	}
	
	/**
	 * Template layout hook
	 * StarterKit/after_loop
	 */
	public static function after_loop() {
		get_template_part( '/template-parts/pagination' );
		get_template_part( '/template-parts/loop/after' );
	}
}
