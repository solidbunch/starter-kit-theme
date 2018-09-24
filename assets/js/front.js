import $ from 'jquery';
const themeFront = require('./front/theme')($);

require('popper.js');
require('bootstrap'); // full bootstrap
// require('bootstrap/js/src/button'); // single bootstrap component

$(document).ready(() => {
    themeFront.initialize();
});