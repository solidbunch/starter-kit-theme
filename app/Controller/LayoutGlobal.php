<?php

namespace StarterKit\Controller;

/**
 * Controller that builds global theme layout using actions
 **/
class LayoutGlobal {

	/**
	 * Constructor
	 **/
	function __construct() {

		// Header
		add_action( 'starter-kit/before_header', [ $this, 'before_header'] );
		add_action( 'starter-kit/header', [ $this, 'header'] );
		add_action( 'starter-kit/after_header', [ $this, 'after_header'] );

		// Footer
		add_action( 'starter-kit/before_footer', [ $this, 'before_footer'] );
		add_action( 'starter-kit/footer', [ $this, 'footer'] );
		add_action( 'starter-kit/after_footer', [ $this, 'after_footer'] );

		// Grid
		add_action( 'starter-kit/layout_start', [ $this, 'layout_start'] );
		add_action( 'starter-kit/layout_end', [ $this, 'layout_end'] );

		// Sidebar
		add_action( 'starter-kit/sidebar', [ $this, 'sidebar'] );

		// Page 404
		add_action( 'starter-kit/before_page_404_content', [ $this, 'before_page_404_content'] );
		add_action( 'starter-kit/page_404_content', [ $this, 'page_404_content'] );
		add_action( 'starter-kit/after_page_404_content', [ $this, 'after_page_404_content'] );

		// Loops
		add_action( 'starter-kit/before_loop', [ $this, 'before_loop'] );
		add_action( 'starter-kit/after_loop', [ $this, 'after_loop'] );

	}

	/**
	 * Template layout hook
	 * starter-kit/before_header
	 */
	function before_header() {

		get_template_part( '/template-parts/header/top-bar');

	}

	/**
	 * Template layout hook
	 * starter-kit/header
	 */
	function header() {

		get_template_part( '/template-parts/header/header-default');

	}

	/**
	 * Template layout hook
	 * starter-kit/after_header
	 */
	function after_header() {

		get_template_part( '/template-parts/header/breadcrumbs');

	}

	/**
	 * Template layout hook
	 * starter-kit/before_footer
	 */
	function before_footer() {

	}

	/**
	 * Template layout hook
	 * starter-kit/footer
	 */
	function footer() {

		get_template_part( '/template-parts/footer/footer-default');

	}

	/**
	 * Template layout hook
	 * starter-kit/after_footer
	 */
	function after_footer() {

	}

	/**
	 * Template layout hook
	 * starter-kit/layout_start
	 */
	function layout_start() {

		get_template_part( '/template-parts/layout/start');

	}

	/**
	 * Template layout hook
	 * starter-kit/layout_end
	 */
	function layout_end() {

		get_template_part( '/template-parts/layout/end');

	}

	/**
	 * Template layout hook
	 * starter-kit/sidebar
	 */
	function sidebar() {

		get_template_part( '/template-parts/sidebar');

	}

	/**
	 * Template layout hook
	 * starter-kit/before_page_404_content
	 */
	function before_page_404_content() {

	}

	/**
	 * Template layout hook
	 * starter-kit/page_404_content
	 */
	function page_404_content() {

		get_template_part( '/template-parts/page_404_content');

	}

	/**
	 * Template layout hook
	 * starter-kit/after_page_404_content
	 */
	function after_page_404_content() {

	}


	/**
	 * Template layout hook
	 * starter-kit/before_loop
	 */
	function before_loop() {

		get_template_part( '/template-parts/loop/before');

	}

	/**
	 * Template layout hook
	 * starter-kit/after_loop
	 */
	function after_loop() {

		get_template_part( '/template-parts/pagination');
		get_template_part( '/template-parts/loop/after');

	}

}
