<?php
	if( $items->have_posts() ):
		$max_num_pages = $items->max_num_pages;
?>
<div id="<?php echo esc_attr( $id ); ?>" class="shortcode-coins">

	<div id="container-<?php echo $atts['el_id']; ?>" class="grid">
	<?php $i=0; while( $items->have_posts() ): $items->the_post(); $second_style = $i%2 == 0; ?>

		<?php include 'coins_item.php'; ?>

	<?php $i++; endwhile; ?> 
	</div>

	<?php
		if( $max_num_pages > 1 && filter_var( $atts['load_more'], FILTER_VALIDATE_BOOLEAN ) ):

	?>
		<div class="ajax-pagination">
			<a
				href="javascript:;"
				data-target-id="#container-<?php echo $atts['el_id']; ?>" 
				data-next-page="2" 
				data-last-number="<?php echo $i; ?>" 
				data-max-pages="<?php echo esc_attr( $max_num_pages ); ?>" 
				data-action="fruitfulblankprefix_load_testimonials" 
				data-data="<?php echo htmlspecialchars( json_encode( $q_array ), ENT_QUOTES, 'UTF-8' ); ?>"
				class="button load-more-posts">
					<?php echo wp_kses_post( $atts['load_more_text'] ); ?>
			</a>
		</div>
	<?php endif; ?>

</div>
<?php wp_reset_postdata(); endif;