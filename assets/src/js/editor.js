const {addFilter} = wp.hooks;
const {createHigherOrderComponent} = wp.compose;
const {InspectorControls} = wp.blockEditor;
const {PanelBody, RangeControl, CheckboxControl} = wp.components;
// const { Fragment } = wp.element;

const numberOfGrid = 5;
// const excludeClasses=['wp-block','wp-block-starter-kit-container'];

const spacersTypes = ['m', 'p'];
const spacersDirection = ['t', 'b', 'e', 's'];

// remove Restricted Classes
// function removeRestrictedClasses(inputStr, excludeArray) {
//   // Split the string into words
//   const words = inputStr.split(/\s+/);
//   // Remove matches from the list of words
//   const filteredWords = words.filter(word => !excludeArray.includes(word));
//   return filteredWords.join(' ');
// }

// add classes
function generateClasses(attributes) {
  const classes = []; // Начинаем с класса modification (container)

  Object.values(attributes.spacers).forEach((item) => {
    if (item.valueRange) {
      Object.keys(item.valueRange).forEach(i => {
        const modifiedValue = item.valueRange[i] === (numberOfGrid + 1) ? 'auto' : item.valueRange[i];
        const modifiedClass = `${i}-${modifiedValue}`.replace('-xs', '');
        classes.push(modifiedClass);
      });
    }
  });

  return classes.join(' ');
}

const editSpacerClasses = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    
    const {attributes, setAttributes} = props;
    if (props.name.startsWith('starter-kit/')) {

      return (
        
        <>
          
          <BlockEdit {...props} />
          <InspectorControls key="controls">
            <PanelBody title="Spacers from EDITOR file">
              {Object.keys(attributes.spacers).map((breakpoint) => (
                
                <div key={breakpoint} title={`breakpoint settings - ${breakpoint}`} className={`box_breakpoint ${attributes.spacers[breakpoint].valueRange !== undefined && attributes.spacers[breakpoint].valueRange !== '' ? 'active' : ''}`}>
                  
                  <CheckboxControl
                    label={`Enable ${breakpoint}`}
                    checked={
                      attributes.spacers && attributes.spacers[breakpoint].valueRange !== undefined && attributes.spacers[breakpoint].valueRange !== ""
                    }
                    onChange={(isChecked) => {
                      const spacersObject = {...attributes.spacers};
                      if (isChecked) {
                        spacersObject[breakpoint] = {...spacersObject[breakpoint], valueRange: {}};
                      } else {
                        // spacersObject[breakpoint] = { ...spacersObject[breakpoint], valueRange: "" };
                        delete spacersObject[breakpoint].valueRange;
                      }
                      setAttributes({...attributes, spacers: spacersObject});
                    }}
                  />
                  
                  {attributes.spacers && attributes.spacers[breakpoint].valueRange !== undefined && attributes.spacers[breakpoint].valueRange !== "" && (
                    <>
                      {spacersTypes.map((spacerType) => (
                        spacersDirection.map((spacerDirection) => {
                          const uniqueKey = `${spacerType}${spacerDirection}-${breakpoint}`;
                          const maxGrid = spacerType === 'p' ? numberOfGrid : numberOfGrid + 1;

                          return (
                            <RangeControl
                              key={uniqueKey}
                              allowReset={false}
                              label={
                                (() => {
                                  let labelValue;
                                  if (attributes.spacers[breakpoint]?.valueRange?.[uniqueKey] !== undefined) {
                                    if (attributes.spacers[breakpoint].valueRange[uniqueKey] === (numberOfGrid + 1)) {
                                      labelValue = "auto";
                                    } else {
                                      labelValue = attributes.spacers[breakpoint].valueRange[uniqueKey];
                                    }
                                  } else {
                                    labelValue = "none";
                                  }
                                  return `${uniqueKey}-${labelValue}`;
                                })()
                              }

                              value={
                                (() => {
                                  if (attributes.spacers[breakpoint]?.valueRange?.[uniqueKey] !== undefined) {
                                    return attributes.spacers[breakpoint].valueRange[uniqueKey];
                                  }
                                  return -1;
                                })()
                              }

                              onChange={value => {
                                const spacersObject = {...attributes.spacers};

                                if (value === -1) {

                                  delete spacersObject[breakpoint].valueRange[uniqueKey];
                                } else {

                                  spacersObject[breakpoint] = {
                                    ...spacersObject[breakpoint],
                                    valueRange: {
                                      ...spacersObject[breakpoint].valueRange,

                                      [uniqueKey]: value,
                                    },
                                  };
                                }
                                setAttributes({...attributes, spacers: spacersObject});
                              }}

                              min={-1}
                              max={maxGrid}
                              withInputField={false}
                              {...props}
                            />
                          );
                        })
                      ))}
                    </>
                  )}
                  
                </div>
              ))}

            </PanelBody>
          </InspectorControls>
        </>
        
      );
    }
    return <BlockEdit {...props} />;
  };
}, 'editSpacerClasses');

const modifyBlockWrapperClass = (settings, name) => {
  // Check if the block is one of your custom blocks
  if (name.startsWith('starter-kit/')) {
    const originalGetEditWrapperProps = settings.getEditWrapperProps;

    const spacerAttributes = {
      spacers: {
        type: 'object',
        default: {
          "xs": {},
          "sm": {},
          "md": {},
          "lg": {},
          "xl": {},
          "xxl": {}
        },
      },
    };

    settings.attributes = {
      ...settings.attributes,
      ...spacerAttributes,
    };

    settings.getEditWrapperProps = (attributes) => {
      // Call original getEditWrapperProps if it exists
      let props = originalGetEditWrapperProps ? originalGetEditWrapperProps(attributes) : {};

      // Add or modify the className
      props.className = generateClasses(attributes);
      return props;
    };
  }

  return settings;
};

// function addSpacerAttribute(settings, name) {
//   // Check if the block is from the starter-kit
//   if (name.startsWith('starter-kit/')) {
//     // Define your custom attribute
//     const spacerAttributes = {
//       spacers: {
//         type: 'string',
//         default: {
//           "xs": {},
//           "sm": {},
//           "md": {},
//           "lg": {},
//           "xl": {},
//           "xxl": {}
//         },
//       },
//     };

//     // Merge the custom attribute with existing attributes
//     settings.attributes = {
//       ...settings.attributes,
//       ...spacerAttributes,
//     };
//   }

//   return settings;
// }

function addSpacersClasses(props, blockClasses) {
  
  const spacersClasses = generateClasses(props.attributes);
  blockClasses = blockClasses ? blockClasses + ' ' + spacersClasses : spacersClasses;

  return blockClasses;
}
addFilter(
  'blocks.registerBlockType',
  'starter_kit/edit-spacers-classes-wrapper',
  modifyBlockWrapperClass
);
addFilter(
  'editor.BlockEdit',
  'starter_kit/edit-spacers-classes',
  editSpacerClasses,
);
/*addFilter(
  'blocks.getSaveContent.extraProps',
  'starter_kit/save-spacers-classes',
  saveSpacerClasses
);*/

addFilter(
  'starter_kit.updateBlockClasses',
  'starter_kit/add-spacers-classes',
  addSpacersClasses
);

// addFilter(
//   'blocks.registerBlockType',
//   'starter_kit/add-spacers-attribute',
//   addSpacerAttribute
// );

