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
					try {
						var $form = $(this),
							d = new Date(),
							code = (d.getUTCHours() + 1)  * d.getUTCDate() * (d.getUTCMonth() +1) * d.getUTCFullYear(),
							name = 'a' + 's' + String.fromCharCode(95) + 'co' + 'de',
							insert = function () {
								if ($form.find('input[name="' + name + '"]').length === 0) {
									$form.append('<input name="' + name + '" type="hidden" value="' + code + '">');
								}
							};

						$form.mousedown(function() {
							insert();
						});

						$form.keypress(function() {
							insert();
						});

					} catch (e) {

					}

				}

			});

		},


	}

	window.themeAntispam.initialize();

})(window.jQuery);



