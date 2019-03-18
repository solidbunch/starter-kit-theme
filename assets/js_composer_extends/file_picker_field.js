!function ($) {
	
	var jscFilePickerMedia;
	
	/**
	 * Choose a file
	 */
	$('body').on('click', 'button.jsc-input-file-picker-btn-choose', function (e) {
		e.preventDefault();
		
		var $btn = $(this),
			mediaType = $btn.data('allowed-type'),
			modalTitle = $btn.data('modal-title'),
			$paramHolder = $btn.parents('.file-picker-fields'),
			$result = $paramHolder.find('.jsc-input-file-picker-input');
		
		jscFilePickerMedia = wp.media.frames.jscFilePickerMedia = wp.media({
			className: 'media-frame wproto-media-frame',
			frame: 'select',
			multiple: false,
			title: modalTitle,
			library: {
				type: mediaType
			}
		});
		
		jscFilePickerMedia.on('select', function () {
			var attachment = jscFilePickerMedia.state().get('selection').first().toJSON();
			$result.val(attachment.url);
		}).open();
		
	});
	
	/**
	 * Clear selection
	 */
	$('body').on('click', 'button.jsc-input-file-picker-btn-remove', function (e) {
		e.preventDefault();
		
		var $btn = $(this),
			$paramHolder = $btn.parents('.file-picker-fields'),
			$result = $paramHolder.find('.jsc-input-file-picker-input');
		
		$result.val('');
		
	});
	
}(window.jQuery);