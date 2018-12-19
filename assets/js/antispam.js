(function ($) {

	"use strict";

	window.themeAntispam = {

		/**
		 Constructor
		 **/
		initialize: function () {

			var self = this;

			$(document).ready(function () {
				self.setupFormsAntispam();
			});

		},


		/**
		 * Setup Antispam Field
		 **/
		setupFormsAntispam: function () {

			$('body').find('form').each(function () {

				if ($(this).attr('method').toUpperCase() === 'POST') {

					$(this).find('input[type=submit], button[type=submit]').each(function () {
						try {
							var sbmt = $(this)[0],
								npt = document.createElement('input'),
								d = new Date(),
								__ksinit = function () {
									sbmt.parentNode.insertBefore(npt, sbmt);
								};

							npt.value = d.getUTCDate() + '' + (d.getUTCMonth() + 1) + Math.random();
							npt.name = 'as_code';
							npt.type = 'hidden';
							sbmt.onmousedown = __ksinit;
							sbmt.onkeypress = __ksinit;
						} catch (e) {
						}
					});
				}

			});

		},


	}

	window.themeAntispam.initialize();

})(window.jQuery);



