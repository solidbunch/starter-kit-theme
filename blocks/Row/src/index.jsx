/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;

const {InspectorControls, useBlockProps, InnerBlocks, useInnerBlocksProps} = wp.blockEditor;
const {PanelBody, SelectControl, CheckboxControl} = wp.components;
const blocksAllowed = ['starter-kit/column'];
const blockTemplate = [['starter-kit/column'], ['starter-kit/column']];

function getClasses(attributes) {
  const {modification, properties} = attributes;
  const classes = [modification]; // Начинаем с класса modification (row)

  Object.keys(properties).forEach((breakpoint) => {
    const {justifyContent, alignItems} = properties[breakpoint];
    const breakpointSuffix = breakpoint === "xs" ? "" : `-${breakpoint}`;

    if (justifyContent) {
      classes.push(`justify-content${breakpointSuffix}-${justifyContent}`);
    }

    if (alignItems) {
      classes.push(`align-items${breakpointSuffix}-${alignItems}`);
    }
  });
  return classes.join(' ');
}

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {

      return {className: getClasses(attributes)};
    },
    edit: props => {

      const {attributes, setAttributes, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      const renderControls = (
        <InspectorControls key="settings">
          <PanelBody title="alignment x" initialOpen={false}>
            {Object.keys(attributes.properties).map((breakpoint) => (

              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint `}>
                <CheckboxControl
                  label={`${breakpoint} alignment`}
                  checked={
                    attributes.properties && attributes.properties[breakpoint].justifyContent !== undefined && attributes.properties[breakpoint].justifyContent !== ""
                  }
                  onChange={(isChecked) => {
                    const propObject = {...attributes.properties};
                    if (isChecked) {
                      propObject[breakpoint] = {...propObject[breakpoint], justifyContent: "start"};
                    } else {
                      propObject[breakpoint] = {...propObject[breakpoint], justifyContent: ""};
                    }
                    setAttributes({...attributes, properties: propObject});

                  }}
                />

                {attributes.properties && attributes.properties[breakpoint].justifyContent !== undefined && attributes.properties[breakpoint].justifyContent !== "" && (
                  <SelectControl
                    label={`Size ${breakpoint}`}
                    value={attributes.properties[breakpoint].justifyContent}
                    options={attributes.justifyContent.map((value) => ({
                      label: value,
                      value,
                    }))}
                    onChange={(value) => {
                      const propObject = {...attributes.properties};
                      propObject[breakpoint] = {...propObject[breakpoint], justifyContent: value};
                      setAttributes({...attributes, properties: propObject});
                    }}
                  />

                )}
              </div>
            ))}

          </PanelBody>
          <PanelBody title="alignment Y" initialOpen={false}>
            {Object.keys(attributes.properties).map((breakpoint) => (

              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint `}>
                <CheckboxControl
                  label={`${breakpoint} alignment`}
                  checked={
                    attributes.properties && attributes.properties[breakpoint].alignItems !== undefined && attributes.properties[breakpoint].alignItems !== ""
                  }
                  onChange={(isChecked) => {
                    const propObject = {...attributes.properties};
                    if (isChecked) {
                      propObject[breakpoint] = {...propObject[breakpoint], alignItems: "start"};
                    } else {
                      propObject[breakpoint] = {...propObject[breakpoint], alignItems: ""};
                    }
                    setAttributes({...attributes, properties: propObject});

                  }}
                />

                {attributes.properties && attributes.properties[breakpoint].alignItems !== undefined && attributes.properties[breakpoint].alignItems !== "" && (
                  <SelectControl
                    label={`Size ${breakpoint}`}
                    value={attributes.properties[breakpoint].alignItems}
                    options={attributes.alignItems.map((value) => ({
                      label: value,
                      value,
                    }))}
                    onChange={(value) => {
                      const propObject = {...attributes.properties};
                      propObject[breakpoint] = {...propObject[breakpoint], alignItems: value};
                      setAttributes({...attributes, properties: propObject});
                    }}
                  />

                )}
              </div>
            ))}

          </PanelBody>
        </InspectorControls>
      );

      // Use innerBlocksProps instead of <InnerBlocks> to prevent render inner wrapper div inside row
      const innerBlocksProps = useInnerBlocksProps(blockProps, {
        allowedBlocks: blocksAllowed,
        template: blockTemplate,
        templateLock: false
      });

      const renderOutput = (
        <div {...innerBlocksProps} key="blockControls">
        </div>
      );

      return [
        renderControls,
        renderOutput,
      ];
    },

    save: props => {
      const {attributes} = props;

      const blockProps = useBlockProps.save({
        className: getClasses(attributes)
      });

      return (
        <div {...blockProps}>
          <InnerBlocks.Content />
        </div>
      );
    }

  });
