<?php

namespace StarterKit\Shortcodes\news;

add_action( 'wp_ajax_shortcode_load_news', __NAMESPACE__ . '\\load_news' );
add_action( 'wp_ajax_nopriv_shortcode_load_news', __NAMESPACE__ . '\\load_news' );

function load_news() {

	// get shortcode atts and give them to loop item template
	$shortcode_atts = json_decode( stripslashes( $_POST['shortcode_atts'] ), true );
	// make sure that they secure
	$shortcode_atts = \StarterKit\Helper\Utils::sanitize_array_text_params( $shortcode_atts );

	// get query vars from shortcode
	$query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
	// increase current page number for AJAX pagination
	$query_vars['paged'] = absint( $_POST['paged'] ) + 1;
	//
	// make sure that all settings are secure
	$query_vars = \StarterKit\Helper\Utils::sanitize_array_text_params( $query_vars );

	// query for news
	$query = Starter_Kit()->Model->News->get_news( $query_vars );

	// display news
	while ( $query->have_posts() ): $query->the_post();

		Starter_Kit()->View->load( '/view/loop_item', array(
			'atts' => $shortcode_atts
		), false, dirname( __FILE__ ) );

	endwhile;

	exit;
}
