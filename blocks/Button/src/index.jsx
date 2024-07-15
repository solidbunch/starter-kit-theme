import metadata from '../block.json';
import variables from '../../../assets/build/variables.json';

const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, InnerBlocks} = wp.blockEditor;
const {PanelBody, SelectControl, TextControl, CheckboxControl, RadioControl} = wp.components;

const defaultLink = "#";

// Function to generate colorOptions based on theme-color
const generateColorOptions = (themeColors) => {
  const colorOptions = [];
  Object.keys(themeColors).forEach(key => {
    colorOptions.push({label: `btn-${key}`, value: `btn-${key}`});
    colorOptions.push({label: `btn-outline-${key}`, value: `btn-outline-${key}`});
  });
  return colorOptions;
};

const colorOptions = generateColorOptions(variables["theme-colors"]);
const defaultColorOption = colorOptions.length > 0 ? colorOptions[0].value : '';

const sizeOptions = [
  {label: 'btn-lg', value: 'btn-lg'},
  {label: 'btn-sm', value: 'btn-sm'},
];

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const {defaultClass, buttonColor, buttonSize} = attributes.modification || {};
      const blockClass = `${defaultClass || ''} ${buttonColor || defaultColorOption} ${buttonSize || ''}`.trim();

      return {className: blockClass};
    },

    edit: props => {
      const {attributes, setAttributes, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Section styles">
            <RadioControl
              label="Button or Link"
              selected={attributes.modification.tagName || 'button'}
              options={[
                {label: '<a>', value: 'a'},
                {label: '<button>', value: 'button'}
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
            {/* add TextControl for text in button */}
            {attributes.modification.tagName === 'a' && (
              <>
                <TextControl
                  label="Link URL"
                  value={attributes.modification.linkUrl || ''}
                  placeholder="#"
                  onChange={(linkUrl) =>
                    setAttributes({
                      modification: {
                        ...attributes.modification,
                        linkUrl
                      },
                    })
                  }
                />
                <CheckboxControl
                  label="Open in new tab"
                  checked={attributes.modification.openInNewTab || false}
                  onChange={(openInNewTab) =>
                    setAttributes({
                      modification: {
                        ...attributes.modification,
                        openInNewTab,
                      },
                    })
                  }
                />
              </>
            )}
            <TextControl
              label="Button Text"
              value={attributes.modification.buttonText || ''}
              onChange={(buttonText) =>
                setAttributes({
                  modification: {
                    ...attributes.modification,
                    buttonText,
                  },
                })
              }
            />
            <SelectControl
              label="Button Color"
              value={attributes.modification.buttonColor || defaultColorOption}
              options={colorOptions}
              onChange={(buttonColor) =>
                setAttributes({
                  modification: {
                    ...attributes.modification,
                    buttonColor,
                  },
                })
              }
            />
            <SelectControl
              label="Button Size"
              value={attributes.modification.buttonSize || ''}
              options={sizeOptions}
              onChange={(buttonSize) =>
                setAttributes({
                  modification: {
                    ...attributes.modification,
                    buttonSize,
                  },
                })
              }
            />
          </PanelBody>
        </InspectorControls>
      );
      
      const renderOutput = (
        <attributes.modification.tagName {...blockProps} key="blockControls">
          { attributes.modification.buttonText }
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

      const {defaultClass, buttonColor,buttonSize} = attributes.modification || {};
      const blockClass = `${defaultClass || ''} ${buttonColor || defaultColorOption} ${buttonSize || ''} ${className}`.trim();
      // Create a new object for the attributes, excluding the 'class' attribute if it's empty
      const blockProps = {};
      if (blockClass) {
        blockProps.className = blockClass;
      }
      let targetValue = null;
      let relValue = null;
    
      if (attributes.modification.tagName === 'a' && attributes.modification.openInNewTab === true) {
        targetValue = '_blank';
        relValue = 'noopener noreferrer';
      }
      return (
       
        <attributes.modification.tagName {...blockProps} key="blockControls"
          href={attributes.modification.tagName === 'a' ? (attributes.modification.linkUrl || defaultLink) : null}
          target={targetValue}
          rel={relValue}
        >
          { attributes.modification.buttonText }
          <InnerBlocks.Content/>
        </attributes.modification.tagName>
      );
    },
  },
);
