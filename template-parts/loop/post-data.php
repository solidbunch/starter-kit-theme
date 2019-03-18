<div class="post-data">
	<div class="data-author">
		<?php _e( 'By', 'starter-kit'); ?> <?php the_author_link(); ?>
	</div>
	<div class="data-date">
	<?php _e( 'Posted on', 'starter-kit'); ?> <?php the_time( 'j. F Y' ); ?>
	</div>
	<div class="data-comments">
		<a href="<?php echo get_comments_link(); ?>">
			<?php comments_number( __( '0 comments', 'starter-kit'), __( '1 comment', 'starter-kit'), __( '% comments', 'starter-kit') ); ?>
		</a>
	</div>
	<?php if( get_post_type() == 'post' ): ?>
		<div class="data-categories">
			<?php _e( 'In', 'starter-kit'); ?>: <?php echo get_the_category_list( ', '); ?>
		</div>
		<div class="data-tags">
			<?php echo get_the_tag_list( __( 'Tags: ', 'starter-kit'), ', ', '' ); ?>
		</div>
	<?php endif; ?>
</div>
