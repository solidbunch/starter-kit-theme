(function($){

	"use strict";

	window.bvcFront = {

		/**
			Constructor
		**/
		initialize: function() {

			var self = this;

			$(document).ready(function(){
				self.build();
				self.events();
			});

		},
		/**
			Build page elements, plugins init
		**/
		build: function() {

			var self = this;

			self.createParticles();
			self.loadSVG();
			self.setupInputForms();

		},
		/**
			Set page events
		**/
		events: function() {

			var self = this;

			self.setupHeader();
			self.setupMenu();

		},
		/** build particles **/
		createParticles: function() {

			$('.particles').each( function( i) {

				var $elem = $(this),
				elemId = $elem.attr('id');

				if( ! elemId ) {
					elemId = 'particles-num-' + i;
					$elem.attr('id', elemId );
				}

				particlesJS.load( elemId, bvcJsVars.assetsPath + '/libs/particlesjs-config.json');

			});

		},
		/** load inline SVG **/
		loadSVG: function() {

			$('img.image-svg').each(function(){

				var $img = $(this),
				imgID = $img.attr('id'),
				imgClass = $img.attr('class'),
				imgURL = $img.attr('src'),
				$imgParent = $img.parent(),
				imgParentId = $imgParent.attr('id'),
				customColor = $imgParent.data('svg-color'),
				extension = imgURL.replace(/^.*\./, '');

				extension = extension.toLowerCase();

				if( extension == 'svg' ) {

					$.get(imgURL, function(data) {
						// Get the SVG tag, ignore the rest
						var $svg = $(data).find('svg');

						// Add replaced image's ID to the new SVG
						if(typeof imgID !== undefined) {
							$svg = $svg.attr('id', imgID);
						}

						// Add replaced image's classes to the new SVG
						if(typeof imgClass !== undefined) {
							$svg = $svg.attr('class', imgClass+' replaced-svg');
						}

						// Remove any invalid XML tags as per http://validator.w3.org
						$svg = $svg.removeAttr('xmlns:a');

						// Check if the viewport is set, else we gonna set it if we can.
						if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
							$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'));
						}

						// Colorify
						if( customColor !== undefined ) {
							$imgParent.append('<style>#' + imgParentId + ' svg path, #' + imgParentId + ' svg rect, #' + imgParentId + ' svg polygon { fill: ' + customColor + '}</style>');
						}

						// Replace image with new SVG
						$img.replaceWith($svg);

					}, 'xml');

				}

			});

		},
		/** custom checkboxes **/
		setupInputForms: function() {
			$("input[type=radio], input[type=checkbox]").checkbox();
		},
		/** setup header **/
		setupHeader: function() {

			if( $('body').hasClass('page-template-landingpage') ) {
				return;
			}

			var topBarHeight = $('#top-bar').outerHeight(),
			$header = $('#header'),
			headerHeight = $header.outerHeight(),
			$scrollSpace = $('#header-scroll-space');

			$(window).on( 'scroll', function() {

				var scrollTop = $(window).scrollTop();

				if( scrollTop > topBarHeight ) {
					$scrollSpace.height( headerHeight );
					$header.addClass('scrolled');
				} else {
					$scrollSpace.height( '0px' );
					$header.removeClass('scrolled');
				}

			});

		},
		/** setup menu **/
		setupMenu: function() {

			$('#mobile-menu-toggler').on('click', function() {
				$(this).toggleClass('is-active');
				$('#header-menu').toggleClass('open');
				return false;
			});

			$('.menu-item-has-children > a').on( 'click', function() {

				if( $(window).width() <=995 ) {
					var $link = $(this),
					$li = $link.parent();

					if( $li.hasClass('menu-item-open-mobile') == false ) {
						$li.addClass('menu-item-open-mobile');
						return false;
					}
				}

			});

		},
		/** Check for mobile device **/
		isMobile: function() {
			return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent );
		},
		stringToBoolean: function(string){

			switch(string){
				case "true": case "yes": case "1": return true;
				case "false": case "no": case "0": case null: case '': return false;
				default: return Boolean(string);
			}
		},
		/** Check email address **/
		isValidEmailAddress: function( emailAddress ) {
			var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
			return pattern.test( emailAddress );
		}

	}

	window.bvcFront.initialize();

})( window.jQuery );
