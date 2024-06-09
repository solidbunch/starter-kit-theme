/**
 * Block frontend view scripts
 */
// import FrontendModule from "./Handlers/FrontendModule";
import 'bootstrap/js/src/offcanvas';
import 'bootstrap/js/src/dropdown';

(function () {
  "use strict";

  /**
   * Init block on load
   */
  window.addEventListener('load', () => {
    hoverDropDown();
  });

  /**
   * Init block
   */
  function hoverDropDown() {
    document.querySelectorAll('.navbar-nav .dropdown').forEach(dropdown => {
      dropdown.addEventListener('mouseenter', function () {
        this.querySelector('.dropdown-menu').classList.add('show');
        this.querySelector('.nav-link').classList.add('show');
      });
    
      dropdown.addEventListener('mouseleave', function () {
        this.querySelector('.dropdown-menu').classList.remove('show');
        this.querySelector('.nav-link').classList.remove('show');
      });
    });
    
  }

})();
