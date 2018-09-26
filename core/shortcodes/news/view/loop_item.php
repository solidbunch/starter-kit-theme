<?php
/**
 * Loop item template
 * Called from shortcode and from AJAX loop
 **/

use ffblank\helper\media;

$display_thumb = filter_var( $data['atts']['display_thumb'], FILTER_VALIDATE_BOOLEAN );

?>

<div class="col-xs-12 col-md-2 col-sm-4">

	<a href="<?php the_permalink(); ?>">

		<?php if ( filter_var( $data['atts']['display_thumb'], FILTER_VALIDATE_BOOLEAN ) ): ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( array( 200 ) ); ?>
			<?php else : ?>
				<?php echo media::img( array( 'url' => 'https://dummyimage.com/200x135/eee/aaa' ) ); ?>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ( filter_var( $data['atts']['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<h5><?php the_title(); ?></h5>
		<?php endif; ?>

	</a>

</div>
