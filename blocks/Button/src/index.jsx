import metadata from '../block.json';

const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, InnerBlocks} = wp.blockEditor;
const {PanelBody, SelectControl, TextControl, CheckboxControl, RadioControl} = wp.components;

const defaultLink = "#";
const colorOptions = [
  {label: 'btn-primary', value: 'btn-primary'},
  {label: 'btn-secondary', value: 'btn-secondary'},
  {label: 'btn-success', value: 'btn-success'},
  {label: 'btn-danger', value: 'btn-danger'},
  {label: 'btn-warning', value: 'btn-warning'},
  {label: 'btn-info', value: 'btn-info'},
  {label: 'btn-light', value: 'btn-light'},
  {label: 'btn-link', value: 'btn-link'},
  {label: 'btn-outline-secondary', value: 'btn-outline-secondary'},
];
const sizeOptions = [
  {label: 'default', value: ''},
  {label: 'btn-lg', value: 'btn-lg'},
  {label: 'btn-sm', value: 'btn-sm'},
];

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const {defaultClass, buttonColor, buttonSize} = attributes.modification || {};
      const blockClass = `${defaultClass || ''} ${buttonColor || 'btn-primary'} ${buttonSize || ''}`.trim();

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
              value={attributes.modification.buttonColor || 'btn-primary'}
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
      const blockClass = `${defaultClass || ''} ${buttonColor || 'btn-primary'} ${buttonSize || ''} ${className}`.trim();
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
