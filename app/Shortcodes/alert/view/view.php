<?php
/**
 * @array $atts shortcode attributes
 * @mixed $content
 **/
?>

<?php
// remove empty <p> tags from shortcode alert text
function remove_empty_p( $content ) {
	$content = force_balance_tags( $content );
	$content = preg_replace( '#<p>\s*+\s*</p>#i', '', $content );

	return $content;
}
?>

<!-- shortcode-alert -->
<div id="<?php echo esc_attr( $data['atts']['el_id'] ); ?>"
	 class="shortcode-alert alert alert-<?php echo esc_attr( trim( $data['atts']['style'] . ' ' . $data['atts']['classes'] ) ); ?>"
	 role="alert">
	<?php if ( ! empty( $data['atts']['icon'] ) ) : ?>

	<!-- shortcode-alert-icon -->
	<span class="shortcode-alert-icon">
		<i class="<?php echo esc_attr( $data['atts']['icon'] ); ?>"></i>
	</span>
	<!-- end of shortcode-alert-icon -->

	<?php endif; ?>

	<!-- shortcode-alert-text -->
	<div class="shortcode-alert-text">
		<?php echo wp_kses_post( remove_empty_p( $data['content'] ) ); ?>
	</div>
	<!-- end of shortcode-alert-text -->
</div>
<!-- end of shortcode-alert -->
