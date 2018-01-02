<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);

$attributes = array();
$attributes[] = 'id="field_' . esc_attr($atts['el_id']) . '"';
$attributes[] = 'name="field_' . esc_attr($atts['el_id']) . '"';
$attributes[] = 'placeholder="' . esc_attr($atts['placeholder']) . '"';


//if (filter_var($atts['required'], FILTER_VALIDATE_BOOLEAN)) {
//	$attributes[] = 'required="required"';
//}

?>
<div class="form-builder-item">
	<div class="field-file-uploader">

        <span class="file-uploader_icon"><i class="fa fa-file-o" aria-hidden="true"></i></span>

        <input type="hidden" name="field_<?php echo esc_attr($atts['el_id']); ?>_f_label"
			   value="<?php echo esc_attr($atts['label']); ?>"/>
        <label class="file_uploader"
               id="label_<?=esc_attr($atts['el_id'])?>"
               for="field_<?=esc_attr($atts['el_id'])?>"><?=esc_attr($atts['placeholder']);?></label>
		<input type="file" class="hidden" <?php echo implode(' ', $attributes); ?> />

	</div>
</div>

<script>

    jQuery('input[type=file]').each(function () {
        var labelId = "label_<?=esc_attr($atts['el_id']);?>";
        var fileUploaderId = "field_<?=esc_attr($atts['el_id']);?>";
        var beforeFileName = "<?=esc_html__('File name: ', 'fruitfulblanktextdomain');?>";
        var placeholder = "<?=esc_attr($atts['placeholder']);?>";

        jQuery('#'+fileUploaderId).on('change', function(){

            var file = document.getElementById(fileUploaderId).value;

            file = file.replace (/\\/g, "/").split('/').pop ();

            inputText = (file.trim()==='') ? placeholder : beforeFileName + file;

            document.getElementById(labelId).innerHTML = inputText;
        });
    });


</script>