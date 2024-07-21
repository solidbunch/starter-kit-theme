/**
 * Block dependencies
 */
import metadata from '../block.json';
import variables from '../../../assets/build/variables.json';
import Edit from './js/Edit';

const {registerBlockType} = wp.blocks;

registerBlockType(
  metadata,
  {
    edit: props => {
      
      return [
        Edit.renderControls(props, metadata, variables),
        Edit.renderOutput(props, metadata, variables),
      ];
    },
    save: () => {
      // Rendering in PHP
      return null;
    },

  },
);
