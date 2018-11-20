<div class="form-builder-item">
	<div class="field-textarea">
		<input type="hidden" name="field_<?php echo esc_attr( $data['atts']['el_id'] ); ?>_f_label"
			   value="<?php echo esc_attr( $data['atts']['label'] ); ?>"/>
		<textarea <?php echo implode( ' ', $data['attributes'] ); ?>></textarea>
	</div>
</div>
