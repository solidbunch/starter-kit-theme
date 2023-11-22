/**
 * Block dependencies
 */

import metadata from '../block.json';

/**
 * Internal block libraries
 */

const {useState} = wp.element;

const {registerBlockType} = wp.blocks;
const {useSelect} = wp.data;
const {InspectorControls, useBlockProps, InnerBlocks} = wp.blockEditor;
const {PanelBody, SelectControl, RangeControl, CheckboxControl} = wp.components;

const numberOfGrid = 12;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const {size} = attributes;
      const classes = [];

      // Object.keys(size).forEach((breakpoint) => {
      //   if(breakpoint === 'xs'){
      //     if (size[breakpoint].mod === 'default') {
      //       classes.push(`col`);
      //     } else if (size[breakpoint].mod === 'auto') {
      //       classes.push(`col-auto`);
      //     }else if (size[breakpoint].mod === 'custom') {
      //       if (size[breakpoint]?.valueRange !== undefined) {
      //         return classes.push(`col-${size[breakpoint].valueRange}`);
      //       }
            
      //       return classes.push(`col-6`);
      //     }
      //   } else if (size[breakpoint].mod === 'default') {
      //     classes.push(`col-${breakpoint}`);
      //   } else if (size[breakpoint].mod === 'auto') {
      //     classes.push(`col-${breakpoint}-auto`);
      //   }else if (size[breakpoint].mod === 'custom') {
      //     if (size[breakpoint]?.valueRange !== undefined) {
      //       return classes.push(`col-${breakpoint}-${size[breakpoint].valueRange}`);
      //     }
      //     console.log(classes);
      //     return classes.push(`col-${breakpoint}-6`);
      //   }
        
      // });
      Object.keys(size).forEach((breakpoint) => {
        const {mod, valueRange} = size[breakpoint];
      
        if (breakpoint === 'xs') {
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

      return {className: classes.join(' ')};
    },

    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });
     
      const {hasChildBlocks} = useSelect((select) => {
        const {getBlockOrder} = select('core/block-editor');

        return {
          hasChildBlocks: getBlockOrder(clientId).length > 0,
        };
      });

      return [
        <InspectorControls key="settings">
          <PanelBody title="Column settings">

            {Object.keys(attributes.size).map((breakpoint) => (

              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint ${attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== '' ? 'active' : ''}`}>

                <CheckboxControl
                  label={`Enable ${breakpoint}`}
                  checked={
                    attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== ""
                  }

                  onChange={(isChecked) => {
                    const sizeObject = {...attributes.size};
                    // sizeObject[breakpoint] = isChecked;
                    if (isChecked) {
                      sizeObject[breakpoint].mod = "default";
                      sizeObject[breakpoint] = {...sizeObject[breakpoint], mod: "default"};
                      // blockProps.className += ` col-${[breakpoint]}`;
                      
                    } else {
                      sizeObject[breakpoint].mod = "";
                      // blockProps.className += "";
                    }
                    // console.log(blockProps.className);
                    setAttributes({...attributes, size: sizeObject});
                  }}
                />
                {attributes.size && attributes.size[breakpoint].mod !== undefined && attributes.size[breakpoint].mod !== "" && (
                  <>
                    <SelectControl
                      label={`Size ${breakpoint}`}
                      value={attributes.size[breakpoint].mod}
                      options={[
                        {label: 'default', value: 'default'},
                        {label: 'auto', value: 'auto'},
                        {label: 'custom', value: "custom"},
                      ]}
                      onChange={(value) => {
                        const sizeObject = {...attributes.size};

                        // sizeObject[breakpoint].mod = value;
                        sizeObject[breakpoint] = {...sizeObject[breakpoint], mod: value};
                        setAttributes({...attributes, size: sizeObject});
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
    save: ({attributes}) => {
      const blockProps = useBlockProps.save({
        className: resultClass
      });
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

      if (resultClass) {
        combinedClass.push(resultClass);
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
    },
  }
);
