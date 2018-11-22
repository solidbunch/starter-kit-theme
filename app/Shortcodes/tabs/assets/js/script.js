(function ($) {

	"use strict";

	window.sk_tabs_shortcode = function () {

		// build tabs markup
		$('.sk_tabs').each(function () {

			var $shortcode = $(this),
				$titles = $shortcode.find('h4'),
				$tabs = $shortcode.find('.sk_tabs_tab'),
				type = $shortcode.data('type'),
				respBreak = $shortcode.data('break');

			// build nav for tabs
			$shortcode.prepend('<nav></nav>');

			var $nav = $shortcode.find('nav');

			$titles.each(function () {

				$nav.append('<a href="javascript:;">' + $(this).html() + '</a>');

			});

			$nav.find('a:first').addClass('current');
			$shortcode.find('.sk_tabs_tab:first').addClass('current active');

			// turn tabs into accordion on responsive break
			if ($shortcode.hasClass('type-accordion') == false) {

				$(window).on('resize', function () {

					if ($(window).width() <= respBreak) {
						$shortcode.removeClass('type-vertical');
						$shortcode.removeClass('type-default');
						$shortcode.addClass('type-accordion');
						$shortcode.find('.sk_tabs_tab').show();
						$shortcode.find('.sk-tab-content').hide();
						$shortcode.find('.sk_tabs_tab:first .sk-tab-content').show();
						$shortcode.find('.sk_tabs_tab').removeClass('current').removeClass('active');
						$shortcode.find('.sk_tabs_tab:first').addClass('current').addClass('active');
					} else {
						$shortcode.find('.sk-tab-content').show();

						$shortcode.find('.sk_tabs_tab').hide().removeClass('current');
						$shortcode.find('.sk_tabs_tab:first').show().addClass('current');

						$nav.find('a').removeClass('current').removeClass('active');
						$nav.find('a:first').addClass('current active');

						$shortcode.removeClass('type-accordion');
						$shortcode.addClass('type-' + type);
					}

				});

				$(window).trigger('resize');

			}

		});

	}

	window.sk_tabs_nav_shortcode = function () {

		// tabs click
		$('.sk_tabs.type-default nav a, .sk_tabs.type-vertical nav a').off('click').on('click', function () {

			var $link = $(this),
				$shortcode = $link.parents('.sk_tabs'),
				index = $link.parent().find('a').index($link);

			$shortcode.find('.sk_tabs_tab').hide();
			$shortcode.find('.sk_tabs_tab').eq(index).show();

			$shortcode.find('nav a').removeClass('current');
			$link.addClass('current');

			return false;
		});

		// accordion click
		$('.sk_tabs.type-accordion .sk-title').off('click').on('click', function () {

			var $link = $(this),
				$block = $link.parents('.sk_tabs_tab');

			$link.parents('.sk_tabs_tab').toggleClass('active');

			$block.find('.sk-tab-content').slideToggle();

			return false;
		});

	}

	window.sk_tabs_shortcode();

	window.sk_tabs_nav_shortcode();

	$(window).on('resize', function () {
		window.sk_tabs_nav_shortcode();
	});

})(window.jQuery);
