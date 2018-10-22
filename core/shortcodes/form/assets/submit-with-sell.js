(function ($) {
	"use strict";
	
	window.shortcode_submit_with_sell_init = function () {
		if (ShortcodeSubmitWithSell.operation_to == 'SELL') {
			$('.sell-link-text').hide();
			$('.button-buy').hide();
			$('.buy-link-text').show();
			$('.button-sell').show();
		}
		
		$('.sell-link-text').on('click', function (e) {
			$('.sell-link-text').hide();
			$('.button-buy').hide();
			$('.buy-link-text').show();
			$('.button-sell').show();
			$('#operation_to').val('SELL');
			ShortcodeSubmitWithSell.operation_to = 'SELL';
			
		});
		$('.buy-link-text').on('click', function (e) {
			$('.buy-link-text').hide();
			$('.button-sell').hide();
			$('.sell-link-text').show();
			$('.button-buy').show();
			$('#operation_to').val('BUY');
			ShortcodeSubmitWithSell.operation_to = 'BUY';
		});

	}

	window.shortcode_submit_with_sell_init();

})(window.jQuery);

