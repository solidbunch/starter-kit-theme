<div class="form-builder-item">
	<div class="field-text">

		<input type="hidden" name="field_<?php echo esc_attr($atts['el_id']); ?>_f_label"
			   value="<?php echo esc_attr($atts['label']); ?>"/>

		<input type="checkbox" <?php echo implode(' ', $attributes); ?> />
		<?php if (!empty($atts['label'])) {?>
			<label for="field_<?php echo esc_attr($atts['el_id']); ?>">
				<?php echo esc_attr($atts['label']); ?>
			<label>
		<?php } ?>
	</div>
</div>
