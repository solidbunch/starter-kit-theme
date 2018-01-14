<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);

$attributes = array();
$attributes[] = 'id="field_' . esc_attr($atts['el_id']) . '"';
$attributes[] = 'name="field_' . esc_attr($atts['el_id']) . '"';
$attributes[] = 'placeholder="' . esc_attr($atts['placeholder']) . '"';

if (filter_var($atts['required'], FILTER_VALIDATE_BOOLEAN)) {
	$attributes[] = 'required="required"';
}

?>
<div class="form-builder-item">
	<div class="field-text">

		<input type="hidden" name="field_<?php echo esc_attr($atts['el_id']); ?>_f_label"
			   value="<?php echo esc_attr($atts['label']); ?>">

		<?php if( filter_var( $atts['create_event'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<input type="hidden" name="field_<?php echo esc_attr($atts['el_id']); ?>_f_callback"
			   value="create_event">
		<?php endif; ?>

		<input type="text" <?php echo implode(' ', $attributes); ?> class="air-datepicker">

	</div>
</div>
