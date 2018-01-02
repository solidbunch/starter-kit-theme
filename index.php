<?php get_header(); ?>

<section id="content" class="container">
	<div class="row">

		<div id="posts" class="<?php echo bvc_front::get_grid_class(); ?>">

			<?php if( have_posts() ): $i=0; while ( have_posts() ) : the_post(); ?>

				<?php if( $i%3 == 0 || $i==0 ): ?>
					<div class="row">
				<?php endif; ?>

				<article <?php post_class( 'col-md-4'); ?>>
					
					<?php if( has_post_thumbnail() ): ?>
						<div class="thumb">
							<a href="<?php the_permalink(); ?>">
							<?php 
								echo bvc_media::img( array(
									'url' => get_the_post_thumbnail_url( get_the_ID(), 'full'),
									'width' => 380,
									'height' => 250,
									'lazy' => false,
									'hd' => false,
									'atts' => array( 0 => 'alt=""')
								));
							?>
							</a>
						</div>
					<?php endif; ?>

					<?php get_template_part( 'template-parts/post-data'); ?>

					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

					<div class="excerpt">
						<?php the_excerpt(); ?>
					</div>

					<a href="<?php the_permalink(); ?>" class="button"><?php esc_html_e( 'Read more', 'bvc'); ?></a>

				</article>

				<?php $i++; if( $i!=0 && $i%3 == 0 ): ?>
					</div>
				<?php endif; ?>

			<?php endwhile; else: ?>

				<div class="row">

					<article class="col-md-12">
						<h2><?php esc_html_e( 'We can not find any posts by your search criteria, sorry...', 'bvc'); ?></h2>
					</article>

				</div>

			<?php endif; wp_reset_postdata(); ?>

			<?php get_template_part( 'template-parts/pagination'); ?>

		</div>

		<?php get_sidebar(); ?>

	</div>
</section>

<?php get_footer();