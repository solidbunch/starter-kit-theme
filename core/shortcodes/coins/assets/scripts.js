(function($){

	"use strict";

	$('.shortcode-coins').each( function() {
	
		var $shortcode = $(this),
		$loadMoreButton = $shortcode.find('.load-more-posts');

		$loadMoreButton.on('click', function() {

			var $link = $(this);

			if( $link.hasClass('loading') ) {
				return false;
			}

			var targetId = $link.data('target-id'),
			$target = $( targetId ),
			data = $link.data(),
			action = $link.data('action');

			$.ajax({
				url: bvcJsVars.ajaxurl,
				type: "POST",
				dataType : 'json',
				data: {
					'action' : action,
					'data' : data
				},
				beforeSend: function() {
					$link.addClass('loading');
				},
				success: function( response ) {

					$loadMoreButton.removeClass('loading');

					$link.data( 'current-page', response.current_page );
					$link.data( 'next-page', response.next_page );
					$link.data( 'last-number', response.last_num );

					if( response.next_page > $link.data('max-pages') || window.bvcFront.stringToBoolean( response.hide_link ) ) {
						$link.parents('.ajax-pagination').remove();
					}

					if( response.html ) {
						$target.append( response.html );
					}

					$link.removeClass('loading');
					LoadCoinCurrency();

				}
			});

			return false;
		});
		
		LoadCoinCurrency();
	});
	
	
	function LoadCoinCurrency(){
		var buy_codes = {};
		var _query = {};
		$('.shortcode-coins .coin_code').each( function() {
			var coin_id = $(this).parent().find('.coin_id').val();
			buy_codes[coin_id] = $(this).val();
		});
		
		var buy_codes_str = '';
		$.each(buy_codes, function(key, val){
			buy_codes_str += val + ',';
		});
		
		if (buy_codes_str.length >0) {
			if (typeof(bvcCoins.api_query) === 'object') {
				$.each(bvcCoins.api_query, function(key, val){
					if (val === '{FROM}') {
						_query[key] = buy_codes_str
					} else if (val === '{TO}') {
						_query[key] = bvcCoins.code_sell
					}
				});

				$.ajax({
					url: bvcCoins.api_url,
					type: "GET",
					dataType: 'json',
					data: _query,
					success: function (answer) {
						$.each(answer, function(coin_id, coin_val){
							//console.log( coin_id, coin_val );
							$.each(coin_val, function(_key, _val){
								//console.log( coin_id +" *** " + bvcCoins.coins_margin_obj[coin_id] );
								_val = 1*(_val) + (_val/100) *bvcCoins.coins_margin_obj[coin_id];
								_val = 1*(_val.toFixed(4));
								$('input[value="'+coin_id+'"]').parents('.grid-item').find('.price').html(_key+':'+_val);
							});	
							
						});
					}
				});
			}
		}
	}

})( window.jQuery );