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
    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
      const blockProps = useBlockProps();
      const {justifyContent} = attributes.alignment;
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
            <div  title={`Column settings`} className={`box_breakpoint `}>

              <SelectControl
                label={`alignment xs`}
                value={""}
                options={justifyContent.const.reduce((options, value) => {
                  options[value] = {label: value, value};
                  return options;
                }, {})}
                onChange={(value) => {
                  let alignmentObj = {...attributes.alignment};
                  const justifyContentObj = {...justifyContent, valueN:value};
                  alignmentObj = {...alignmentObj,justifyContent: justifyContentObj};
                  setAttributes({...attributes, size: alignmentObj});
                  
                }}
              >
                {justifyContent.const.map((value) => (
                  <option key={value} value={value}>
                    {value}
                  </option>
                ))}
                
              </SelectControl> 
              
            </div>
            
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
      console.log(attributes);
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
          <InnerBlocks.Content/>
        </div>
      );
    }
  });
