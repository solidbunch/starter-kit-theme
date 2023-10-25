/**
 * Block front class
 */
export default class FrontendModule {

  /**
   * Constructor
   *
   * @param {Element} blankBlock
   */
  constructor(blankBlock) {
    this.blankBlock = blankBlock;
    this.someThingInner = blankBlock.querySelector(".some-class");

    console.log('BlankBlock FrontendModule loaded');

    this.doSomething(this.someThingInner)

  }

  doSomething(someThingInner) {
    const self = this;

    // Using 'self' to access the class instance inside the event listener
    console.log(self.blankBlock);
    console.log('BlankBlock FrontendModule Something happened');
    // Do something
  }

}
