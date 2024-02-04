/**
 * faqSection block editor class
 */
export default class FaqSectionFrontend {

  /**
   * Constructor
   *
   * @param {Element} faqSection
   */
  constructor(faqSection) {
    this.faqSection = faqSection;
    this.faqFaqs = this.faqSection.getElementsByClassName('blnb-faq');
    this.faqQuestions = this.faqSection.getElementsByClassName('blnb-faq__question');

    if (this.faqQuestions.length > 0) {
      for (let question of this.faqQuestions) {
        question.addEventListener('click', (event) => {
          event.preventDefault();
          this.toggleClass(question);
        });
      }
    }

  }

  /**
   * Toggle css class
   *
   * @param {Element} question
   */
  toggleClass(question) {
    const cssClass = 'blnb-faq--open';
    const currentFaq = question.parentElement;

    // Click on the opened element to close it
    if (currentFaq.classList.contains(cssClass)) {
      currentFaq.classList.remove(cssClass);
      return;
    }

    // Click on closed element to open it
    for (let faq of this.faqFaqs) {
      faq.classList.remove(cssClass);
    }

    currentFaq.classList.add(cssClass);
  }
}
