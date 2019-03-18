<div class="post-data">
	<div class="data-author">
		<?php esc_html_e( 'By', 'starter-kit' ); ?> <?php the_author_link(); ?>
	</div>
	<div class="data-date">
	<?php esc_html_e( 'Posted on', 'starter-kit' ); ?> <?php the_time( get_option( 'date_format') ); ?>
	</div>
</div>
