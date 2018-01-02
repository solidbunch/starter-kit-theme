(function($){

	"use strict";

	$('.shortcode-reviews').each( function() {
		var $elem = $(this),
		$ratingField = $elem.find('.rating'),
		rating = $ratingField.data('rating');

		$ratingField.starRating({
			starSize: 15,
			totalStars: rating,
			readOnly: true,
			useGradient: false,
			activeColor: '#2fc8c3',
			emptyColor: '#ececec',
			strokeColor: '#2fc8c3',
			strokeWidth: 4
		});
	});

	$('.shortcode-reviews .carousel').slick({
		slidesToShow: 1,
		infinite: true,
		autoplay: true
	});

})( window.jQuery );