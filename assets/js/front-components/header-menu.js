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

        if ( !$('.main-header .navbar-toggler').is(":visible") ) {
            $('.dropdown-toggle').attr('data-toggle', '');

        } else {

            $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');


                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });


                return false;
            });
        }

    }

}


