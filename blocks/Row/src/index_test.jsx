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
const {InspectorControls, useBlockProps, InnerBlocks, useInnerBlocksProps} = wp.blockEditor;
const {PanelBody, SelectControl, CheckboxControl} = wp.components;

const allowedBlocks = ['starter-kit/column'];
function getClasses(params) {
  
}
registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const {modification, properties} = attributes;
      const classes = [modification]; // Начинаем с класса modification (row)
      
      // Object.keys(properties).forEach((breakpoint) => {
      //   const {justifyContent} = properties[breakpoint];
      //   const justifyContentText = "justify-content";
      //   const breakpointSuffix = breakpoint === "xs" ? "" : `-${breakpoint}`;
    
      //   // Добавляем класс только если justifyContent имеет значение
      //   if (justifyContent) {
      //     classes.push(`${justifyContentText}${breakpointSuffix}-${justifyContent}`);
      //   }
      // });

      // Object.keys(properties).forEach((breakpoint) => {
      //   const {alignItems} = properties[breakpoint];
      //   const alignItemsText = "align-items";
      //   const breakpointSuffix = breakpoint === "xs" ? "" : `-${breakpoint}`;
    
      //   // Добавляем класс только если justifyContent имеет значение
      //   if (alignItems) {
      //     classes.push(`${alignItemsText}${breakpointSuffix}-${alignItems}`);
      //   }
      // });
      Object.keys(properties).forEach((breakpoint) => {
        const {justifyContent, alignItems} = properties[breakpoint];
        const breakpointSuffix = breakpoint === "xs" ? "" : `-${breakpoint}`;
      
        if (justifyContent) {
          classes.push(`justify-content${breakpointSuffix}-${justifyContent}`);
        }
      
        if (alignItems) {
          classes.push(`align-items${breakpointSuffix}-${alignItems}`);
        }
      });
      
      return {className: classes.join(' ')};
    },    
    edit: props => {
      
      const {attributes, setAttributes, clientId, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      blockProps.className = blockProps.className.replace('wp-block ', '');
      
      const TEMPLATE = [['starter-kit/column']];

      const innerBlocksProps = useInnerBlocksProps(blockProps, {
        allowedBlocks: TEMPLATE,
        template: TEMPLATE,
        templateLock: false
      });
      return [
        <InspectorControls key="settings">
          <PanelBody title="alignment x"  initialOpen={ false }>
            {Object.keys(attributes.properties).map((breakpoint) => (
              
              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint `}>
                <CheckboxControl
                  label={`${breakpoint} alignment`}
                  checked={
                    attributes.properties && attributes.properties[breakpoint].justifyContent !== undefined && attributes.properties[breakpoint].justifyContent !== ""
                  }
                  onChange={(isChecked) => {
                    const propObject = {...attributes.properties};
                    if (isChecked) {
                      propObject[breakpoint] = {...propObject[breakpoint], justifyContent: "start"};
                    } else {
                      propObject[breakpoint] = {...propObject[breakpoint], justifyContent: ""};
                    }
                    setAttributes({...attributes, properties: propObject});
                    
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
          <PanelBody title="alignment Y"  initialOpen={ false }>
            {Object.keys(attributes.properties).map((breakpoint) => (
              
              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint `}>
                <CheckboxControl
                  label={`${breakpoint} alignment`}
                  checked={
                    attributes.properties && attributes.properties[breakpoint].alignItems !== undefined && attributes.properties[breakpoint].alignItems !== ""
                  }
                  onChange={(isChecked) => {
                    const propObject = {...attributes.properties};
                    if (isChecked) {
                      propObject[breakpoint] = {...propObject[breakpoint], alignItems: "start"};
                    } else {
                      propObject[breakpoint] = {...propObject[breakpoint], alignItems: ""};
                    }
                    setAttributes({...attributes, properties: propObject});
                    
                  }}
                />
                
                {attributes.properties && attributes.properties[breakpoint].alignItems !== undefined && attributes.properties[breakpoint].alignItems !== "" && (
                  <SelectControl
                    label={`Size ${breakpoint}`}
                    value={attributes.properties[breakpoint].alignItems}
                    options={attributes.alignItems.map((value) => ({
                      label: value,
                      value,
                    }))}
                    onChange={(value) => {
                      const propObject = {...attributes.properties};
                      propObject[breakpoint] = {...propObject[breakpoint], alignItems: value};
                      setAttributes({...attributes, properties: propObject});
                    }}
                  />
                
                )}
              </div>
            ))}
            
          </PanelBody>
        </InspectorControls>,
        <div {...innerBlocksProps} key="blockControls">
          
        </div>
      ];
    },

    save: props => {
      const {attributes} = props;
      const classes = [attributes.modification]; // Начинаем с класса modification
    
      const {properties} = attributes;
      // Object.keys(properties).forEach((breakpoint) => {
      //   const {justifyContent} = properties[breakpoint];
      //   const justifyContentText = "justify-content";
      //   const breakpointSuffix = breakpoint === "xs" ? "" : `-${breakpoint}`;
    
      //   if (justifyContent) {
      //     combinedClass.push(`${justifyContentText}${breakpointSuffix}-${justifyContent}`);
      //   }
      // });
      // Object.keys(properties).forEach((breakpoint) => {
      //   const {alignItems} = properties[breakpoint];
      //   const alignItemsText = "align-items";
      //   const breakpointSuffix = breakpoint === "xs" ? "" : `-${breakpoint}`;
    
      //   if (alignItems) {
      //     combinedClass.push(`${alignItemsText}${breakpointSuffix}-${alignItems}`);
      //   }
      // });
      Object.keys(properties).forEach((breakpoint) => {
        const {justifyContent, alignItems} = properties[breakpoint];
        const breakpointSuffix = breakpoint === "xs" ? "" : `-${breakpoint}`;
      
        if (justifyContent) {
          classes.push(`justify-content${breakpointSuffix}-${justifyContent}`);
        }
      
        if (alignItems) {
          classes.push(`align-items${breakpointSuffix}-${alignItems}`);
        }
      });
      if (attributes.className) {
        classes.push(attributes.className);
      }
    
      const classNameString = classes.join(" ");
      const blockProps = useBlockProps.save({
        className: classNameString
      });
    
      return (
        <div {...blockProps}>
          <InnerBlocks.Content/>
        </div>
      );
    }
    
  });
