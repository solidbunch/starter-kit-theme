<?php

namespace ffblank\shortcode\posts;

add_action( 'wp_ajax_shortcode_load_posts', 'load_posts');
add_action( 'wp_ajax_nopriv_shortcode_load_posts', 'load_posts');

function load_posts() {

	$data = array();

	// FFBLANK()->view->load( '/view/loop_item', $data, true, dirname( __FILE__ ) );

	exit;
}