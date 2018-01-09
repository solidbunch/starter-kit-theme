<?php 
/**
 @array $data shortcode output data from controller
**/

?>
<<?php echo esc_attr( $data['heading'] ); ?> id="<?php echo esc_attr( $data['id'] ); ?>" class="<?php echo esc_attr( $data['css_class'] ); ?>">
	<?php echo wp_kses_post( $data['title'] ); ?>
</<?php echo esc_attr( $data['heading'] ); ?>>