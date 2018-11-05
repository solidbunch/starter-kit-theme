<?php 

$atts   = array();
$atts[] = 'id="' . $data['id'] . '"';
$atts[] = 'class="shortcode-form"';

?>
<div class="shortcode-contact-form form-wrapper contact-form <?php echo implode(' ', $data['classes']); ?>">
	<form action="" method="POST"  <?php echo implode(' ', $data['attributes']); ?> class="fw_form_fw_form" <?php echo implode(' ', $atts); ?>>
		<?php echo wpb_js_remove_wpautop($data['content']); ?>		
	</form>
</div>

