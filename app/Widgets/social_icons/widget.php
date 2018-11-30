<?php

namespace StarterKit\Widgets\social_icons;

class widget extends \WP_Widget {

	/**
	 * Widget constructor
	 **/
	function __construct() {

		$widget_ops = array(
			'classname'   => 'social_icons_widget',
			'description' => esc_html__( 'A widget that displays social icons', 'starter-kit' )
		);

		$control_ops = array(
			'width'   => 300,
			'height'  => 350,
			'id_base' => 'social_icons_widget'
		);

		parent::__construct(
			'social_icons_widget',
			esc_html__( '[STARTER KIT] Social Icons', 'starter-kit' ),
			$widget_ops,
			$control_ops
		);

		add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );

	}

	/**
	 * Add widget styles only when it really loaded on the page
	 **/
	function add_styles() {
		if ( is_active_widget( false, false, $this->id_base, true ) ) {
			wp_enqueue_style( 'font-awesome' );

			//wp_enqueue_style( 'my-style', \StarterKit\Helper\Utils::get_widgets_uri( 'social_icons', '/assets/my-style.css') );

		}
	}

	/**
	 * Admin: save widget settings
	 **/
	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = strip_tags( str_replace( '\'', "&#39;", $new_instance['title'] ) );

		return $instance;
	}

	/**
	 * Admin: widget settings form
	 **/
	function form( $instance ) {

		Starter_Kit()->View->load(
			'/view/backend',
			array(
				'widget'   => $this,
				'instance' => $instance
			),
			false,
			dirname( __FILE__ )
		);

	}

	/**
	 * Front-end output
	 **/
	function widget( $args, $instance ) {

		Starter_Kit()->View->load(
			'/view/frontend',
			array(
				'args'     => $args,
				'instance' => $instance
			),
			false,
			dirname( __FILE__ )
		);

	}

}
