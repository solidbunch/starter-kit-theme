<?php

namespace StarterKit\Handlers;

/**
 * builds single post / page etc. layout using actions
 **/
class LayoutSingle {
	
	/**
	 * Single post content hook
	 * StarterKit/before_post
	 */
	public static function before_single_post() {
		get_template_part( '/template-parts/single/before' );
	}
	
	/**
	 * Single post content hook
	 * StarterKit/after_post
	 */
	public static function after_single_post() {
		get_template_part( '/template-parts/single/after' );
	}
	
	/**
	 * Single post content hook
	 * StarterKit/before_post_title
	 */
	public static function before_single_post_title() {
	}
	
	/**
	 * Single post content hook
	 * StarterKit/post_title
	 */
	public static function single_post_title() {
		get_template_part( '/template-parts/single/title' );
	}
	
	/**
	 * Single post content hook
	 * StarterKit/after_post_title
	 */
	public static function after_single_post_title() {
		get_template_part( '/template-parts/single/data' );
	}
	
	/**
	 * Single post content hook
	 * StarterKit/before_post_thumbnail
	 */
	public static function before_single_post_thumbnail() {
	}
	
	/**
	 * Single post content hook
	 * StarterKit/post_thumbnail
	 */
	public static function single_post_thumbnail() {
		get_template_part( '/template-parts/single/thumbnail' );
	}
	
	/**
	 * Single post content hook
	 * StarterKit/after_post_thumbnail
	 */
	public static function after_single_post_thumbnail() {
	}
	
	/**
	 * Single post content hook
	 * StarterKit/before_post_content
	 */
	public static function before_single_post_content() {
	}
	
	/**
	 * Single post content hook
	 * StarterKit/post_content
	 */
	public static function single_post_content() {
		get_template_part( '/template-parts/single/content' );
	}
	
	/**
	 * Single post content hook
	 * StarterKit/after_post_content
	 */
	public static function after_single_post_content() {
		get_template_part( '/template-parts/single/pagination' );
	}
	
	/**
	 * Single post content hook
	 * StarterKit/before_post_comments
	 */
	public static function before_single_post_comments() {
	}
	
	/**
	 * Single post content hook
	 * StarterKit/post_comments
	 */
	public static function single_post_comments() {
		get_template_part( '/template-parts/single/comments' );
	}
	
	/**
	 * Single post content hook
	 * StarterKit/after_post_comments
	 */
	public static function after_single_post_comments() {
	}
}
