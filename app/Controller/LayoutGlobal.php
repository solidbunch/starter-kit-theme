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
		add_action( 'StarterKit/before_header', [ $this, 'before_header'] );
		add_action( 'StarterKit/header', [ $this, 'header'] );
		add_action( 'StarterKit/after_header', [ $this, 'after_header'] );

		// Footer
		add_action( 'StarterKit/before_footer', [ $this, 'before_footer'] );
		add_action( 'StarterKit/footer', [ $this, 'footer'] );
		add_action( 'StarterKit/after_footer', [ $this, 'after_footer'] );

		// Grid
		add_action( 'StarterKit/layout_start', [ $this, 'layout_start'] );
		add_action( 'StarterKit/layout_end', [ $this, 'layout_end'] );

		// Sidebar
		add_action( 'StarterKit/sidebar', [ $this, 'sidebar'] );

		// Page 404
		add_action( 'StarterKit/before_page_404_content', [ $this, 'before_page_404_content'] );
		add_action( 'StarterKit/page_404_content', [ $this, 'page_404_content'] );
		add_action( 'StarterKit/after_page_404_content', [ $this, 'after_page_404_content'] );

		// Loops
		add_action( 'StarterKit/before_loop', [ $this, 'before_loop'] );
		add_action( 'StarterKit/after_loop', [ $this, 'after_loop'] );

	}

	/**
	 * Template layout hook
	 * StarterKit/before_header
	 */
	function before_header() {

		get_template_part( '/template-parts/header/top-bar');

	}

	/**
	 * Template layout hook
	 * StarterKit/header
	 */
	function header() {

		get_template_part( '/template-parts/header/header-default');

	}

	/**
	 * Template layout hook
	 * StarterKit/after_header
	 */
	function after_header() {

		get_template_part( '/template-parts/header/breadcrumbs');

		get_template_part( '/template-parts/header/composer-header');

	}

	/**
	 * Template layout hook
	 * StarterKit/before_footer
	 */
	function before_footer() {

	}

	/**
	 * Template layout hook
	 * StarterKit/footer
	 */
	function footer() {

		get_template_part( '/template-parts/footer/footer-default');

	}

	/**
	 * Template layout hook
	 * StarterKit/after_footer
	 */
	function after_footer() {

		get_template_part( '/template-parts/header/composer-footer');

	}

	/**
	 * Template layout hook
	 * StarterKit/layout_start
	 */
	function layout_start() {

		get_template_part( '/template-parts/layout/start');

	}

	/**
	 * Template layout hook
	 * StarterKit/layout_end
	 */
	function layout_end() {

		get_template_part( '/template-parts/layout/end');

	}

	/**
	 * Template layout hook
	 * StarterKit/sidebar
	 */
	function sidebar() {

		get_template_part( '/template-parts/sidebar');

	}

	/**
	 * Template layout hook
	 * StarterKit/before_page_404_content
	 */
	function before_page_404_content() {

	}

	/**
	 * Template layout hook
	 * StarterKit/page_404_content
	 */
	function page_404_content() {

		get_template_part( '/template-parts/page_404_content');

	}

	/**
	 * Template layout hook
	 * StarterKit/after_page_404_content
	 */
	function after_page_404_content() {

	}


	/**
	 * Template layout hook
	 * StarterKit/before_loop
	 */
	function before_loop() {

		get_template_part( '/template-parts/loop/before');

	}

	/**
	 * Template layout hook
	 * StarterKit/after_loop
	 */
	function after_loop() {

		get_template_part( '/template-parts/pagination');
		get_template_part( '/template-parts/loop/after');

	}

}
