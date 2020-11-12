<article <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ): ?>

		<?php

		/**

			<!-- an example how to resize image
				<img src="<?php echo Media::img_resize( get_the_post_thumbnail_url( get_the_ID(), 'full' ), 380, 250 ); ?>" >
			-->
			<!-- an example how to print image with sizes and with srcset
				<?php Media::the_img(array('width' => 380, 'height' => 250) ); ?>
			-->
			<!-- an example how to print image without sizes, but with lazy load and with srcset
				<?php Media::the_img(array('data-width' => 380, 'data-height' => 250) ); ?>
			-->
			<!--
				an example how to print image tag without srcset
				<?php Media::the_img(array('data-width' => 380, 'data-height' => 250), array('hdmi' => false) ); ?>
			-->
			<!-- an example how to print image without sizes, but with lazy load if we know only width
				<?php Media::the_img(array('data-width' => 380) ); ?>
			-->

		 */

		?>

		<div class="thumb post-thumb">
			<a href="<?php the_permalink(); ?>" class="thumb-link">
				<?php
				echo StarterKit\Helper\Media::pictureForPost(
					get_the_ID(),
					[
						'(min-width: 1200px)' => 730,
						'(min-width: 768px)'  => 690,
						545,
					]
				);
				?>
			</a>
			<a href="<?php the_permalink(); ?>" class="post-link"><i class="icon-link"></i></a>
		</div>
		<div class="clearfix"></div>
	<?php endif; ?>

	<?php get_template_part( '/template-parts/loop/post-data' ); ?>

	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

	<div class="excerpt">
		<?php the_excerpt(); ?>
	</div>

	<a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php esc_html_e( 'Read more', 'starter-kit' ); ?></a>

</article>
