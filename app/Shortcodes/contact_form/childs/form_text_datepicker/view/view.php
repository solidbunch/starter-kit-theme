<div class="form-builder-item">
	<div class="field-text">
		<input type="hidden" name="field_<?php echo esc_attr( $data['atts']['el_id'] ); ?>_f_label"
			   value="<?php echo esc_attr( $data['atts']['label'] ); ?>">
		<?php if( filter_var( $data['atts']['create_event'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<input type="hidden" name="field_<?php echo esc_attr( $data['atts']['el_id'] ); ?>_f_callback"
			   value="create_event">
		<?php endif; ?>
		<input type="text" <?php echo implode( ' ',$data['attributes'] ); ?> class="air-datepicker">
	</div>
</div>

