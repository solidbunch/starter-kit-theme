/**
 * Frontend behavior for one block instance. This class-per-instance pattern is the same one
 * Image's editor JS (src/js/Edit.jsx + Handlers/Model/Helper) scales up to a full MVC split —
 * start simple here, split further only if the block's frontend logic actually grows.
 */
export default class FrontendModule {

  /**
   * @param {Element} starterBlock
   */
  constructor(starterBlock) {
    this.starterBlock = starterBlock;
    this.icon = starterBlock.querySelector('.starter-block__icon');

    this.bindEvents();
  }

  bindEvents() {
    if (!this.icon) {
      return;
    }

    this.icon.addEventListener('click', () => this.onIconClick());
  }

  onIconClick() {
    this.starterBlock.classList.toggle('starter-block--active');
  }

}
