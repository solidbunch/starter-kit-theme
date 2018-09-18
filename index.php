<?php

use ttt\helper\front;
use ttt\helper\media;

get_header(); ?>
	
	<section id="content" class="container">
		<div class="row">
			
			<div id="posts" class="<?php echo front::get_grid_class(); ?>">

				<div class="row">
				
				<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>
					
					<article <?php post_class( array( 'col-sm-6' ) ); ?>>
						
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						
						<div class="thumb">
							<a href="<?php the_permalink(); ?>">
						
									<!-- an example how to resize image
									<img src="<?php echo media::img_resize( get_the_post_thumbnail_url( get_the_ID(), 'full' ), 380, 250 ); ?>" >
								-->
									
									<!--
										an example how to print image tag with srcset
									-->
								
									<?php echo has_post_thumbnail() ? media::img() : media::img(array('url' => 'https://dummyimage.com/350x175/eee/aaaaaa')); ?>


							</a>
						</div>
						
						<?php get_template_part( 'template-parts/post-data' ); ?>
						
						<div class="excerpt">
							<?php the_excerpt(); ?>
						</div>
						
						<a href="<?php the_permalink(); ?>"
						   class="button"><?php esc_html_e( 'Read more', 'tttextdomain' ); ?></a>
					
					</article>
				
				<?php endwhile; else: ?>
					
					<div class="row">
						
						<article class="col-md-12">
							<h2><?php esc_html_e( 'We can not find any posts by your search criteria, sorry...', 'tttextdomain' ); ?></h2>
						</article>
					
					</div>
				
				<?php endif;
				wp_reset_postdata(); ?>

				</div>
				
				<?php get_template_part( 'template-parts/pagination' ); ?>
			
			</div>
			
			<?php get_sidebar(); ?>
		
		</div>
	</section>

<?php get_footer();