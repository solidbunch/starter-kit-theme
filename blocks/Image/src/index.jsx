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

/*      useEffect(() => {
        if (attributes.mainImage.id && attributes.hidpi) {
          setDimensionHiDPI(true);
          console.log(`1 useEffect`);
        }
      }, [attributes.mainImage.id,attributes.hidpi]);*/

/*      const setDimensionHiDPI = (checked) => {
        const newnumber = checked ? Math.trunc(attributes.test / 2) : Math.trunc(attributes.test * 2);
        setAttributes({test: newnumber});
        console.log(attributes.test);
      };
      const setHiDPI = (checked) => {
        setAttributes({hidpi: checked});
        setDimensionHiDPI(checked);
      };*/

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
