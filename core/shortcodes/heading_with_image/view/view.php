<?php 
	/**
	 @string $id shortcode ID
	 @array $atts shortcode attributes
	 @mixed $content
	**/

	$css = '';
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
	$css_class .= ' ' . $atts['classes'];
?>
<<?php echo esc_attr( $atts['heading'] ); ?> id="<?php echo esc_attr( $id ); ?>" class="shortcode-title-with-image <?php echo esc_attr( $css_class ); ?>">
	<?php if (!empty($atts['image_url'])) {?>
	<span class="title-image">
		<img src="<?php echo $atts['image_url']; ?>" alt=""/>
	</span>
	<?php } ?>
	<?php echo wp_kses_post( $atts['title'] ); ?>
</<?php echo esc_attr( $atts['heading'] ); ?>>