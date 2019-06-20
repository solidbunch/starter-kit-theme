import $ from 'jquery';
import Theme from './front-components/theme'
import HeaderMenu from './front-components/header-menu'

require('popper.js');
require('bootstrap'); // full bootstrap
// require('bootstrap/js/src/button'); // single bootstrap component

$(document).ready(() => {
	new Theme();
	new HeaderMenu();
});
