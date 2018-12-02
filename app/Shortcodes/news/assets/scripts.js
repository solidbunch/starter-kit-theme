(function ($) {

	"use strict";

	$('.shortcode-news-loadmore').on('click', function () {

		var $button = $(this),
			$newsContainer = $button.parents('.shortcode-news').find('.news'),
			data = {
				'action': 'shortcode_load_news',
				'query_vars': shortcodePostsJsParams.query_vars, // that's how we get params from wp_localize_script() function
				'paged': shortcodePostsJsParams.paged,
				'shortcode_atts': shortcodePostsJsParams.shortcode_atts
			};

		$.ajax({
			url: themeJsVars.ajaxurl, // AJAX handler
			data: data,
			type: 'POST',
			beforeSend: function (xhr) {
				$newsContainer.css('opacity', '0.7');
			},
			success: function (data) {

				if (data) {

					$newsContainer.append(data);
					shortcodeNewsJsParams.paged++;

					if (shortcodeNewsJsParams.paged == shortcodeNewsJsParams.max_num_pages) {
						$button.remove(); // if last page, remove the button
					}

				} else {
					$button.remove(); // if no data, remove the button as well
				}

				$newsContainer.css('opacity', '1');

			}
		});
	});

})(window.jQuery);
