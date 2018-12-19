<?php
/**
 * Loop item template
 * Called from shortcode and from AJAX loop
 **/

use StarterKit\Helper\Media;

$display_thumb = has_post_thumbnail() && filter_var( $data['atts']['display_thumb'], FILTER_VALIDATE_BOOLEAN );

?>
<article class="row">

	<?php if ( $display_thumb ): ?>
		<div class="col-sm-2">

			<a href="<?php the_permalink(); ?>">

				<?php if ( $data['atts']['thumbs_dimensions'] == 'crop' ): ?>

					<?php
					media::the_img( array(
						'width'  => absint( $data['atts']['thumb_width'] ),
						'height' => absint( $data['atts']['thumb_height'] ),
					), array(
						'crop' => true,
					) );
					?>

				<?php else: ?>

					<?php the_post_thumbnail( 'full' ); ?>

				<?php endif; ?>

			</a>

		</div>
	<?php endif; ?>

	<div class="<?php echo esc_attr( $display_thumb ? 'col-sm-10' : 'col-sm-12' ); ?>">

		<?php if ( filter_var( $data['atts']['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php endif; ?>

		<?php if ( filter_var( $data['atts']['display_excerpt'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<div class="excerpt">
				<?php echo wp_trim_words( get_the_excerpt(), absint( $data['atts']['excerpt_length'] ) ); ?>
			</div>
		<?php endif; ?>

	</div>

</article>

<hr>
