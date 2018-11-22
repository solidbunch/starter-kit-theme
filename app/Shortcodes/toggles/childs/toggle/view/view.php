<?php
global $_theme_toggle_shortcode_count;
$_theme_toggle_shortcode_count ++;

$is_open = filter_var( $data['atts']['open'], FILTER_VALIDATE_BOOLEAN );
?>
<div class="card">
	<div class="card-header" id="toggle-<?php echo esc_attr( $_theme_toggle_shortcode_count ); ?>">
		<h5 class="mb-0">
			<button class="btn btn-link <?php if ( ! $is_open ): ?>collapsed<?php endif; ?>" data-toggle="collapse"
			        data-target="#toggle-collapse-<?php echo esc_attr( $_theme_toggle_shortcode_count ); ?>"
			        aria-expanded="false"
			        aria-controls="toggle-collapse-<?php echo esc_attr( $_theme_toggle_shortcode_count ); ?>">
				<?php echo wp_kses_post( $data['atts']['title'] ); ?>
			</button>
		</h5>
	</div>

	<div id="toggle-collapse-<?php echo esc_attr( $_theme_toggle_shortcode_count ); ?>"
	     class="collapse <?php if ( $is_open ): ?>show<?php endif; ?>"
	     aria-labelledby="toggle-<?php echo esc_attr( $_theme_toggle_shortcode_count ); ?>"
	     data-parent="#toggle-<?php echo esc_attr( $_theme_toggle_shortcode_count ); ?>">
		<div class="card-body">
			<?php echo wp_kses_post( $data['content'] ); ?>
		</div>
	</div>
</div>
