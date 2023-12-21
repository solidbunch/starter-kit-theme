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

// const spacers = ['m', 'p'];
// const spacersName = ['t', 'b', 'e', 's'];
// remove Restricted Classes
function removeRestrictedClasses(inputStr, excludeArray) {
  // Split the string into words
  const words = inputStr.split(/\s+/);
  // Remove matches from the list of words
  const filteredWords = words.filter(word => !excludeArray.includes(word));
  return filteredWords.join(' ');
}
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

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {

      return { className: generateClasses(attributes, numberOfGrid) };
    },
    edit: props => {
      const { attributes, setAttributes, clientId, className } = props;

      const blockProps = useBlockProps({
        className: [className],
      });
      blockProps.className = removeRestrictedClasses(blockProps.className, attributes.excludeClasses);
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
                { label: 'container', value: 'container' },
                { label: 'container-sm', value: 'container-sm' },
                { label: 'container-md', value: 'container-md' },
                { label: 'container-lg', value: 'container-lg' },
                { label: 'container-xl', value: 'container-xl' },
                { label: 'Fixed width', value: 'container-xxl' },
                { label: 'Full width', value: 'container-fluid' }
              ]}
              onChange={(modification) => setAttributes({ modification })}
            />
          </PanelBody>
        </InspectorControls>,
        // <InspectorControls key="controls">
        //   <PanelBody title="Spacers">
        //     {Object.keys(attributes.size).map((breakpoint) => (

        //       <div key={breakpoint} title={`breakpoint settings - ${breakpoint}`} className={`box_breakpoint ${attributes.size[breakpoint].valueRange !== undefined && attributes.size[breakpoint].valueRange !== '' ? 'active' : ''}`}>
        //         <CheckboxControl
        //           label={`Enable ${breakpoint}`}
        //           checked={
        //             attributes.size && attributes.size[breakpoint].valueRange !== undefined && attributes.size[breakpoint].valueRange !== ""
        //           }
        //           onChange={(isChecked) => {
        //             const sizeObject = { ...attributes.size };
        //             if (isChecked) {
        //               sizeObject[breakpoint] = { ...sizeObject[breakpoint], valueRange: {} };
        //             } else {
        //               // sizeObject[breakpoint] = { ...sizeObject[breakpoint], valueRange: "" };
        //               delete sizeObject[breakpoint].valueRange;
        //             }
        //             setAttributes({ ...attributes, size: sizeObject });
        //           }}
        //         />

        //         {attributes.size && attributes.size[breakpoint].valueRange !== undefined && attributes.size[breakpoint].valueRange !== "" && (
        //           <>
        //             {spacers.map((spacer, index) => (
        //               spacersName.map((spacerName, innerIndex) => {
        //                 const uniqueKey = `${spacer}${spacerName}-${breakpoint}`;
        //                 const maxGrid = spacer === 'p' ? numberOfGrid : numberOfGrid + 1;

        //                 return (
        //                   <RangeControl
        //                     key={uniqueKey}
        //                     allowReset={false}
        //                     label={
        //                       (() => {
        //                         let labelValue;
        //                         if (attributes.size[breakpoint]?.valueRange?.[uniqueKey] !== undefined) {
        //                           if (attributes.size[breakpoint].valueRange[uniqueKey] === (numberOfGrid + 1)) {
        //                             labelValue = "auto";
        //                           } else {
        //                             labelValue = attributes.size[breakpoint].valueRange[uniqueKey];
        //                           }
        //                         } else {
        //                           labelValue = "none";
        //                         }
        //                         return `${uniqueKey}-${labelValue}`;
        //                       })()
        //                     }


        //                     value={
        //                       (() => {
        //                         if (attributes.size[breakpoint]?.valueRange?.[uniqueKey] !== undefined) {
        //                           return attributes.size[breakpoint].valueRange[uniqueKey];
        //                         }
        //                         return -1;
        //                       })()
        //                     }

        //                     onChange={value => {
        //                       const sizeObject = { ...attributes.size };

        //                       if (value === -1) {

        //                         delete sizeObject[breakpoint].valueRange[uniqueKey];
        //                       } else {

        //                         sizeObject[breakpoint] = {
        //                           ...sizeObject[breakpoint],
        //                           valueRange: {
        //                             ...sizeObject[breakpoint].valueRange,

        //                             [uniqueKey]: value,
        //                           },
        //                         };
        //                       }
        //                       setAttributes({ ...attributes, size: sizeObject });
        //                     }}

        //                     min={-1}
        //                     max={maxGrid}
        //                     withInputField={false}
        //                     {...props}
        //                   />
        //                 );
        //               })
        //             ))}
        //           </>
        //         )}


        //       </div>
        //     ))}
        //   </PanelBody>
        // </InspectorControls>,
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
    save: props => {
      const { attributes } = props;

      const blockProps = useBlockProps.save({
        className: generateClasses(attributes, numberOfGrid)
      });
      blockProps.className = removeRestrictedClasses(blockProps.className, attributes.excludeClasses);
      // console.log(blockProps.className);
      return (
        <div {...blockProps}>
          <InnerBlocks.Content />
        </div>
      );
    }
  });