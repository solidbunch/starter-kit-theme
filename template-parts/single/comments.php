<?php if ( ! post_password_required() ): ?>
	<div id="comments-block">
		<?php comments_template( '', true ); ?>
	</div>
<?php endif; ?>
