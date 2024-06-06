export default class BlockHandlers {

  /**
   * Filter to remove blocks default class name like 'wp-block-custom-block'
   * @param {string} className
   * @param {string} blockName
   *
   * @return {string}
   */
  static removeBlockDefaultClassName(className, blockName) {

    if (blockName.startsWith('starter-kit/')) {
      className = '';
    }

    return className;
  }
}
