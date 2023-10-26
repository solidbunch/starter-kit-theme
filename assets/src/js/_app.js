import $ from 'jquery';
import Theme from './front-components/_theme'
//startbootstrapmenu
import headerMenu from './front-components/_header-menu'
//endbootstrapmenu

require('popper.js');
require('bootstrap'); // full bootstrap
// require('bootstrap/js/src/button'); // single bootstrap component

$(document).ready(() => {
	new Theme();
	new headerMenu();
});
