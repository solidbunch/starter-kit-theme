<?php 
	/**
	 @string $id shortcode ID
	 @array $atts shortcode attributes
	 @mixed $content
	**/

	$css = '';

	extract(shortcode_atts(array(
		'css' => ''
	), $atts));

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
	$css_class .= ' ' . $atts['classes'];

	if( isset( $atts['button_style'] ) && $atts['button_style'] <> '' ) {
		$css_class .= 'style-' . $atts['button_style'];
	}

?>
<?php if( $atts['button_align'] <> '' ): ?>
<div class="align-<?php echo esc_attr( $atts['button_align'] ); ?>">
<?php endif; ?>
<a href="<?php echo esc_attr( $atts['link'] ); ?>" id="<?php echo esc_attr( $id ); ?>" class="button <?php echo esc_attr( $css_class ); ?>">
	<?php echo wp_kses_post( $atts['title'] ); ?> 
	<?php if( $atts['icon'] <> '' ): ?>
	<i class="<?php echo esc_attr( $atts['icon'] ); ?>"></i>
	<?php endif; ?>
</a>
<?php if( $atts['button_align'] <> '' ): ?>
</div>
<?php endif; ?>