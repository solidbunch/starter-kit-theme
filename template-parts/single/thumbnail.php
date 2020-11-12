<?php use StarterKit\Helper\Media;

if ( has_post_thumbnail() ): ?>
	<div class="thumb">
		<?php echo Media::pictureForPost(
			get_the_ID(),
			[
				'(min-width: 1200px)' => 730,
				'(min-width: 768px)'  => 690,
				545,
			]
		); ?>
	</div>
<?php endif;
