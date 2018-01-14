<?php

/**
 * Get posts using AJAX
 **/
add_action('wp_ajax_fruitfulblankprefix_postsimple', 'fruitfulblankprefix_ajax_postsimple');
add_action('wp_ajax_nopriv_fruitfulblankprefix_postsimple', 'fruitfulblankprefix_ajax_postsimple');

function fruitfulblankprefix_ajax_postsimple() {
	
	$data = $_POST['data'];

	$current_page = absint( $data['nextPage'] );
	$next_page = $current_page + 1;

	$response = array(
	  'current_page' => $current_page,
	  'next_page' => $next_page,
	  'html' => ''
	);

	$q_array = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => absint( $atts['posts_per_page'] ),
		'order' => $atts['order'],
		'orderby' => $atts['orderby'],
		'paged' => $current_page
	);

	$items = new WP_Query( $q_array );

	if( $items->max_num_pages < $next_page ) {
	  $response['hide_link'] = true;
	}

	if( $items->have_posts() ) {
		
		$i = absint( $data['lastNumber'] ); 
		$response['html'] = '';
		while( $items->have_posts() ) { 
			$items->the_post(); 
			$second_style = $i%2 == 0; 
			$response['html'] .= apply_filters('theme_get_template', 'view', $data, dirname( __FILE__ ).'/view/');


			$i++; 
			$response['last_num'] = $i; 
		}
	}

	wp_send_json($response);
	// You can use wp_send_json_error() or wp_send_json_success() - to send status
}