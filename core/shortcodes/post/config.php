<?php
$args = array(
	'numberposts' => -1,
	'post_type'   => 'forms',
);
$forms_posts = get_posts(
				array(
					'numberposts' => -1,
					'post_type'   => 'forms',
				)
			);
$forms = array();
foreach ($forms_posts as $forms_post) {
	$forms[$forms_post->post_title] = $forms_post->ID;
}

vc_map( array(
	'name' => esc_html__( 'Form content', 'fruitfulblanktextdomain' ),
	'base' => 'fruitfulblankprefix_form_content',
	'icon' => '',
	'category' => esc_html__( 'Theme Elements', 'fruitfulblanktextdomain' ),
	'description' => esc_html__( 'Add post with type Form', 'fruitfulblanktextdomain' ),
	'params' => array(

		/**
		 *  Header attributes tab
		**/
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Select Form', 'fruitfulblanktextdomain'),
			'param_name' => 'form',
			'holder'		=> 'h2',
			'save_always' => true,
			'value' => $forms,
			'group' => esc_html__('Header Attributes', 'fruitfulblanktextdomain'),
		),





	)
));
