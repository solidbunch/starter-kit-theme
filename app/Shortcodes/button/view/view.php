<?php
/**
 * @string $id shortcode ID
 * @array $atts shortcode attributes
 * @mixed $content
 **/

$atts = $data['atts'];

$css_class = '';;

if ( isset( $atts['button_style'] ) && $atts['button_style'] <> '' ) {
	if ( isset( $atts['outline'] ) && filter_var( $atts['outline'], FILTER_VALIDATE_BOOLEAN ) ) {
		$css_class .= ' btn-outline-' . $atts['button_style'];
	} else {
		$css_class .= ' btn-' . $atts['button_style'];
	}
} else {
	$css_class .= ' btn-primary';
}

if ( isset( $atts['button_size'] ) && $atts['button_size'] <> '' ) {
	$css_class .= ' ' . $atts['button_size'];
}

?>

<?php if ( $atts['button_align'] <> '' ): ?>

<!-- shortcode-button -->
<div class="shortcode-button shortcode-button__<?php echo esc_attr( $atts['button_align'] ); ?>">

<?php endif; ?>

	<!-- shortcode-button-item -->
	<a id="<?php echo esc_attr( $data['id'] ); ?>"
	   href="<?php echo esc_attr( $atts['link'] ); ?>"
	   class="shortcode-button-item btn <?php echo esc_attr( trim( $css_class . ' ' . $atts['classes'] ) ); ?>">
		
		<!-- shortcode-button-item-text -->
		<span class="shortcode-button-item-text">
			<?php echo wp_kses_post( $atts['title'] ); ?>
		</span>
		<!-- end of shortcode-button-item-text -->
		
		<?php if ( $atts['icon'] <> '' ): ?>

		<!-- shortcode-button-item-icon -->
		<span class="shortcode-button-item-icon">
			<i class="<?php echo esc_attr( $atts['icon'] ); ?>"></i>
		</span>
		<!-- end of shortcode-button-item-icon -->

		<?php endif; ?>
	
	</a>
	<!-- end of shortcode-button-item -->

<?php if ( $atts['button_align'] <> '' ): ?>

</div>
<!-- end of shortcode-button -->

<?php endif;
