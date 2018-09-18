(function ($) {

	"use strict";

	window.themeFront = {

		/**
		 Constructor
		 **/
		initialize: function () {

			var self = this;

			$(document).ready(function () {
				self.build();
				self.events();
			});

		},
		/**
		 Build page elements, plugins init
		 **/
		build: function () {

			this.setupHeader();
			this.loadGoogleFonts();

		},
		/**
		 Set page events
		 **/
		events: function () {


		},

		/**
		 * Setup Header
		 **/
		setupHeader: function() {

			// mobile menu toggles
			$('#mobile-menu-toggler').on( 'click', function() {

				$(this).toggleClass('is-active');
				$('#header ul.menu').toggleClass('open');

				return false;
			});

			// mobile sub-menu toggler
			$('#header .menu-item-has-children').append('<span class="mobile-submenu-toggler"></span>');

			$('.mobile-submenu-toggler').on( 'click', function() {
				$(this).toggleClass('open').prev('.sub-menu').toggleClass('open');
			});

		},

		/**
		 * Load Google Fonts
		 **/
		loadGoogleFonts: function () {

			WebFont.load({google: {families: ["Oswald:300,400,700", "PT+Serif:400,400i"]}});

		},

		/** Check for mobile device **/
		isMobile: function () {
			return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
		},
		stringToBoolean: function (string) {

			switch (string) {
				case "true":
				case "yes":
				case "1":
					return true;
				case "false":
				case "no":
				case "0":
				case null:
				case '':
					return false;
				default:
					return Boolean(string);
			}
		},
		/** Check email address **/
		isValidEmailAddress: function (emailAddress) {
			var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
			return pattern.test(emailAddress);
		}

	}

	window.themeFront.initialize();

})(window.jQuery);
