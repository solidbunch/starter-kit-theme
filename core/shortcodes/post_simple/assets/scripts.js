(function($){

	"use strict";

	$('.shortcode-postsimple').each( function() {
	
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
		
	});
	
	

})( window.jQuery );