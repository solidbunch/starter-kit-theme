<div class="form-builder-item">
	<div class="field-file-uploader">
        <span class="file-uploader_icon"><i class="fa fa-file-o" aria-hidden="true"></i></span>
        <input type="hidden" name="field_<?php echo esc_attr( $data['atts']['el_id'] ); ?>_f_label"
			   value="<?php echo esc_attr( $data['atts']['label'] ); ?>"/>
        <label class="file_uploader"
               id="label_<?php echo esc_attr( $data['atts']['el_id'] )?>"
               for="field_<?php echo esc_attr( $data['atts']['el_id'] )?>"><?php echo esc_attr( $data['atts']['placeholder'] );?></label>
		<input type="file" class="hidden" <?php echo implode( ' ', $data['attributes'] ); ?> />
	</div>
</div>

<script>

    jQuery('input[type=file]').each(function () {
        var labelId = "label_<?php echo esc_attr( $data['atts']['el_id'] );?>";
        var fileUploaderId = "field_<?php echo esc_attr( $data['atts']['el_id'] );?>";
        var beforeFileName = "<?php echo esc_html__( 'File name: ', 'fruitfulblanktextdomain' );?>";
        var placeholder = "<?php echo esc_attr( $data['atts']['placeholder'] );?>";

        jQuery('#'+fileUploaderId).on('change', function(){
            var file = document.getElementById(fileUploaderId).value;
            file = file.replace (/\\/g, "/").split('/').pop ();
            inputText = (file.trim()==='') ? placeholder : beforeFileName + file;
            document.getElementById(labelId).innerHTML = inputText;
        });
    });


</script>