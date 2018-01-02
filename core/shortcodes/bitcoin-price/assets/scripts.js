(function($){

	"use strict";

	$('.bitcoin-price-info-shortcode').each( function() {

		var apiUrl = bvcBitcoinPriceVars.apiUrl,
		$container = $(this),
		ptc = $container.find('.ptc').text();

		$.ajax({
			url: apiUrl,
			type: "GET",
			dataType: 'json',
			success: function (answer) {

				var current_price = answer.BTC.GBP,
				profit = ( 1000 / 6) * current_price;

				//$container.find('.price .value').text( current_price );
				//$container.find('.profit').text( profit.toFixed(2) );

				$container.find('.price .value').animateNumber({
					number: current_price,
					numberStep: function(now, tween) {

						$(tween.elem).text( now.toFixed(2) );
					}
				}, 1000 );

				$container.find('.profit').animateNumber({
					number: profit,
					numberStep: function(now, tween) {

						$(tween.elem).text( now.toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
					}
				}, 1000 );

			}
		});

	});

})( window.jQuery );
