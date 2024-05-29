/**
 * Block editor Events
 */
export default class Events {

  /**
   * Preventing clicking on a link when editing a block
   *
   * @param {Event}    event
   * @param {Function} isSelected
   */
  static preventLinkNavigation = (event, isSelected) => {
    if (isSelected) {
      event.preventDefault();
    }
  };
}
