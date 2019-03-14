<div class="file-picker-fields">
	<input
			value="<?php echo esc_attr( $data['value'] ); ?>"
			type="text"
			name="<?php echo esc_attr( $data['settings']['param_name'] ); ?>"
			class="wpb_vc_param_value jsc-input-file-picker-input <?php echo esc_attr( $data['settings']['param_name'] . ' ' . $data['settings']['type'] ); ?>_field"
			readonly="readonly"
			placeholder="<?php _e( 'Click on the button to choose a file...', 'starter-kit' ); ?>"
	>
	
	<button
			type="button"
			class="vc_btn vc_btn-green jsc-input-file-picker-btn-choose"
			data-modal-title="<?php echo esc_attr( $data['settings']['heading'] ); ?>"
			data-allowed-type="<?php echo esc_attr( $data['settings']['allowed_type'] ); ?>"
	><?php _e( 'Choose', 'starter-kit' ); ?></button>
	
	<button
			type="button"
			class="vc_btn vc_btn-black jsc-input-file-picker-btn-remove"
	>X
	</button>

</div>