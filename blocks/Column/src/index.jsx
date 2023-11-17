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

// const bootstrapBreakpoints = ['xs', 'sm', 'md', 'lg', 'xl', 'xxl'];
const numberOfGrid = 12;

registerBlockType(
  metadata,
  {
    // getEditWrapperProps(attributes) {
    //   const data = {
    //     'data-col-lg': attributes.size ?? 'default'
    //   };

    //   if (attributes.size === 'custom') {
    //     data['data-col-lg'] = attributes.modification.lg ?? 6;
    //   }

    //   return data;
    // },


    getEditWrapperProps(attributes) {
      const data = {
        'data-col-sm': attributes.size?.sm.valueRange || 'default',
        'data-col-lg': attributes.size?.lg.valueRange || 'default',
        'data-col-sm': attributes.size?.sm.valueRange || 'default',
      };

      // if (attributes.size.xl === 'custom') {
      //   data['data-col-lg'] = attributes.modification.lg ?? 6;
      // }

      return data;
    },

    edit: props => {
      const { attributes, setAttributes, clientId, className } = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      const { hasChildBlocks } = useSelect((select) => {
        const { getBlockOrder } = select('core/block-editor');

        return {
          hasChildBlocks: getBlockOrder(clientId).length > 0,
        };
      });

      return [
        <InspectorControls key="settings">
          <PanelBody title="Column settings">


            {Object.keys(attributes.size).map((breakpoint) => (

              <div key={breakpoint} title={`Column settings - ${breakpoint}`}>

                <CheckboxControl
                  label={`Enable ${breakpoint}`}
                  // checked={attributes.size && attributes.size[breakpoint]}
                  checked={
                    attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== ""
                    // (() => {
                    //   console.log(attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== "");
                    //   console.log('etc');
                    //   return attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== ""
                    // })()
                  }

                  onChange={(isChecked) => {
                    const sizeObject = { ...attributes.size };
                    // sizeObject[breakpoint] = isChecked;
                    if (isChecked) {
                      sizeObject[breakpoint].mod = "default";
                    } else {
                      sizeObject[breakpoint].mod = "";
                    }

                    setAttributes({ ...attributes, size: sizeObject });
                    // console.log();
                  }}
                />
                {attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== "" && (
                  <>
                    <SelectControl
                      label="Size"
                      value={attributes.size[breakpoint].mod}
                      options={[
                        { label: 'default', value: 'default' },
                        { label: 'auto', value: 'auto' },
                        { label: 'custom', value: "custom" },
                      ]}
                      onChange={(value) => {
                        const sizeObject = { ...attributes.size };


                        sizeObject[breakpoint].mod = value;
                        setAttributes({ ...attributes, size: sizeObject });
                        // console.log(Number(attributes.size[breakpoint]));
                      }}
                    />
                    {attributes.size[breakpoint].mod === "custom" &&
                      <RangeControl

                        label="Width"
                        value={
                          (() => {
                            if (attributes.size[breakpoint]?.valueRange !== undefined) {
                              return attributes.size[breakpoint].valueRange;
                            } else {
                              return attributes.size[breakpoint].valueRange = 6;
                            }
                          })()

                        }

                        onChange={value => {


                          const sizeObject = { ...attributes.size };
                          sizeObject[breakpoint].valueRange = value;
                          // console.log(sizeObject[breakpoint]);
                          // console.log(attributes.size);
                          setAttributes({ ...attributes, size: sizeObject });
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


        </InspectorControls>,
        <div {...blockProps} key="blockControls">
          <InnerBlocks
            renderAppender={
              hasChildBlocks
                ? undefined
                : () => <InnerBlocks.ButtonBlockAppender />
            }
          />
        </div>
      ];
    },
    // {console.log(attributes.size.xs.mod)}
    // {console.log(attributes.size.xs.valueRange)}
    save: ({ attributes }) => {
      const blockProps = useBlockProps.save({
        className: resultClass
      });
      console.log(blockProps);
      // console.log(attributes);


      // const { attributes } = props;
      // console.log(attributes);
      const combinedClass = [];



      let resultClass = "";
      Object.keys(attributes.size).forEach((breakpoint) => {

        let mod = attributes.size[breakpoint].mod;
        let valueRange = attributes.size[breakpoint].valueRange;
        let bootstrapFive = true;
        let noXsBreakpoint = bootstrapFive && breakpoint == 'xs';

        if (mod === "auto") {
          if (noXsBreakpoint) {
            resultClass += `col-auto `;
          } else {
            resultClass += `col-${breakpoint}-auto `;
          }
        }

        if (mod === "default") {
          if (noXsBreakpoint) {
            resultClass += `col `;
          } else {
            resultClass += `col-${breakpoint} `;
          }
        }

        if (mod === "custom") {
          if (noXsBreakpoint) {
            resultClass += `col-${valueRange} `;
          } else {
            resultClass += `col-${breakpoint}-${valueRange} `;
          }
        }
      });
      // console.log(resultClass);
      // console.log(attributes.size);




      if (resultClass) {
        combinedClass.push(resultClass);
      }

      if (attributes.className) {
        combinedClass.push(attributes.className);
      }

      const classNameString = combinedClass.join(" ");

      // console.log(blockProps);

      return (
        <div className={classNameString}>
          <InnerBlocks.Content />
        </div>
      );
    },
  }
);
