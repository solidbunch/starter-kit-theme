import $ from 'jquery';
import Front from './front/theme'

require('popper.js');
require('bootstrap'); // full bootstrap
// require('bootstrap/js/src/button'); // single bootstrap component

$(document).ready(() => {
    new Front();
});