

const {addFilter} = wp.hooks;
const {createHigherOrderComponent} = wp.compose;
const { InspectorControls, useBlockProps, InnerBlocks } = wp.blockEditor;
const { PanelBody, SelectControl, RangeControl, CheckboxControl } = wp.components;
// const { Fragment } = wp.element;

const numberOfGrid = 5;

const spacers = ['m', 'p'];
const spacersName = ['t', 'b', 'e', 's'];

// remove Restricted Classes
function removeRestrictedClasses(inputStr, excludeArray) {
  // Split the string into words
  const words = inputStr.split(/\s+/);
  // Remove matches from the list of words
  const filteredWords = words.filter(word => !excludeArray.includes(word));
  return filteredWords.join(' ');
}

// add classes
function generateClasses(attributes, numberOfGrid) {
  const { size, modification } = attributes;
  const classes = [modification]; // Начинаем с класса modification (container)

  Object.values(size).forEach((item) => {
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

const withCustomOption = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    const { attributes, setAttributes, clientId, className }= props;
    if (props.name.startsWith('starter-kit/')) {
      return (
        
        <>
          <BlockEdit {...props} />
          <InspectorControls key="controls">
          <PanelBody title="Spacers from EDITOR file">
            {Object.keys(attributes.size).map((breakpoint) => (

              <div key={breakpoint} title={`breakpoint settings - ${breakpoint}`} className={`box_breakpoint ${attributes.size[breakpoint].valueRange !== undefined && attributes.size[breakpoint].valueRange !== '' ? 'active' : ''}`}>
                <CheckboxControl
                  label={`Enable ${breakpoint}`}
                  checked={
                    attributes.size && attributes.size[breakpoint].valueRange !== undefined && attributes.size[breakpoint].valueRange !== ""
                  }
                  onChange={(isChecked) => {
                    const sizeObject = { ...attributes.size };
                    if (isChecked) {
                      sizeObject[breakpoint] = { ...sizeObject[breakpoint], valueRange: {} };
                    } else {
                      // sizeObject[breakpoint] = { ...sizeObject[breakpoint], valueRange: "" };
                      delete sizeObject[breakpoint].valueRange;
                    }
                    setAttributes({ ...attributes, size: sizeObject });
                  }}
                />

                {attributes.size && attributes.size[breakpoint].valueRange !== undefined && attributes.size[breakpoint].valueRange !== "" && (
                  <>
                    {spacers.map((spacer, index) => (
                      spacersName.map((spacerName, innerIndex) => {
                        const uniqueKey = `${spacer}${spacerName}-${breakpoint}`;
                        const maxGrid = spacer === 'p' ? numberOfGrid : numberOfGrid + 1;

                        return (
                          <RangeControl
                            key={uniqueKey}
                            allowReset={false}
                            label={
                              (() => {
                                let labelValue;
                                if (attributes.size[breakpoint]?.valueRange?.[uniqueKey] !== undefined) {
                                  if (attributes.size[breakpoint].valueRange[uniqueKey] === (numberOfGrid + 1)) {
                                    labelValue = "auto";
                                  } else {
                                    labelValue = attributes.size[breakpoint].valueRange[uniqueKey];
                                  }
                                } else {
                                  labelValue = "none";
                                }
                                return `${uniqueKey}-${labelValue}`;
                              })()
                            }


                            value={
                              (() => {
                                if (attributes.size[breakpoint]?.valueRange?.[uniqueKey] !== undefined) {
                                  return attributes.size[breakpoint].valueRange[uniqueKey];
                                }
                                return -1;
                              })()
                            }

                            onChange={value => {
                              const sizeObject = { ...attributes.size };

                              if (value === -1) {

                                delete sizeObject[breakpoint].valueRange[uniqueKey];
                              } else {

                                sizeObject[breakpoint] = {
                                  ...sizeObject[breakpoint],
                                  valueRange: {
                                    ...sizeObject[breakpoint].valueRange,

                                    [uniqueKey]: value,
                                  },
                                };
                              }
                              setAttributes({ ...attributes, size: sizeObject });
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
}, 'withCustomOption');

addFilter(
  'editor.BlockEdit',
  'starter_kit/add-spacer-option',
  withCustomOption,
);