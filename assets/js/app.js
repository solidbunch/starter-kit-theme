import $ from 'jquery';
import Theme from './front-components/theme'
//startbootstrapmenu
import HeaderMenu from './front-components/header-menu'
//endbootstrapmenu

require('popper.js');
require('bootstrap'); // full bootstrap
// require('bootstrap/js/src/button'); // single bootstrap component

$(document).ready(() => {
	new Theme();
	new HeaderMenu();
});
