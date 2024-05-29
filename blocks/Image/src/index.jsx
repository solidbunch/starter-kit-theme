/**
 * Block dependencies
 */
import metadata from '../block.json';

import Edit from './js/Edit';

const {registerBlockType} = wp.blocks;

registerBlockType(
  metadata,
  {
    edit: props => {

      return [
        Edit.renderControls(props),
        Edit.renderOutput(props, metadata),
      ];
    },
    save: () => {
      // Rendering in PHP
      return null;
    },

  },
);
