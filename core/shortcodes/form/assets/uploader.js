;(function ($) {

    jQuery('input[type=file]').each(function () {
        
        var labelId = jQuery('.file_uploader').attr('id');
        var fileUploaderId = jQuery('.file_uploader').attr('for');
        var beforeFileName = jQuery('.file_uploader').attr('plac');
        var placeholder = jQuery('.file_uploader').text();

        jQuery('#'+fileUploaderId).on('change', function(){
            var file = document.getElementById(fileUploaderId).value;
            file = file.replace (/\\/g, "/").split('/').pop ();
            inputText = (file.trim()==='') ? placeholder : beforeFileName + file;
            document.getElementById(labelId).innerHTML = inputText;
        });
    });
    
})(window.jQuery);