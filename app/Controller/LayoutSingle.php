<?php

namespace StarterKit\Controller;

/**
 * Controller that builds single post / page etc. layout using actions
 **/
class LayoutSingle {

	/**
	 * Constructor
	 **/
	function __construct() {

		// Post layout
		add_action( 'starter-kit/before_single_post', [ $this, 'before_single_post'] );
		add_action( 'starter-kit/after_single_post', [ $this, 'after_single_post'] );

		// Post thumbnail
		add_action( 'starter-kit/before_single_post_thumbnail', [ $this, 'before_single_post_thumbnail'] );
		add_action( 'starter-kit/single_post_thumbnail', [ $this, 'single_post_thumbnail'] );
		add_action( 'starter-kit/after_single_post_thumbnail', [ $this, 'after_single_post_thumbnail'] );

		// Post title
		add_action( 'starter-kit/before_single_post_title', [ $this, 'before_single_post_title'] );
		add_action( 'starter-kit/single_post_title', [ $this, 'single_post_title'] );
		add_action( 'starter-kit/after_single_post_title', [ $this, 'after_single_post_title'] );

		// Post content
		add_action( 'starter-kit/before_single_post_content', [ $this, 'before_single_post_content'] );
		add_action( 'starter-kit/single_post_content', [ $this, 'single_post_content'] );
		add_action( 'starter-kit/after_single_post_content', [ $this, 'after_single_post_content'] );

		// Post comments
		add_action( 'starter-kit/before_single_post_comments', [ $this, 'before_single_post_comments'] );
		add_action( 'starter-kit/single_post_comments', [ $this, 'single_post_comments'] );
		add_action( 'starter-kit/after_single_post_comments', [ $this, 'after_single_post_comments'] );

	}

	/**
	 * Single post content hook
	 * starter-kit/before_post
	 */
	function before_single_post() {

		get_template_part( '/template-parts/single/before');

	}

	/**
	 * Single post content hook
	 * starter-kit/after_post
	 */
	function after_single_post() {

		get_template_part( '/template-parts/single/after');

	}

	/**
	 * Single post content hook
	 * starter-kit/before_post_title
	 */
	function before_single_post_title() {

	}

	/**
	 * Single post content hook
	 * starter-kit/post_title
	 */
	function single_post_title() {

		get_template_part( '/template-parts/single/title');

	}

	/**
	 * Single post content hook
	 * starter-kit/after_post_title
	 */
	function after_single_post_title() {

		get_template_part( '/template-parts/single/data');

	}

	/**
	 * Single post content hook
	 * starter-kit/before_post_thumbnail
	 */
	function before_single_post_thumbnail() {

	}

	/**
	 * Single post content hook
	 * starter-kit/post_thumbnail
	 */
	function single_post_thumbnail() {

		get_template_part( '/template-parts/single/thumbnail');

	}

	/**
	 * Single post content hook
	 * starter-kit/after_post_thumbnail
	 */
	function after_single_post_thumbnail() {

	}

	/**
	 * Single post content hook
	 * starter-kit/before_post_content
	 */
	function before_single_post_content() {

	}

	/**
	 * Single post content hook
	 * starter-kit/post_content
	 */
	function single_post_content() {

		get_template_part( '/template-parts/single/content');

	}

	/**
	 * Single post content hook
	 * starter-kit/after_post_content
	 */
	function after_single_post_content() {

		get_template_part( '/template-parts/single/pagination');

	}

	/**
	 * Single post content hook
	 * starter-kit/before_post_comments
	 */
	function before_single_post_comments() {

	}

	/**
	 * Single post content hook
	 * starter-kit/post_comments
	 */
	function single_post_comments() {

		get_template_part( '/template-parts/single/comments');

	}

	/**
	 * Single post content hook
	 * starter-kit/after_post_comments
	 */
	function after_single_post_comments() {

	}

}
