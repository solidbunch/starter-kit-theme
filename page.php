<?php
/**
 * The page template file
 */

use ttt\helper\front;

get_header();
the_post(); ?>
	
	<div id="content" class="container">

		<div class="row">
			<div class="col-sm-12">

				<div class="row article">
					
					<article class="<?php echo front::get_grid_class(0); ?>">
						
						<h1><?php the_title(); ?></h1>
						
						<?php the_content(); ?>

					</article>
					
					<?php get_sidebar(); ?>
				
				</div>

			</div>
		</div>

	</div>

<?php get_footer();