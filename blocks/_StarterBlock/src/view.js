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

    const blankBlocks = document.getElementsByClassName('blank-block');

    if (blankBlocks.length > 0) {
      for (let blankBlock of blankBlocks) {
        new FrontendModule(blankBlock);
      }
    }
  }

})();
