<?php

use ffblank\helper\front;
use ffblank\helper\media;

get_header(); ?>
	
	<section id="content" class="container pt-5">

		<div class="row">
			
			<div id="posts" class="<?php echo front::get_grid_class(); ?>">

				<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<article <?php post_class( array( 'col-sm-12' ) ); ?>>

						<div class="row pb-5">

							<div class="thumb pb-3 col-md-<?php echo is_sticky() ? '12' : '3'; ?>">

								<a href="<?php the_permalink(); ?>">

										<!-- an example how to resize image
											<img src="<?php echo media::img_resize( get_the_post_thumbnail_url( get_the_ID(), 'full' ), 380, 250 ); ?>" >
										-->

										<!--
											an example how to print image tag with srcset
										-->

										<?php

										if ( is_sticky() ) {
											echo has_post_thumbnail() ? media::img(array('width'  => 700, 'height' => 350, 'upscale' => true)) : media::img(array('url' => 'https://dummyimage.com/700x350/eee/aaaaaa', 'width'  => 700, 'height' => 350, 'upscale' => true));
										} else {
											echo has_post_thumbnail() ? media::img(array('width'  => 150, 'height' => 150, 'upscale' => true)) : media::img(array('url' => 'https://dummyimage.com/150x150/eee/aaaaaa', 'width'  => 150, 'height' => 150, 'upscale' => true));
										}

										?>


								</a>

							</div>

							<div class="col-md-<?php echo is_sticky() ? '12' : '9'; ?>">

								<h2 class="pb-3">

									<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">

										<?php the_title(); ?>

									</a>

								</h2>

								<?php get_template_part( 'template-parts/post-data' ); ?>

								<div class="excerpt">
									<?php the_excerpt(); ?>
								</div>

								<a href="<?php the_permalink(); ?>" class="btn btn-primary col-sm-12 col-md-3">
									<?php esc_html_e( 'Read more', 'fruitfulblanktextdomain' ); ?>
								</a>

							</div>

						</div>
					
					</article>

				</div>
				
				<?php endwhile; else: ?>
					
					<div class="row">
						
						<article class="col-md-12">
							<h2><?php esc_html_e( 'We can not find any posts by your search criteria, sorry...', 'fruitfulblanktextdomain' ); ?></h2>
						</article>
					
					</div>
				
				<?php endif;
				wp_reset_postdata(); ?>
				
				<?php get_template_part( 'template-parts/pagination' ); ?>
			
			</div>
			
			<?php get_sidebar(); ?>
		
		</div>

	</section>

<?php get_footer();