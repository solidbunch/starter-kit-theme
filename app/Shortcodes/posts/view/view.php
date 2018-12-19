<?php

$atts   = array();
$atts[] = 'id = "' . $data['id'] . '"';
$atts[] = 'class = "shortcode-posts"';

?>

<div <?php echo implode( ' ', $atts ); ?>>

	<?php if ( $data['query']->have_posts() ): ?>

		<div class="posts">

			<?php while ( $data['query']->have_posts() ): $data['query']->the_post(); ?>

				<?php require 'loop_item.php'; ?>

			<?php endwhile; ?>

		</div>

		<?php if ( filter_var( $data['atts']['pagination'],
				FILTER_VALIDATE_BOOLEAN ) && $data['query']->max_num_pages > 1 ): ?>

			<div class="posts-pagination text-center">
				<a href="javascript:;"
				   class="shortcode-posts-loadmore btn btn-primary"><?php echo wp_kses_post( $data['atts']['ajax_load_more_button_text'] ); ?></a>
			</div>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	<?php else: ?>

		<p><?php _e( 'No posts found', 'starter-kit' ); ?></p>

	<?php endif; ?>

</div>
