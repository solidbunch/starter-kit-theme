<?php

add_action( 'wp_ajax_bvc_load_testimonials', 'ajax_bvc_load_coins' );
add_action( 'wp_ajax_nopriv_bvc_load_testimonials', 'ajax_bvc_load_coins' );

function ajax_bvc_load_coins() {
	
	$data = $_POST['data'];

	$current_page = absint( $data['nextPage'] );
	$next_page = $current_page + 1;

	$response = array(
	  'current_page' => $current_page,
	  'next_page' => $next_page,
	  'html' => ''
	);

	$q_array = array(
	  'post_type' => 'coins',
	  'post_status' => 'publish',
	  'posts_per_page' => absint( $data['data']['posts_per_page'] ),
	  'order' => $data['data']['order'],
	  'orderby' => $data['data']['orderby'],
	  'paged' => $current_page
	);

	$items = new WP_Query( $q_array );

	if( $items->max_num_pages < $next_page ) {
	  $response['hide_link'] = true;
	}

	if( $items->have_posts() ):
	  ob_start();
	  ?>

	  <?php $i=absint( $data['lastNumber'] ); while( $items->have_posts() ): $items->the_post(); $second_style = $i%2 == 0; ?>

	    <?php include 'view/coins_item.php'; ?>

	  <?php $i++; $response['last_num'] = $i; endwhile; ?>

	  <?php
	  $response['html'] = ob_get_clean();

	endif;

	die( json_encode( $response ) );
}