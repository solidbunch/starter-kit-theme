<?php
/**
 * Loop item template
 *
 * Called from shortcode and from AJAX loop
 **/

use StarterKit\Helper\Media;

$display_thumb = filter_var( $data['atts']['display_thumb'], FILTER_VALIDATE_BOOLEAN );

?>

<div class="col-xs-12 col-md-2 col-sm-4">

	<a href="<?php the_permalink(); ?>">

		<?php if ( filter_var( $data['atts']['display_thumb'], FILTER_VALIDATE_BOOLEAN ) ): ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( array( 100 ) ); ?>
			<?php else : ?>
				<?php media::the_img( array( 'src' => 'https://dummyimage.com/100x100/eee/aaa', 'data-width' => 100, 'data-height' => 100) ); ?>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ( filter_var( $data['atts']['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<h5><?php the_title(); ?></h5>
		<?php endif; ?>

	</a>

</div>
