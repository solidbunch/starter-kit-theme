<?php 
vc_add_shortcode_param( 'my_param', 'my_param_settings_field', \ffblank\helper\utils::get_param_uri( basename( dirname( __FILE__ ) ) ) . 'assets/js/index.js' );

function my_param_settings_field( $settings, $value ) {	

	$param_dir = dirname( __FILE__ );		

	/** Shortcode data to output **/
	$data = array(
		'settings' => $settings,
		'value' => $value,				
	);

	return FFBLANK()->view->load( '/view/view', $data, true, $param_dir );
}
	
?>