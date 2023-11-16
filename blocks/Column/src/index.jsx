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
    getEditWrapperProps(attributes) {
      const data = {
        'data-col-lg': attributes.size ?? 'default'
      };

      if (attributes.size === 'custom') {
        data['data-col-lg'] = attributes.modification.lg ?? 6;
      }

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
    save: props => {
      const { attributes } = props;

      const combinedClass = [];

      // if (attributes.size === 'auto') {
      //   blockClassName = 'col-auto';
      // }

      // if (attributes.size === 'custom') {
      //   blockClassName = `
      //   col-${attributes.size.xs}
      //   col-sm-${attributes.size.sm}
      //   col-md-${attributes.size.md}
      //   col-lg-${attributes.size.lg}
      //   col-xl-${attributes.size.xl}
      //   col-xxl-${attributes.size.xxl}`;
      // }


      let resultClass = "";
      Object.keys(attributes.size).forEach((breakpoint) => {
        let mod = attributes.size[breakpoint].mod;
        let valueRange = attributes.size[breakpoint].valueRange;
        if (mod) {
          if (mod === "auto") {
            resultClass += `col-${breakpoint}-auto `;
          }
          if (mod === "default") {
            resultClass += `col-${breakpoint} `;
          }
          if (mod === "custom") {
            resultClass += `col-${breakpoint}-${valueRange} `;
          }
        }
      });
      console.log(resultClass);
      // console.log(attributes.size);




      if (resultClass) {
        combinedClass.push(resultClass);
      }

      if (attributes.className) {
        combinedClass.push(attributes.className);
      }

      const classNameString = combinedClass.join(" ");
      return (
        <div className={resultClass}>
          <InnerBlocks.Content />
        </div>
      );
    },
  }
);
