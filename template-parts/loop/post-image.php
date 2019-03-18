<?php
	$content = get_the_content();
?>
<article <?php post_class(); ?>>

	<?php if ( ! has_post_thumbnail() ): ?>
		<div class="thumb">
			<a href="<?php the_permalink(); ?>">
				<?php
					if( has_shortcode( $content, 'caption' ) ):
						preg_match_all('/src="([^"]*)"/', $content, $matches);
						if( isset( $matches[1][0] )):
							echo '<img src="' . $matches[1][0] . '" alt="' . esc_attr( get_the_title() ) . '">';
						endif;
					else:
						echo strip_tags( $content, '<img>' );
					endif;
				?>
			</a>
		</div>
	<?php else: ?>
		<div class="thumb">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'full'); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php get_template_part( '/template-parts/loop/post-data' ); ?>

	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

</article>
