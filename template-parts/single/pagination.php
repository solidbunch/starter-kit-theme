<?php
	wp_link_pages( [
		'before'      => '<div class="page-links">' . __( 'Pages:', 'starter-kit' ),
		'after'       => '</div>',
		'link_before' => '<span class="page-number">',
		'link_after'  => '</span>',
	]);
?>
