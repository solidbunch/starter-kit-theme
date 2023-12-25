import BlockHandlers from './Handlers/BlockHandlers';
import BootstrapSpacers from './Handlers/BootstrapSpacers';

const {addFilter} = wp.hooks;

export default class Hooks {

  static run() {

    addFilter(
      'blocks.getBlockDefaultClassName',
      'starter_kit/remove-block-default-class-name',
      BlockHandlers.removeBlockDefaultClassName,
    );

    /** Spacers */
    addFilter(
      'blocks.registerBlockType',
      'starter_kit/add-spacers-attribute',
      BootstrapSpacers.addSpacerAttribute,
    );

    addFilter(
      'blocks.registerBlockType',
      'starter_kit/edit-spacers-classes-wrapper',
      BootstrapSpacers.modifyBlockWrapperClass,
    );

    addFilter(
      'editor.BlockEdit',
      'starter_kit/edit-spacers-classes',
      BootstrapSpacers.editSpacerClasses,
    );

    addFilter(
      'blocks.getSaveContent.extraProps',
      'starter_kit/save-spacers-classes',
      BootstrapSpacers.saveSpacerClasses,
    );

  }

}
