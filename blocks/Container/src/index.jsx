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
const numberOfGrid = 6;
const spacers = ['m', 'p'];
const spacersName = ['t', 'b', 'e', 's'];
registerBlockType(
  metadata,
  {
    edit: props => {
      const { attributes, setAttributes, clientId } = props;

      const blockProps = useBlockProps();

      const { hasChildBlocks } = useSelect((select) => {
        const { getBlockOrder } = select('core/block-editor');

        return {
          hasChildBlocks: getBlockOrder(clientId).length > 0,
        };
      });
      console.log(attributes);
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

              <div key={breakpoint} title={`breakpoint settings - ${breakpoint}`} className={`box_breakpoint ${attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== '' ? 'active' : ''}`}>
                <CheckboxControl
                  label={`Enable ${breakpoint}`}
                  checked={
                    attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== ""
                  }
                  onChange={(isChecked) => {
                    const sizeObject = { ...attributes.size };
                    if (isChecked) {
                      sizeObject[breakpoint] = { ...sizeObject[breakpoint], mod: "default" };
                    } else {
                      sizeObject[breakpoint] = { ...sizeObject[breakpoint], mod: "" };
                    }
                    setAttributes({ ...attributes, size: sizeObject });
                  }}
                />

                {attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== "" && (
                  <>
                    {spacers.map((spacer, index) => (
                      spacersName.map((spacerName, innerIndex) => {
                        const uniqueKey = `${spacer}${spacerName}-${breakpoint}`;
                        return (
                          <RangeControl
                            key={uniqueKey}
                            label={`${spacer}${spacerName}`}
                            value={
                              (() => {
                                if (attributes.size[breakpoint]?.valueRange !== undefined) {
                                  return attributes.size[breakpoint].valueRange[uniqueKey] || 0;
                                }
                                return attributes.size[breakpoint].valueRange = { [uniqueKey]: 0 };
                              })()
                            }
                            onChange={value => {
                              const sizeObject = { ...attributes.size };
                              sizeObject[breakpoint] = {
                                ...sizeObject[breakpoint],
                                valueRange: {
                                  ...sizeObject[breakpoint].valueRange,
                                  [uniqueKey]: value,
                                },
                              };
                              setAttributes({ ...attributes, size: sizeObject });
                            }}
                            min={0}
                            max={numberOfGrid}
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