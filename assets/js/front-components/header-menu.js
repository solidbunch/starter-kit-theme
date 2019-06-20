import $ from 'jquery';

export default class HeaderMenu {
    /**
     Constructor
     **/
    constructor() {
        this.build();
    }

    /**
     Build page elements, plugins init
     **/
    build() {
        this.setupHeaderMenu();
    }

    /**
     * Setup Header
     **/
    setupHeaderMenu() {

        if ( $('.main-header .navbar-toggler').is(":visible") ) {

            $('.dropdown-menu .dropdown-toggle-split').on('click', function (e) {
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');

                return false;
            });
        }

    }

}


