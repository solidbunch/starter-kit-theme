(function($){

	"use strict";

	$('.shortcode-brokers .carousel').slick({
		slidesToShow: 3,
		infinite: true,
		responsive: [
		{
			breakpoint: 995,
			settings: {
				slidesToShow: 2
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1
			}
		}
		]
	});

})( window.jQuery );