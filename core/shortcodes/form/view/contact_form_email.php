
<div class="form-builder-item">
	<div class="field-email">
		<input type="hidden" name="field_<?php echo esc_attr( $data['atts']['el_id'] ); ?>_f_label"
			   value="<?php echo esc_attr( $data['atts']['label'] ); ?>"/>
		<input type="email" <?php echo implode( ' ', $data['attributes'] ); ?> />

	</div>
</div>
