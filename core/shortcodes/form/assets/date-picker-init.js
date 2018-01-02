;(function ($) {
	"use strict";

	var contactDatepicker = $('.air-datepicker').datepicker({
		minDate: new Date(),
		inline: true,
		position: "bottom left",
		timepicker: true,
		timeFormat: "hh:ii",
		language: 'en',

	}).data('datepicker');

	contactDatepicker.selectDate(new Date());



})(window.jQuery);
