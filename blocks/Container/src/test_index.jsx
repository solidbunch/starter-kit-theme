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
      const { attributes, setAttributes, clientId } = props;

      const blockProps = useBlockProps();

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
