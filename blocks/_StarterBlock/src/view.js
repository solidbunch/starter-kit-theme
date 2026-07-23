/**
 * Block frontend view script (optional) — JS that only runs on the front end, e.g. attaching
 * interactivity to markup already saved by save(). Delete this file and the matching
 * 'view_script' entry in Block.php's $blockAssets if the block is purely static markup.
 *
 * See YouTubeLite/src/view.js (click-to-load) or Code/src/view.js (syntax highlighting) for
 * real examples of this pattern.
 */
import FrontendModule from './Handlers/FrontendModule';

(function () {
  'use strict';

  window.addEventListener('load', () => {
    blockInit();
  });

  function blockInit() {
    const starterBlocks = document.getElementsByClassName('starter-block');

    for (const starterBlock of starterBlocks) {
      new FrontendModule(starterBlock);
    }
  }
})();
