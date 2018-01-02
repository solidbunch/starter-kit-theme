<div class="post-data">
	<span class="date">
		<?php the_time( 'F d, Y' ); ?>
	</span> <span class="separator">|</span> 
	<span class="author">
		<?php esc_html_e( 'By', 'bvc'); ?> <?php the_author_link(); ?>
	</span>
	<?php if( is_single() ): ?>
		<span class="separator">|</span> <span class="comments">
			<?php comments_number( '0', '1', '%' ); ?>
		</span>
		<div class="share-post">
			<div class="share-title"><i class="fa fa-share-alt"></i> <?php esc_html_e( 'Share', 'bvc'); ?></div>
			<div class="share-links">
				<?php
					/**
						Share post to social networks
					**/
					$title = urlencode( get_the_title( get_the_ID() ) );
					$permalink = urlencode( get_permalink( get_the_ID() ) );
					$post_thumb = has_post_thumbnail() ? urlencode( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ) : '';
				?>
				<a href="https://www.facebook.com/sharer/sharer.php?display=popup&amp;u=<?php echo esc_attr( $permalink ); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
				<a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr( $title ); ?>&amp;url=<?php echo esc_attr( $permalink ); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
				<a href="https://plus.google.com/share?url=<?php echo esc_attr( $permalink ); ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
			</div>
		</div>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>