<div class="form-builder-item">
	<div class="field-file-uploader">
        <span class="file-uploader_icon"><i class="fa fa-file-o" aria-hidden="true"></i></span>
        <input type="hidden" name="field_<?php echo esc_attr( $data['atts']['el_id'] ); ?>_f_label"
			   value="<?php echo esc_attr( $data['atts']['label'] ); ?>"/>
        <label class="file_uploader"
               id="label_<?php echo esc_attr( $data['atts']['el_id'] )?>"
               for="field_<?php echo esc_attr( $data['atts']['el_id'] )?>"
               plac="<?php echo esc_html__( 'File name: ', 'starter-kit' );?>"><?php echo esc_attr( $data['atts']['placeholder'] );?></label>
		<input type="file" class="hidden" <?php echo implode( ' ', $data['attributes'] ); ?> />
	</div>
</div>
