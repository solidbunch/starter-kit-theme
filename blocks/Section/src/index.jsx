/**
 * Block dependencies
 */

import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {useSelect} = wp.data;
const {InspectorControls, useBlockProps, InnerBlocks} = wp.blockEditor;
const {PanelBody, SelectControl} = wp.components;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const {backgroundColor, textColor} = attributes.modification || {};
    
      // Комбинируем значения backgroundColor и textColor в одну строку
      const blockClass = `${backgroundColor || ''} ${textColor || ''}`.trim();
    
      return {className: blockClass};
    },
    
    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });
      const {hasChildBlocks} = useSelect((select) => {
        const {getBlockOrder} = select('core/block-editor');
    
        return {
          hasChildBlocks: getBlockOrder(clientId).length > 0,
        };
      });
      const dataBsThemeAttribute = attributes.modification.colorTheme ? {'data-bs-theme': attributes.modification.colorTheme} : {};
      return [
        <InspectorControls key="controls">
          <PanelBody title="Section styles">
            <h1>Section</h1>
            <SelectControl
              label="Select Tag"
              value={attributes.modification.tagName || 'section'} // Устанавливаем значение по умолчанию, если не выбрано
              options={[
                {label: '<section>', value: 'section'},
                {label: '<div>', value: 'div'},
                {label: '<article>', value: 'article'},
                {label: '<aside>', value: 'aside'},
                {label: '<main>', value: 'main'},
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
                {label: 'blue', value: 'blue'},
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
                {label: 'Not Selected', value: ''},
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
        </InspectorControls>,
        <attributes.modification.tagName {...blockProps} {...dataBsThemeAttribute} key="blockControls">
          <InnerBlocks
            renderAppender={
              hasChildBlocks
                ? undefined
                : () => <InnerBlocks.ButtonBlockAppender />
            }
          />
        </attributes.modification.tagName>
      ];
    },
    
    save: (props) => {
      const {attributes} = props;
      const {backgroundColor, textColor} = attributes.modification || {};
      const blockClass = `${backgroundColor || ''} ${textColor || ''}`.trim();
      const dataBsThemeAttribute = attributes.modification.colorTheme ? {'data-bs-theme': attributes.modification.colorTheme} : {};
      const blockProps = useBlockProps.save({
        className: blockClass,
        ...dataBsThemeAttribute,
      });
    
      return (
        <attributes.modification.tagName {...blockProps} >
          <InnerBlocks.Content />
        </attributes.modification.tagName>
      );
    },    
  }
);
