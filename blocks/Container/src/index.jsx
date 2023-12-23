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
const { PanelBody, SelectControl } = wp.components;

registerBlockType(
  metadata,
  {
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
        <InspectorControls key="controls">
          <PanelBody title="Container responsive type">
            <SelectControl
              label="Container width"
              value={attributes.modification}
              options={[
                { label: 'Fixed width', value: 'container-xxl' },
                { label: 'Full width', value: 'container-fluid' }
              ]}
              onChange={(modification) => setAttributes({ modification })}
            />
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
    save: props => {
      const {attributes} = props;

      const containerClass = [attributes.modification];

      const blockProps = useBlockProps.save({
        //className: props.className ? props.className + ' ' + containerClass : containerClass
      });
console.log('block');
      return (
        <div {...blockProps}>
          <InnerBlocks.Content />
        </div>
      );
    }
  });
