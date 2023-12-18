/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const { registerBlockType } = wp.blocks;
const { useSelect } = wp.data;
const { InspectorControls, useBlockProps, InnerBlocks } = wp.blockEditor;
const { PanelBody, SelectControl, RangeControl, CheckboxControl } = wp.components;
const numberOfGrid = 5;
const spacers = ['m', 'p'];
const spacersName = ['t', 'b', 'e', 's'];
registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const { size } = attributes;
      const classes = [];
      Object.values(size).forEach((item) => {
        if (item.valueRange) {
          Object.keys(item.valueRange).forEach(i => {
            classes.push(`${i}-${item.valueRange[i]}`);
          });
        }
      });
      return { className: classes.join(' ') };
    },
    edit: props => {
      const { attributes, setAttributes, clientId } = props;

      const blockProps = useBlockProps();

      const { hasChildBlocks } = useSelect((select) => {
        const { getBlockOrder } = select('core/block-editor');

        return {
          hasChildBlocks: getBlockOrder(clientId).length > 0,
        };
      });

      return [
        <InspectorControls key="controls">
          <PanelBody title="Container responsive type">
            <SelectControl
              label="Container width"
              value={attributes.modification}
              options={[
                // ToDo - add breakpoints options
                //{label: 'container', value: 'container'},
                //{label: 'container-sm', value: 'container-sm'},
                //{label: 'container-md', value: 'container-md'},
                //{label: 'container-lg', value: 'container-lg'},
                //{label: 'container-xl', value: 'container-xl'},
                { label: 'Fixed width', value: 'container-xxl' },
                { label: 'Full width', value: 'container-fluid' }
              ]}
              onChange={(modification) => setAttributes({ modification })}
            />
          </PanelBody>
        </InspectorControls>,
        <InspectorControls key="controls">
          <PanelBody title="Spacers">
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
                            max={numberOfGrid + 1}
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
        </InspectorControls>,
        <div {...blockProps} key="blockControls">
          <div className={attributes.modification}>
            <InnerBlocks
              renderAppender={
                hasChildBlocks
                  ? undefined
                  : () => <InnerBlocks.ButtonBlockAppender />
              }
            />
          </div>
        </div>
      ];
    },

    save: props => {
      const { attributes } = props;

      const combinedClass = [];

      if (attributes.modification) {
        combinedClass.push(attributes.modification);
      }

      if (attributes.className) {
        combinedClass.push(attributes.className);
      }

      const classNameString = combinedClass.join(" ");

      return (
        <div className={classNameString}>
          <InnerBlocks.Content />
        </div>
      );
    }
  });