(function ($) {

	"use strict";

	$('.shortcode-posts-loadmore').on('click', function () {

		var $button = $(this),
			$postsContainer = $button.parents('.shortcode-posts').find('.posts'),
			data = {
				'action': 'shortcode_load_posts',
				'query_vars': shortcodePostsJsParams.query_vars, // that's how we get params from wp_localize_script() function
				'paged': shortcodePostsJsParams.paged,
				'shortcode_atts': shortcodePostsJsParams.shortcode_atts
			};

		$.ajax({
			url: themeJsVars.ajaxurl, // AJAX handler
			data: data,
			type: 'POST',
			beforeSend: function (xhr) {
				$postsContainer.css('opacity', '0.7');
			},
			success: function (data) {

				if (data) {

					$postsContainer.append(data); // insert new posts
					shortcodePostsJsParams.paged++;

					if (shortcodePostsJsParams.paged == shortcodePostsJsParams.max_num_pages) {
						$button.remove(); // if last page, remove the button
					}

				} else {
					$button.remove(); // if no data, remove the button as well
				}

				$postsContainer.css('opacity', '1');

			}
		});
	});

})(window.jQuery);
