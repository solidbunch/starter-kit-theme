(function ($) {
	"use strict";

	window.shortcode_select_coin_init = function () {
		var exchange = 0;
		
		//SubmitWithSell events start
		$('.sell-link-text').on('click', function (e) {
			GetCurrency($('.select_coin_field'));
			
		});
		$('.buy-link-text').on('click', function (e) {
			GetCurrency($('.select_coin_field'));
		});
		//SubmitWithSell events end
	
		$('.select_coin_field').each(function( index ) {
		  GetCurrency(this);
		});
		
		$('.select_coin_field').on('change', function (e) {
			e.preventDefault();
			
			GetCurrency(this);

			return false;
		});

        //dynamic currency selector begin
        $('.select_currency_field').on('change', function (e) {
            e.preventDefault();
            $('form').find('.sell_curr').attr('placeholder', $(this).val());
            $('form').find('.sell_code').val($(this).val());
            GetCurrency($('.select_coin_field'));
            return false;
        });
        //dynamic currency selector end

		$('.buy_curr').on('keyup change', function (e) {
			MakeExchange(this);
		});

		$('.sell_curr').on('keyup change', function (e) {
			MakeExchangeBack(this);
		});

		function MakeExchange(buy_curr) {
			var buy_val = $(buy_curr).val();
			if (buy_val !='') {
				buy_val = buy_val.replace(',', '.');
				var sell_val = exchange*buy_val;
				sell_val = Math.round(sell_val*100);
				sell_val = sell_val/100;
				if (sell_val == 0) {
					sell_val = 0.01;
				}
				sell_val = 1*(sell_val.toFixed(2));
				
				$(buy_curr).parents('form').find('.sell_curr').val(sell_val);
				SaveResult($(buy_curr).parents('form'));
			}
		}

		function MakeExchangeBack(sell_curr) {
			var sell_val = $(sell_curr).val();
			if (sell_val !='') {
				sell_val = sell_val.replace(',', '.');
				var buy_val = sell_val/exchange;
				buy_val = Math.round(buy_val*100);
				buy_val = buy_val/100;
				buy_val = 1*(buy_val.toFixed(2));
				
				$(sell_curr).parents('form').find('.buy_curr').val(buy_val);
				SaveResult($(sell_curr).parents('form'));
			}
		}
		
		function GetCurrency(curr_field) {

			var _query = {};
			//if (typeof(shortcodeSubmitWithSell) == 'undefined' || typeof(shortcodeSubmitWithSell.operation_to) == 'undefined' || shortcodeSubmitWithSell.operation_to == 'BUY') {
			if (typeof(shortcodeSelectCoin.operation) == 'undefined' || shortcodeSelectCoin.operation == 'BUY') {
				var buy_code = $(curr_field).val();
				var sell_code = $(curr_field).parents('form').find('.sell_code_default').val();
				
				$(curr_field).parents('form').find('.sell_curr').attr('placeholder', sell_code);
				$(curr_field).parents('form').find('.sell_code').val(sell_code); 
				
				$(curr_field).parents('form').find('.buy_curr').attr('placeholder', buy_code);
				$(curr_field).parents('form').find('.buy_code').val(buy_code);

			} else {
				var buy_code = $(curr_field).parents('form').find('.sell_code_default').val();
				var sell_code = $(curr_field).val();
				
				$(curr_field).parents('form').find('.sell_curr').attr('placeholder', sell_code);
				$(curr_field).parents('form').find('.sell_code').val(sell_code); 
				
				$(curr_field).parents('form').find('.buy_curr').attr('placeholder', buy_code);
				$(curr_field).parents('form').find('.buy_code').val(buy_code);
			}
			$(curr_field).parents('form').find('.buy_coin_label').text(sell_code+' = '+buy_code);

			var buy_curr = $(curr_field).parents('form').find('.buy_curr');
			
			var coin_margin = $('option:selected', curr_field).attr('data-margin');

			if (typeof(shortcodeSelectCoin.api_query) == 'object') {
				$.each(shortcodeSelectCoin.api_query, function(key, val){

					if (val == '{FROM}') {
						_query[key] = buy_code
					} else if (val == '{TO}') {
						_query[key] = sell_code
					}

				});

  				$.ajax({
					url: shortcodeSelectCoin.api_url,
					type: "GET",
					dataType: 'json',
					data: _query,
					success: function (answer) {
						console.log(_query);
						if (typeof(answer[buy_code][sell_code]) != 'undeined') {
							if (typeof(coin_margin) != 'undeined' && coin_margin !='') {
								exchange = 1*(answer[buy_code][sell_code]) + 1*(answer[buy_code][sell_code]/100*coin_margin);
							} else {
								exchange = 1*(answer[buy_code][sell_code]) + 1*(answer[buy_code][sell_code]/100*shortcodeSelectCoin.coins_margin_default);
							}
							MakeExchange(buy_curr);
							
							if ($('.landing-price-info').length > 0) {
								LandingPriceInfo(answer[buy_code][sell_code]);
							}
						}

					}
				});
			}
		}
		
		
		function SaveResult(form){
			
			var $sell_curr = $(form).find('.sell_curr');
			
			if (((1*shortcodeSelectCoin.min_order > 0) && (1*$sell_curr.val() < 1*shortcodeSelectCoin.min_order)) &&
				 (typeof(shortcodeSelectCoin.operation) == 'undefined' || shortcodeSelectCoin.operation == 'BUY')) {
					
				$('.min_order_error').remove();
				$(form).find('.select-coin-msg').html('<span class="min_order_error">'+shortcodeSelectCoin.min_order_msg+'</span>');
				$sell_curr.addClass('invalid');
			} else {
				$('.min_order_error').remove();
				$sell_curr.removeClass('invalid');
			}
			
			var sell_code = $(form).find('.sell_code').val();
			var buy_curr = $(form).find('.buy_curr').val();
			var buy_code = $(form).find('.buy_code').val();
			$(form).find('.result_coins').val(sell_code+':'+$sell_curr.val()+' = '+buy_code+':'+buy_curr);
		};

		function LandingPriceInfo(cource) {
			
			$('.landing-price-info').each( function() {

				var $container = $(this);
				var ptc = $container.find('.ptc').text();

				$container.find('.price .sell_symbol').html(shortcodeSelectCoin.sell_symbol);
				$container.find('.price .value').val('0.00');
				$container.find('.profit').val('0.00');

				if (typeof(shortcodeSelectCoin.operation) == 'undefined' || shortcodeSelectCoin.operation == 'BUY') {
					
					var current_price = cource;
				} else {
					var current_price = 1/cource;
					
				}
				if (current_price.toFixed(2) == 0) {
					current_price = 0.01;
				}

				var profit = ( 1000 / 6) * current_price;
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

			});

		}
		
	}
	


	window.shortcode_select_coin_init();

})(window.jQuery);
