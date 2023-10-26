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

    console.log('StarterBlock FrontendModule loaded');

    this.doSomething(this.someThingInner)

  }

  doSomething(someThingInner) {
    const self = this;

    // Using 'self' to access the class instance inside the event listener
    console.log(self.starterBlock);
    console.log('StarterBlock FrontendModule Something happened');
    // Do something
  }

}
