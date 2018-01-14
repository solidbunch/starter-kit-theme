<?php 
/**
 @array $data shortcode output data from controller
**/

if (!empty($data['data_post']->post_content)) {
	echo do_shortcode($data['data_post']->post_content);
}

