export default class BlockEvents {

  static setDefaultBlock(blockName) {
    wp.domReady(() => {
      wp.blocks.setDefaultBlockName(blockName);
    });
  }
}
