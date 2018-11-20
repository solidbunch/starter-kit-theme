<?php

use StarterKit\Helper\Front;
use StarterKit\Helper\Media;

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
										<!-- an example how to print image with sizes and with srcset
											<?php media::the_img(array('width' => 380, 'height' => 250) ); ?>
										-->
										<!-- an example how to print image without sizes, but with lazy load and with srcset
											<?php media::the_img(array('data-width' => 380, 'data-height' => 250) ); ?>
										-->


										<!--
											an example how to print image tag without srcset
											<?php media::the_img(array('data-width' => 380, 'data-height' => 250), array('hdmi' => false) ); ?>
										-->

										<?php

											$width      = is_sticky() ? '700' : '150';
											$height     = is_sticky() ? '350' : '150';

											$args   = array(
												'width'     => $width,
												'height'    => $height,
											);

											$func_args   = array(
												'upscale'     => true,
											);

											if ( !has_post_thumbnail() ) {
												$args['src'] = 'https://dummyimage.com/' . $width . 'x' . $height . '/eee/aaaaaa';
											}

											echo media::the_img($args, $func_args);

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
									<?php esc_html_e( 'Read more', 'starter-kit' ); ?>
								</a>

							</div>

						</div>
					
					</article>

				</div>
				
				<?php endwhile; else: ?>
					
					<div class="row">
						
						<article class="col-md-12">
							<h2><?php esc_html_e( 'We can not find any posts by your search criteria, sorry...', 'starter-kit' ); ?></h2>
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