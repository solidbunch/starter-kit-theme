<div class="alert alert-<?php echo esc_attr($data['atts']['style']); ?>" role="alert">
	<?php echo wp_kses_post($data['content']); ?>
</div>