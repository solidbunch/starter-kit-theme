<?php 
if (!empty($data_post->post_content)) {
	echo do_shortcode($data_post->post_content);
}

