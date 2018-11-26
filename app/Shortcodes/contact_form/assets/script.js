(function ($) {
	"use strict";

    function validateUploadedFile( $file, $allowedTypes ) {

        var $splitUploadedFilename = $file.val().split('.');
        var $fileType = $splitUploadedFilename[$splitUploadedFilename.length - 1];

        if ( $allowedTypes.indexOf( $fileType ) != -1 ){
        	return true;
		} else {
            var $error_msg = ' You can upload only:';
        	$allowedTypes.forEach(function(item, i) {
				if (i>0 && i<$allowedTypes.length) {
					$error_msg += ',';
				}
                $error_msg = $error_msg + ' *.' + item;
            });
        	return $error_msg;
		}
    }   

	window.contact_form_init = function () {

		$('form.fw_form_fw_form').on('submit', function (e) {
			e.preventDefault();

			if ($('#operation_to').val() != '') {
				ShortcodeContactForm.operation_to = $('#operation_to').val();
			}

			var $form  = $(this),
			successMsg = $form.data('msg-success');

			$form.find('.form-error-msg').remove();

            var $fileValidateMsg = '';

            $form.find('input[type=text], input[type=email], textarea, input[type=file]').removeClass('invalid').each(function () {

				var $input = $(this),
					val    = $input.val();

				if ($input.attr('required') == 'required' && $.trim(val) == '') {

					$input.addClass('invalid');

				} else if($input.attr('type') == 'file'){

                    $input.parent().removeClass('invalid');
                    var allowedFileTypes = ['pdf', 'png', 'jpg', 'jpeg', 'bmp'];

				if (validateUploadedFile($input, allowedFileTypes) !== true){
                        $fileValidateMsg = validateUploadedFile($input, allowedFileTypes)
						$input.addClass('invalid').parent().addClass('invalid');
					}
                }
			});

			$form.find('.invalid:first').focus();

			if (!$form.find('.invalid').length) {
				
				var values   = $form.serialize();
				var form_id  = $form.attr('id');
				var form     = document.getElementById(form_id);
				var formData = new FormData(form);
				formData.append('action', 'contact_form');
				formData.append('form_data', $form.data('form-data'));
				formData.append('security', $form.data('nonce'));
				formData.append('form_values', values);
				console.log( formData );
				
				$.ajax({

					type: "POST",
					enctype: 'multipart/form-data',
					url: ShortcodeContactForm.ajaxurl,
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
                    beforeSend: function () {

                        $form.html('<h4 class="success" style="text-align: center;"><div id="preloader_wrapper"> <div id="block_1" class="preloader_block"></div><div id="block_2" class="preloader_block"></div><div id="block_3" class="preloader_block"></div></div></h4>');
                    
                    },
					success: function (answer) {
						console.log( answer );
						if (JSON.parse(answer).result == 'ok') {
							if ($.trim($form.data('redirect-url')) != '') {
								window.location.href = $form.data('redirect-url');
								return false;
							}
							$form.html('<h4 class="success" style="text-align: center;">' + $form.data('msg-success') + '</h4>');
						}
					}
				});

				return false;
			} else {
				$form.append('<div class="form-error-msg">' + ShortcodeContactForm.strFormError + $fileValidateMsg+'</div>');
			}
			return false;
		});
	}

	window.contact_form_init();
})(window.jQuery);

