/**
 * Block frontend view scripts
 */
import FaqSectionFrontend from "./modules/FaqSectionFrontend";

(function () {
  "use strict";

  window.addEventListener('load', () => {

    // faqSection block
    const faqsSections = document.getElementsByClassName('blnb-faq-section');

    if (faqsSections.length > 0) {
      for (let faqsSection of faqsSections) {
        new FaqSectionFrontend(faqsSection);
      }
    }

  });

})();
