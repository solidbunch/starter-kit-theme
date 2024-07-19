/**
 * Block dependencies
 */
import metadata from '../block.json';
import variables from '../../../assets/build/variables.json';
/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;

const {InspectorControls, useBlockProps, InnerBlocks, useInnerBlocksProps} = wp.blockEditor;
const {PanelBody, SelectControl, CheckboxControl} = wp.components;
const blocksAllowed = ['starter-kit/column'];
const blockTemplate = [['starter-kit/column'], ['starter-kit/column']];

const gridBreakpoints = variables['grid-breakpoints'];

// Initialize aligmentProperties with empty objects for each breakpoint
const initializeAligmentProperties = () => {
  const aligmentProperties = {};
  Object.keys(gridBreakpoints).forEach(breakpoint => {
    aligmentProperties[breakpoint] = {};
  });
  return aligmentProperties;
};

function getClasses(attributes) {
  const {modification, aligmentProperties} = attributes;
  const classes = [modification]; // Начинаем с класса modification (row)

  Object.keys(aligmentProperties).forEach((breakpoint) => {
    const {justifyContent, alignItems} = aligmentProperties[breakpoint];
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
      // Initialize aligmentProperties if not already initialized
      if (!attributes.aligmentProperties || Object.keys(attributes.aligmentProperties).length === 0) {
        setAttributes({aligmentProperties: initializeAligmentProperties()});
      }
      const blockProps = useBlockProps({
        className: [className],
      });
      const renderControls = (
        <InspectorControls key="settings">
          <PanelBody title="alignment x" initialOpen={false}>
            {Object.keys(attributes.aligmentProperties).map((breakpoint) => (

              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint `}>
                <CheckboxControl
                  label={`${breakpoint} alignment`}
                  checked={
                    attributes.aligmentProperties && attributes.aligmentProperties[breakpoint].justifyContent !== undefined && attributes.aligmentProperties[breakpoint].justifyContent !== ""
                  }
                  onChange={(isChecked) => {
                    const propObject = {...attributes.aligmentProperties};
                    if (isChecked) {
                      propObject[breakpoint] = {...propObject[breakpoint], justifyContent: "start"};
                    } else {
                      propObject[breakpoint] = {...propObject[breakpoint], justifyContent: ""};
                    }
                    setAttributes({...attributes, aligmentProperties: propObject});

                  }}
                />

                {attributes.aligmentProperties && attributes.aligmentProperties[breakpoint].justifyContent !== undefined && attributes.aligmentProperties[breakpoint].justifyContent !== "" && (
                  <SelectControl
                    label={`Size ${breakpoint}`}
                    value={attributes.aligmentProperties[breakpoint].justifyContent}
                    options={attributes.justifyContent.map((value) => ({
                      label: value,
                      value,
                    }))}
                    onChange={(value) => {
                      const propObject = {...attributes.aligmentProperties};
                      propObject[breakpoint] = {...propObject[breakpoint], justifyContent: value};
                      setAttributes({...attributes, aligmentProperties: propObject});
                    }}
                  />

                )}
              </div>
            ))}

          </PanelBody>
          <PanelBody title="alignment Y" initialOpen={false}>
            {Object.keys(attributes.aligmentProperties).map((breakpoint) => (

              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint `}>
                <CheckboxControl
                  label={`${breakpoint} alignment`}
                  checked={
                    attributes.aligmentProperties && attributes.aligmentProperties[breakpoint].alignItems !== undefined && attributes.aligmentProperties[breakpoint].alignItems !== ""
                  }
                  onChange={(isChecked) => {
                    const propObject = {...attributes.aligmentProperties};
                    if (isChecked) {
                      propObject[breakpoint] = {...propObject[breakpoint], alignItems: "start"};
                    } else {
                      propObject[breakpoint] = {...propObject[breakpoint], alignItems: ""};
                    }
                    setAttributes({...attributes, aligmentProperties: propObject});

                  }}
                />

                {attributes.aligmentProperties && attributes.aligmentProperties[breakpoint].alignItems !== undefined && attributes.aligmentProperties[breakpoint].alignItems !== "" && (
                  <SelectControl
                    label={`Size ${breakpoint}`}
                    value={attributes.aligmentProperties[breakpoint].alignItems}
                    options={attributes.alignItems.map((value) => ({
                      label: value,
                      value,
                    }))}
                    onChange={(value) => {
                      const propObject = {...attributes.aligmentProperties};
                      propObject[breakpoint] = {...propObject[breakpoint], alignItems: value};
                      setAttributes({...attributes, aligmentProperties: propObject});
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
