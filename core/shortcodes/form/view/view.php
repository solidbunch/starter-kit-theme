<?php 

$atts   = array();
$atts[] = 'id="' . $data['id'] . '"';
$atts[] = 'class="shortcode-posts"';

?>
<div class="shortcode-contact-form form-wrapper contact-form <?php echo implode(' ', $data['classes']); ?>">
	<form action="" method="POST"  <?php echo implode(' ', $data['attributes']); ?> class="fw_form_fw_form" <?php echo implode(' ', $atts); ?>>
		<?php echo wpb_js_remove_wpautop($data['content']); ?>
		<div class="vc_row wpb_row vc_inner vc_row-fluid">
			<input type="text" name="y_name" class="y_name required" value="" style="display:none;"/>
		</div>
	</form>
</div>

