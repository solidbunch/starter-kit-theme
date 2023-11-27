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
      const {modification, properties} = attributes;
      const classes = [modification]; // Начинаем с класса modification
    
      Object.keys(properties).forEach((breakpoint) => {
        const {justifyContent} = properties[breakpoint];
        const justifyContentText = "justify-content";
        const breakpointSuffix = breakpoint === "xs" ? "" : `-${breakpoint}`;
    
        // Добавляем класс только если justifyContent имеет значение
        if (justifyContent) {
          classes.push(`${justifyContentText}${breakpointSuffix}-${justifyContent}`);
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
          <PanelBody title="alignment x"  initialOpen={ true }>
            {Object.keys(attributes.properties).map((breakpoint) => (
              
              <div key={breakpoint} title={`Column settings - ${breakpoint}`} className={`box_breakpoint `}>
                <CheckboxControl
                  label={`Enable ${breakpoint}`}
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
      const combinedClass = [attributes.modification]; // Начинаем с класса modification
    
      const {properties} = attributes;
      Object.keys(properties).forEach((breakpoint) => {
        const {justifyContent} = properties[breakpoint];
        const justifyContentText = "justify-content";
        const breakpointSuffix = breakpoint === "xs" ? "" : `-${breakpoint}`;
    
        if (justifyContent) {
          combinedClass.push(`${justifyContentText}${breakpointSuffix}-${justifyContent}`);
        }
      });
    
      if (attributes.className) {
        combinedClass.push(attributes.className);
      }
    
      const classNameString = combinedClass.join(" ");
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
