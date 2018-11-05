(function($){
	"use strict";

	$(document).ready(function($) {

		$('body').on('click', '.add_awesome', function(event) {

			$('body').find('.awesome_block').toggleClass('active');

			if($(this).parent('.awesome_block').hasClass('active')){

				$(this).text('Add icon')


				}else{

				$(this).text('Hide icons')

			}
		})

		$('body').on('click', '.param_awesome', function(event) {

			var class_name = $(this).attr('att_class');
			$('body').find('.awesome_block').children('.wpb_vc_param_value').val(class_name);
			$('.param_awesome').removeClass('active');
			$(this).addClass('active');
			$('body').find('.icon_add_i').detach();
			$('.awesome_block').removeClass('active');
			$('.view_icon').addClass('active').after(' <i class="icon_add_i '+class_name+'"></i>')
			$('.add_awesome').text('Change icon')


		});

		$('body').on('keyup','.search_awesome',function(event) {

			$('.param_awesome').each(function(index, el) {

				var name = $('.search_awesome').val();

				if($(el).attr('title').indexOf(name) + 1){

					$(el).show();

				} else{

					$(el).hide();

				}

			});
		});
	});

})( window.jQuery );
