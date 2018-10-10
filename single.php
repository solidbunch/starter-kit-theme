<?php

use ffblank\helper\front;
use ffblank\helper\media;

get_header();
the_post(); ?>
	
	<section id="content" class="container pt-5">
		
		<div class="row">

			<div id="posts" class="<?php echo front::get_grid_class(); ?>">

				<div class="row">

					<article <?php post_class('col-md-12'); ?>>
						
						<h1><?php the_title(); ?></h1>
						
						<?php get_template_part( 'template-parts/post-data' ); ?>
						
						<?php if ( has_post_thumbnail() ): ?>
							<div class="thumb">
								<a href="<?php the_permalink(); ?>">
									<?php
										media::the_img( array('width' => 800, 'height' => 400), array( 'crop' => true) );
									?>
								</a>
							</div>
						<?php endif; ?>
						
						<?php
							the_content();
						
							wp_link_pages( array(
								'before'      => '<div class="page-links">' . __( 'Pages:', 'fruitfulblanktextdomain' ),
								'after'       => '</div>',
								'link_before' => '<span class="page-number">',
								'link_after'  => '</span>',
							) );
						?>
						
						<div class="clearfix"></div>
						
						<?php get_template_part( 'template-parts/related-posts' ); ?>
						
						<!--
							Comments
						-->
						
						<?php if ( ! post_password_required() ): ?>
							<div id="comments-block">
								<?php comments_template( '', true ); ?>
							</div>
						<?php endif; ?>
					
					</article>
					

				</div>

			</div>
			
			<?php get_sidebar(); ?>
		
		</div>
	</section>

<?php get_footer();
