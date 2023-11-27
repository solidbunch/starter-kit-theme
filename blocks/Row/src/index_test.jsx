// justify-content-{sm / md / ..etc}-{start / end / center / between / around  / evenly} 

// .align-items-{sm / md / ..etc}-{start / end / center / baseline / stretch} 

/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {useSelect} = wp.data;
const {InspectorControls, useBlockProps, InnerBlocks} = wp.blockEditor;
const {PanelBody, SelectControl, RangeControl, CheckboxControl} = wp.components;

const allowedBlocks = ['starter-kit/column'];

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const {properties} = attributes;
      const classes = [];
      Object.keys(properties).forEach((breakpoint) => {
        const {justifyContent} = properties[breakpoint];
        const justifyContentText = "justify-content";
        if(breakpoint === "xs"){
          if(justifyContent === "start"){
            classes.push(`${justifyContentText}-start`);
          } else if(justifyContent === "end"){
            classes.push(`${justifyContentText}-end`);
          }else if(justifyContent === "center"){
            classes.push(`${justifyContentText}-center`);
          }else if(justifyContent === "between"){
            classes.push(`${justifyContentText}-between`);
          }else if(justifyContent === "around"){
            classes.push(`${justifyContentText}-around`);
          }else if(justifyContent === "evenly"){
            classes.push(`${justifyContentText}-evenly`);
          }
        }else if(justifyContent === "start"){
          classes.push(`${justifyContentText}-${breakpoint}-start`);
        }else if(justifyContent === "end"){
          classes.push(`${justifyContentText}-${breakpoint}-end`);
        }else if(justifyContent === "center"){
          classes.push(`${justifyContentText}-${breakpoint}-center`);
        }else if(justifyContent === "between"){
          classes.push(`${justifyContentText}-${breakpoint}-between`);
        }else if(justifyContent === "around"){
          classes.push(`${justifyContentText}-${breakpoint}-around`);
        }else if(justifyContent === "evenly"){
          classes.push(`${justifyContentText}-${breakpoint}-evenly`);
        }
      });
      return {className: classes.join(' ')};
    },
    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });
      // const {justifyContent} = attributes;
      const {hasChildBlocks} = useSelect((select) => {
        const {getBlockOrder} = select('core/block-editor');

        return {
          hasChildBlocks: getBlockOrder(clientId).length > 0,
        };
      });
      // console.log(justifyContent);
      return [
        <InspectorControls key="settings">
          <PanelBody title="alignment x"  initialOpen={ true }>
            {Object.keys(attributes.properties).map((breakpoint) => (
              
              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint `}>
                <CheckboxControl
                  label={`Enable ${breakpoint}`}
                  checked={
                    attributes.properties && attributes.properties[breakpoint].justifyContent !== undefined && attributes.properties[breakpoint].justifyContent !== ""
                  }
                  onChange={(isChecked) => {
                    const sizeObject = {...attributes.properties};
                    if (isChecked) {
                      sizeObject[breakpoint] = {...sizeObject[breakpoint], justifyContent: "start"};
                    } else {
                      sizeObject[breakpoint] = {...sizeObject[breakpoint], justifyContent: ""};
                    }
                    setAttributes({...attributes, properties: sizeObject});
                    
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
        </InspectorControls>,
        <div {...blockProps} key="blockControls">
          <InnerBlocks
            allowedBlocks={allowedBlocks}
            renderAppender={
              hasChildBlocks
                ? undefined
                : () => <InnerBlocks.ButtonBlockAppender/>
            }
          />
        </div>
      ];
    },

    save: props => {
      const {attributes} = props;
      // console.log(attributes);
      const combinedClass = [];

      const {properties} = attributes;
      const classes = [];
      Object.keys(properties).forEach((breakpoint) => {
        const {justifyContent} = properties[breakpoint];
        const justifyContentText = "justify-content";
        if(breakpoint === "xs"){
          if(justifyContent === "start"){
            classes.push(`${justifyContentText}-start`);
          } else if(justifyContent === "end"){
            classes.push(`${justifyContentText}-end`);
          }else if(justifyContent === "center"){
            classes.push(`${justifyContentText}-center`);
          }else if(justifyContent === "between"){
            classes.push(`${justifyContentText}-between`);
          }else if(justifyContent === "around"){
            classes.push(`${justifyContentText}-around`);
          }else if(justifyContent === "evenly"){
            classes.push(`${justifyContentText}-evenly`);
          }
        }else if(justifyContent === "start"){
          classes.push(`${justifyContentText}-${breakpoint}-start`);
        }else if(justifyContent === "end"){
          classes.push(`${justifyContentText}-${breakpoint}-end`);
        }else if(justifyContent === "center"){
          classes.push(`${justifyContentText}-${breakpoint}-center`);
        }else if(justifyContent === "between"){
          classes.push(`${justifyContentText}-${breakpoint}-between`);
        }else if(justifyContent === "around"){
          classes.push(`${justifyContentText}-${breakpoint}-around`);
        }else if(justifyContent === "evenly"){
          classes.push(`${justifyContentText}-${breakpoint}-evenly`);
        }
      });

      if (classes) {
        combinedClass.push(classes);
      }
      if (attributes.className) {
        combinedClass.push(attributes.className);
      }
      const classNameString = combinedClass.join(" ");
      const blockProps = useBlockProps.save({
        className: classNameString
      });

      return (
        // {...blockProps}
        <div >
          <InnerBlocks.Content/>
        </div>
      );
    }
  });
