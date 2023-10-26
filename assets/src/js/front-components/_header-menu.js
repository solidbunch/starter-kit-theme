import $ from 'jquery';

export default class headerMenu {
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


