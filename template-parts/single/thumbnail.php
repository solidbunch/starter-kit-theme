<?php if ( has_post_thumbnail() ): ?>
	<div class="thumb">
		<img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>" alt="<?php echo esc_attr( get_the_title()); ?>">
	</div>
<?php endif;
