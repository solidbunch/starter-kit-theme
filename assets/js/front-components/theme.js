import $ from 'jquery';

export default class Theme {
	/**
	 Constructor
	 **/
	constructor() {
		this.build();
		this.events()
	}

	/**
	 Build page elements, plugins init
	 **/
	build() {
		this.setupHeader();
		this.loadGoogleFonts();
		this.mobileMenuListener( '.navigation-menu' );
	}

	/**
	 Set page events
	 **/
	events() {

	}

	/**
	 * Setup Header
	 **/
	setupHeader() {

		// mobile menu toggles
		$('#mobile-menu-toggler').on('click', function () {

			$(this).toggleClass('is-active');
			$('#header ul.menu').toggleClass('open');

			return false;
		});

		// mobile sub-menu toggler
		$('#header .menu-item-has-children').append('<span class="mobile-submenu-toggler"></span>');

		$('.mobile-submenu-toggler').on('click', function () {
			$(this).toggleClass('open').prev('.sub-menu').toggleClass('open');
		});

	}

	/**
	 * Load Google Fonts
	 **/
	loadGoogleFonts() {
		WebFont.load({google: {families: ["Oswald:300,400,700", "PT+Serif:400,400i"]}});
	}

	/** Check for mobile device **/
	isMobile() {
		return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
	}

	stringToBoolean(string) {

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
	}

	/** Check email address **/
	isValidEmailAddress(emailAddress) {
		const pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		return pattern.test(emailAddress);
	}

	/** Mobile menu **/
	mobileMenuListener(selector) {

		jQuery(function($) {

			$(selector).parent().find('.mobile-menu li.menu-item-has-children').prepend('<span class="rh-arrow"></span>');

			$(selector).parent().find('.mobile-menu li.menu-item-has-children>.rh-arrow').on('click', function(e) {
				$(this).parent().find('> .sub-menu').slideToggle("slow");
				$(this).toggleClass('active');
				$(this).parent().find('> a').toggleClass('active');
			});

			$('.menu-button').on('click', function() {
				$(this).toggleClass('active');
				if ($(this).hasClass('active')) {
					$(this).parent().find('.mobile-menu').show().animate({"right":"50%"}, 500);
				} else {
					$(this).parent().find('.mobile-menu').animate({"right":"-200%"}, 500, function(){$(this).parent().find('.mobile-menu').hide() } );
				}
			});

		});

	}
}
