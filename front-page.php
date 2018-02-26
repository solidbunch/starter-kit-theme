<?php
/**
 * The front page template file
 */

get_header(); ?>
<?php the_post(); 
	the_content();?>
<?php get_footer();
