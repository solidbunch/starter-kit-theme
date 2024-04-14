/**
 * Block dependencies
 */
import metadata from '../block.json';

import Edit from './js/Edit';

const {registerBlockType} = wp.blocks;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const blockClass = attributes.defaultClass;
      return {className: blockClass};
    },
    edit: props => {

      return [
        Edit.renderControls(props),
        Edit.renderOutput(props),
      ];
    },
    save: () => {
      // Rendering in PHP
      return null;
    },

  },
);
