<div class="form-builder-item">
	<div class="field-text">	
		<input type="hidden" name="field_<?php echo esc_attr( $data['atts']['el_id'] ); ?>_f_label"
			   value="<?php echo esc_attr( $data['atts']['label'] ); ?>"/>
		<input type="checkbox" <?php echo implode( ' ', $data['attributes'] ); ?> />
		<?php if ( !empty($data['atts']['label']) ) {?>
			<label for="field_<?php echo esc_attr($data['atts']['el_id']); ?>">
				<?php echo esc_attr($data['atts']['label']); ?>
			<label>
		<?php } ?>
	</div>
</div>
