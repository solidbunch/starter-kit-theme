/**
 * Block dependencies
 */
import metadata from '../block.json';

import Edit from './js/Edit';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {useState, useEffect} = wp.element;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const blockClass = attributes.defaultClass;
      return {className: blockClass};
    },
    edit: props => {
      const {attributes, setAttributes, className} = props;

      useEffect(() => {
        if (attributes.mainImage.id && attributes.hidpi) {
          setDimensionHiDPI(true);
          console.log(`1 useEffect`);
        }
      }, [attributes.mainImage.id,attributes.hidpi]);

      const setDimensionHiDPI = (checked) => {
        const newnumber = checked ? Math.trunc(attributes.test / 2) : Math.trunc(attributes.test * 2);
        setAttributes({test: newnumber});
        console.log(attributes.test);
      };
      const setHiDPI = (checked) => {
        setAttributes({hidpi: checked});
        setDimensionHiDPI(checked);
      };
      // letter protection
      const handleKeyPress = (event) => {
        const allowedCharacters = /[0-9]/;
        if (!allowedCharacters.test(event.key)) {
          event.preventDefault();
        }
      };

      //change Width and Height in mainImage or srcSet
      const handleChange = (event, breakpoint) => {
        let newWidth = parseInt(event.replace(/\D/g, ''), 10);
        if (isNaN(newWidth)) {
          newWidth = "";
        }

        const {startWidth, ratio, id} = breakpoint ? attributes.srcSet[breakpoint] : attributes.mainImage;
        const idValidation = breakpoint ? attributes.mainImage.id === id : true;

        if (!idValidation) {
          if (newWidth > startWidth) {
            newWidth = startWidth;
          }
        } else if (newWidth > attributes.mainImage.startWidth) {
          newWidth = attributes.mainImage.startWidth;
        }
        let newHeight = Math.trunc(newWidth / ratio);

        if (breakpoint) {
          changeDimension('srcSet', breakpoint, {width: newWidth, height: newHeight});
        } else {
          changeDimension('mainImage', null, {width: newWidth, height: newHeight});
        }
      };
      //"Loss of focus on input"
      const handleBlur = (event, breakpoint = null) => {
        const {mainImage, srcSet} = attributes;

        if (event.target.value === "") {
          if (breakpoint === null) {
            const {startWidth, ratio} = mainImage;
            const newHeight = Math.trunc(startWidth / ratio);
            changeDimension('mainImage', null, {width: startWidth, height: newHeight});
          } else {
            const {startWidth, viewPort, ratio, id} = srcSet[breakpoint];
            const idValidation = mainImage.id === id;

            let newWidth = (!idValidation && startWidth <= viewPort) ? startWidth : viewPort;
            const newHeight = Math.trunc(newWidth / ratio);
            changeDimension('srcSet', breakpoint, {width: newWidth, height: newHeight});
          }
        }
      };
      //Set Width and Height in mainImage or srcSet
      const changeDimension = (type, breakpoint, updatedAttributes) => {
        let newAttributes = {};

        if (type === 'mainImage') {
          newAttributes = {mainImage: {...attributes.mainImage, ...updatedAttributes}};
        } else if (type === 'srcSet') {
          newAttributes = {
            srcSet: {
              ...attributes.srcSet,
              [breakpoint]: {...attributes.srcSet[breakpoint], ...updatedAttributes},
            },
          };
        }

        setAttributes(newAttributes);
      };

      //reset attributes to Default (Main Image)
      const handleResetImage = (breakpoint) => {
        setAttributes({
          srcSet: {
            ...attributes.srcSet,
            [breakpoint]: {
              ...attributes.srcSet[breakpoint],
              imageUrl: attributes.mainImage.src,
              id: attributes.mainImage.id,
              startWidth:'',
              ratio:attributes.mainImage.ratio,
              width:attributes.srcSet[breakpoint].viewPort,
              height: Math.trunc(attributes.srcSet[breakpoint].viewPort / attributes.mainImage.ratio),
            }
          }
        });
      };

      return [
        //renderControls(props),
        Edit.renderOutput(props),
      ];
    },
    save: () => {
      // Rendering in PHP
      return null;
    },

  },
);
