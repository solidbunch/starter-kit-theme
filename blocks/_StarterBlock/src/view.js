/**
 * Block frontend view scripts
 */
import FrontendModule from "./Handlers/FrontendModule";

(function () {
  "use strict";


  /**
   * Init block on load
   */
  window.addEventListener('load', () => {
    blockInit();
  });

  /**
   * Init block
   */
  function blockInit() {

    const starterBlocks = document.getElementsByClassName('starter-block');

    if (starterBlocks.length > 0) {
      for (let starterBlock of starterBlocks) {
        new FrontendModule(starterBlock);
      }
    }
  }

})();
