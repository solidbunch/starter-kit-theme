<?php 

$atts   = array();
$atts[] = 'id="' . $data['id'] . '"';
$atts[] = 'class = "shortcode-form"';


?>
<div class="contact-form form-wrapper contact-form <?php echo implode(' ', $data['atts']['classes']); ?>">
	<form action="" method="POST"  <?php echo implode(' ', $data['attributes']); ?> class="fw_form_fw_form" <?php echo implode(' ', $atts); ?>>
		<?php echo $this->js_remove_wpautop($data['content']); ?>
	</form>
</div>

