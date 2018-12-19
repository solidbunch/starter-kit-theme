<?php

/**
 * Heading shortcode
 *
 **/

$atts    = $data['atts'];
$content = isset( $data['content'] ) ? $data['content'] : '';

?>
<<?php echo esc_attr( $atts['heading'] ); ?> id="<?php echo esc_attr( $data['id'] ); ?>" class="<?php echo esc_attr( $atts['classes'] ); ?>">
<?php echo wp_kses_post( $atts['title'] ); ?>
</<?php echo esc_attr( $atts['heading'] ); ?>>
