<?php 
/**
 @array $data shortcode output data from controller
**/

	if( !empty($data['button_style'])) {
		$data['css_class'] .= ' style-' . $data['button_style'];
	}

?>
<?php if( $data['button_align'] <> '' ): ?>
<div class="align-<?php echo esc_attr( $data['button_align'] ); ?>">
<?php endif; ?>
<a href="<?php echo esc_attr( $data['link'] ); ?>" id="<?php echo esc_attr( $data['id'] ); ?>" class="button <?php echo esc_attr( $data['css_class'] ); ?>">
	<?php echo wp_kses_post( $data['title'] ); ?> 
	<?php if( $data['icon'] <> '' ): ?>
	<i class="<?php echo esc_attr( $data['icon'] ); ?>"></i>
	<?php endif; ?>
</a>
<?php if( $data['button_align'] <> '' ): ?>
</div>
<?php endif; ?>