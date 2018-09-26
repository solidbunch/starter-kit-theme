<?php

/**
 * @array $data shortcode output data from controller
 **/

$atts    = $data['atts'];
$content = isset( $data['content'] ) ? $data['content'] : '';

$css = '';

extract( shortcode_atts( array(
	'css' => ''
), $atts ) );

$css_class = $this->get_css_class( $css, $data );

?>
<<?php echo esc_attr( $atts['heading'] ); ?> id="<?php echo esc_attr( $data['id'] ); ?>" class="<?php echo esc_attr( $css_class ); ?>">
<?php echo wp_kses_post( $atts['title'] ); ?>
</<?php echo esc_attr( $atts['heading'] ); ?>>
