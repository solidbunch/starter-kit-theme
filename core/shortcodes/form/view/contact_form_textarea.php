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
	<div class="field-textarea">

		<input type="hidden" name="field_<?php echo esc_attr($atts['el_id']); ?>_f_label"
			   value="<?php echo esc_attr($atts['label']); ?>"/>

		<textarea <?php echo implode(' ', $attributes); ?>></textarea>

	</div>
</div>
