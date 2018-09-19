<?php

use ttt\helper\front;
use ttt\helper\media;

$titleMaxLength = 25;
$postsPerPage   = 10;

get_header(); ?>
	
	<section id="content" class="container">

		<div class="row">
			
			<div id="posts" class="<?php echo front::get_grid_class(); ?>">

				<div class="row">

                <?php

                    $args = array(
                        'posts_per_page' => $postsPerPage
                    );

                    $query = new WP_Query($args);

				?>

				<?php if ( $query->have_posts() ): while ( $query->have_posts() ) : $query->the_post(); ?>

					<article <?php post_class( is_sticky() ? array( 'col-sm-12' ) : array( 'col-sm-6' ) ); ?>>
						
						<h2>

							<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">

								<?php

									if ( strlen( get_the_title() ) > $titleMaxLength ) {
									    echo esc_html__(substr( get_the_title(), 0, $titleMaxLength ) . '...');
									} else {
                                        echo esc_html__( get_the_title() );
                                    }

								?>

							</a>

						</h2>
						
						<div class="thumb">

							<a href="<?php the_permalink(); ?>">
						
									<!-- an example how to resize image
									<img src="<?php echo media::img_resize( get_the_post_thumbnail_url( get_the_ID(), 'full' ), 380, 250 ); ?>" >
								-->
									
									<!--
										an example how to print image tag with srcset
									-->
								
									<?php echo has_post_thumbnail() ? media::img(array('width'  => 350, 'height' => 175, 'upscale' => true)) : media::img(array('url' => 'https://dummyimage.com/350x175/eee/aaaaaa')); ?>


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