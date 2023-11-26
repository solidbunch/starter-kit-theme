/**
 * Block front class
 */
export default class FrontendModule {

  /**
   * Constructor
   *
   * @param {Element} starterBlock
   */
  constructor(starterBlock) {
    this.starterBlock = starterBlock;
    this.someThingInner = starterBlock.querySelector(".some-class");

    // eslint-disable-next-line no-console
    console.log('StarterBlock FrontendModule loaded');

    this.doSomething(this.someThingInner);

  }

  doSomething(someThingInner) {
    const self = this;

    // Using 'self' to access the class instance inside the event listener
    // eslint-disable-next-line no-console
    console.log(self.starterBlock);
    // eslint-disable-next-line no-console
    console.log('StarterBlock FrontendModule Something happened' + someThingInner);
    // Do something
  }

}
