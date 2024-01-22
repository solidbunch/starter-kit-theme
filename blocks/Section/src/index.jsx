/**
 * Block dependencies
 */

import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, InnerBlocks} = wp.blockEditor;
const {PanelBody, SelectControl} = wp.components;

function checkHasChildBlocks(clientId) {
  const {getBlockOrder} = wp.data.select('core/block-editor');
  return getBlockOrder(clientId).length > 0;
}

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const {backgroundColor, textColor} = attributes.modification || {};
      const blockClass = `${backgroundColor || ''} ${textColor || ''}`.trim();

      return {className: blockClass};
    },

    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      const dataBsThemeAttribute = attributes.modification.colorTheme
        ? {'data-bs-theme': attributes.modification.colorTheme}
        : {};

      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Section styles">
            <SelectControl
              label="Select Tag"
              value={attributes.modification.tagName || 'section'}
              options={[
                {label: '<section>', value: 'section'},
                {label: '<div>', value: 'div'},
                {label: '<main>', value: 'main'},
                {label: '<article>', value: 'article'},
                {label: '<aside>', value: 'aside'},
                {label: '<header>', value: 'header'},
                {label: '<footer>', value: 'footer'},
              ]}
              onChange={(tagName) =>
                setAttributes({
                  modification: {
                    ...attributes.modification,
                    tagName,
                  },
                })
              }
            />
            <SelectControl
              label="Theme Color"
              value={attributes.modification.colorTheme || ''}
              options={[
                {label: 'Not Selected', value: ''},
                {label: 'dark', value: 'dark'},
                {label: 'light', value: 'light'},
              ]}
              onChange={(colorTheme) =>
                setAttributes({
                  modification: {
                    ...attributes.modification,
                    colorTheme,
                  },
                })
              }
            />
            <SelectControl
              label="Background Color Class"
              value={attributes.modification.backgroundColor || ''}
              options={[
                {label: 'Not Selected', value: ''},
                {label: 'bg-black', value: 'bg-black'},
                {label: 'bg-primary', value: 'bg-primary'},
              ]}
              onChange={(backgroundColor) =>
                setAttributes({
                  modification: {
                    ...attributes.modification,
                    backgroundColor,
                  },
                })
              }
            />
            <SelectControl
              label="Color Text Class"
              value={attributes.modification.textColor || ''}
              options={[
                {label: 'Default', value: ''},
                {label: 'text-white', value: 'text-white'},
                {label: 'text-primary', value: 'text-primary'},
              ]}
              onChange={(textColor) =>
                setAttributes({
                  modification: {
                    ...attributes.modification,
                    textColor,
                  },
                })
              }
            />
          </PanelBody>
        </InspectorControls>
      );

      const renderOutput = (
        <attributes.modification.tagName {...blockProps} {...dataBsThemeAttribute} key="blockControls">
          <InnerBlocks
            renderAppender={
              checkHasChildBlocks(clientId)
                ? undefined
                : () => <InnerBlocks.ButtonBlockAppender/>
            }
          />
        </attributes.modification.tagName>
      );

      return [
        renderControls,
        renderOutput,
      ];
    },

    save: (props) => {
      const {attributes} = props;
      const {className} = useBlockProps.save();

      const {backgroundColor, textColor} = attributes.modification || {};
      const blockClass = `${backgroundColor || ''} ${textColor || ''} ${className}`.trim();
      const dataBsThemeAttribute = attributes.modification.colorTheme
        ? {'data-bs-theme': attributes.modification.colorTheme}
        : {};

      // Create a new object for the attributes, excluding the 'class' attribute if it's empty
      const blockProps = {
        ...dataBsThemeAttribute,
      };

      if (blockClass) {
        blockProps.className = blockClass;
      }

      return (
        <attributes.modification.tagName {...blockProps} >
          <InnerBlocks.Content/>
        </attributes.modification.tagName>
      );
    },
  },
);
