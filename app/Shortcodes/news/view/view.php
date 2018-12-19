<?php

$atts   = array();
$atts[] = 'id = "' . $data['id'] . '"';
$atts[] = 'class = "shortcode-news"';
?>

<div <?php echo implode( ' ', $atts ); ?>>
	<?php if ( $data['query']->have_posts() ): ?>

		<div class="row news">
			<div class="col-md-12">
				<h5 class="row-header"><?php echo $data['atts']['title']; ?></h5>
			</div>

			<?php while ( $data['query']->have_posts() ): $data['query']->the_post(); ?>
				<?php require 'loop_item.php'; ?>
			<?php endwhile; ?>
		</div>

		<?php wp_reset_postdata(); ?>

	<?php else: ?>
		<p><?php _e( 'No news found', 'starter-kit' ); ?></p>
	<?php endif; ?>
</div>
