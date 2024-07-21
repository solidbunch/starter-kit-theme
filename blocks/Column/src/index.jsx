/**
 * Block dependencies
 */

import metadata from '../block.json';
import variables from '../../../assets/build/variables.json';
/**
 * Internal block libraries
 */

const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, InnerBlocks} = wp.blockEditor;
const {PanelBody, SelectControl, RangeControl, CheckboxControl} = wp.components;

const numberOfGrid = 12;

function checkHasChildBlocks(clientId) {
  const {getBlockOrder} = wp.data.select('core/block-editor');
  return getBlockOrder(clientId).length > 0;
}
// Function to initialize size attributes based on grid-breakpoints
function initializeSizeAttributes() {
  const sizeAttributes = {};
  const breakpoints = variables['grid-breakpoints'];

  Object.keys(breakpoints).forEach((breakpoint, index) => {
    if (index === 0) {
      sizeAttributes[breakpoint] = {mod: "default"};
    } else {
      sizeAttributes[breakpoint] = {};
    }
  });

  return sizeAttributes;
}

function generateSizeClasses(attributes) {
  const {size} = attributes;
  const classes = [];
  const breakpoints = Object.keys(variables['grid-breakpoints']);
  const firstBreakpoint = breakpoints[0]; // first breakpoint  in grid

  Object.keys(size).forEach((breakpoint) => {
    const {mod, valueRange} = size[breakpoint];
    if (breakpoint === firstBreakpoint) {
      if (mod === 'default') {
        classes.push('col');
      } else if (mod === 'auto') {
        classes.push('col-auto');
      } else if (mod === 'custom') {
        classes.push(valueRange !== undefined ? `col-${valueRange}` : 'col-6');
      }
    } else if (mod === 'default') {
      classes.push(`col-${breakpoint}`);
    } else if (mod === 'auto') {
      classes.push(`col-${breakpoint}-auto`);
    } else if (mod === 'custom') {
      classes.push(valueRange !== undefined ? `col-${breakpoint}-${valueRange}` : `col-${breakpoint}-6`);
    }
  });

  return classes.join(' ');
}
//generate Select Options for custom width
function generateSelectOptions(breakpoint, index, valueRange) {
  return [
    {label: index === 0 ? 'default (.col)' : `default (.col-${breakpoint})`, value: 'default'},
    {label: index === 0 ? 'auto (.col-auto)' : `auto (.col-${breakpoint}-auto)`, value: 'auto'},
    {label: index === 0 ? `custom (.col-${valueRange || 6})` : `custom (.col-${breakpoint}-${valueRange || 6})`, value: "custom"},
  ];
}

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {

      const blockClass = generateSizeClasses(attributes);
      return {className: blockClass};
    },
    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
      // Initialize size attributes if not already initialized
      if (!attributes.size || Object.keys(attributes.size).length === 0) {
        setAttributes({size: initializeSizeAttributes()});
      }
      const blockProps = useBlockProps({
        className: [className],
      });

      const renderControls = (
        <InspectorControls key="settings">
          <PanelBody title="Column width" initialOpen={false}>

            {Object.keys(attributes.size).map((breakpoint, index) => (

              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint ${attributes.size[breakpoint].mod ? 'active' : ''}`}>
                <CheckboxControl
                  label={`Enable ${breakpoint}`}
                  checked={
                    attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== ""
                  }
                  onChange={(isChecked) => {
                    const sizeObject = {...attributes.size};
                    if (isChecked) {
                      sizeObject[breakpoint] = {...sizeObject[breakpoint], mod: "default"};
                    } else {
                      sizeObject[breakpoint] = {...sizeObject[breakpoint], mod: ""};
                    }
                    setAttributes({...attributes, size: sizeObject});
                  }}
                />
                {attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== "" && (
                  <>
                    <SelectControl
                      label={`Size ${breakpoint}`}
                      value={attributes.size[breakpoint].mod}
                      options={generateSelectOptions(breakpoint, index, attributes.size[breakpoint].valueRange)}
                      onChange={(value) => {
                        const sizeObject = {...attributes.size};

                        sizeObject[breakpoint] = {...sizeObject[breakpoint], mod: value};
                        setAttributes({...attributes, size: sizeObject});
                      }}
                    />
                    {attributes.size[breakpoint].mod === "custom" &&
                      <RangeControl
                        label="Width"
                        value={
                          (() => {
                            if (attributes.size[breakpoint]?.valueRange !== undefined) {
                              return attributes.size[breakpoint].valueRange;
                            }
                            return attributes.size[breakpoint].valueRange = 6;
                          })()
                        }
                        onChange={value => {
                          const sizeObject = {...attributes.size};
                          sizeObject[breakpoint] = {...sizeObject[breakpoint], valueRange: value};
                          setAttributes({...attributes, size: sizeObject});
                        }}
                        min={1}
                        max={numberOfGrid}
                        {...props}
                      />
                    }
                  </>
                )}
              </div>
            ))}
          </PanelBody>
        </InspectorControls>
      );

      const renderOutput = (
        <div {...blockProps} key="blockControls">
          <InnerBlocks
            renderAppender={
              checkHasChildBlocks(clientId)
                ? undefined
                : () => <InnerBlocks.ButtonBlockAppender />
            }
          />
        </div>
      );

      return [
        renderControls,
        renderOutput,
      ];
    },
    save: props => {
      const {attributes} = props;

      const blockClass = generateSizeClasses(attributes);

      const blockProps = useBlockProps.save({
        className: blockClass
      });

      return (
        <div {...blockProps}>
          <InnerBlocks.Content />
        </div>
      );
    },
  }
);
