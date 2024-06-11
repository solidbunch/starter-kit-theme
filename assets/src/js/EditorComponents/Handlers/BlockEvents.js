export default class BlockEvents {

  /**
   * Set default block type
   * @param {string} blockName
   */
  static setDefaultBlock(blockName) {
    wp.domReady(() => {
      wp.blocks.setDefaultBlockName(blockName);
    });
  }
}
