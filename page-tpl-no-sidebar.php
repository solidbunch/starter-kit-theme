<?php
/**
 * Template name: No Sidebar
 */

get_header();
the_post(); ?>
	
	<div class="container pt-5">
		<div class="row">
			
			<div class="col-12">
				<?php the_content(); ?>
			</div>
		
		</div>
	</div>

<?php get_footer();