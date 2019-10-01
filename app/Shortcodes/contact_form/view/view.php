<?php
/**
 * @string $id shortcode ID
 * @array $atts shortcode attributes
 * @mixed $content
 * @array $attributes shortcode form attributes
 **/
?>

<!-- shortcode-form -->
<div id="<?php echo esc_attr( $data['id'] ); ?>"
	 class="shortcode-form <?php echo esc_attr( $data['atts']['classes'] ); ?>">
	<!-- shortcode-form-form -->
	<form action=""
		  method="POST"
		  <?php echo implode( ' ', $data['attributes'] ); ?>
		  class="shortcode-form-form"
		  id="<?php echo esc_attr( $data['id'] ); ?>-form">
		<?php echo $this->js_remove_wpautop( $data['content'] ); ?>
	</form>
	<!-- end of shortcode-form-form -->
</div>
<!-- end of shortcode-form -->
