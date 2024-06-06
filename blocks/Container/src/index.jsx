/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, InnerBlocks} = wp.blockEditor;
const {PanelBody, SelectControl} = wp.components;

function checkHasChildBlocks(clientId) {
  const {getBlockOrder} = wp.data.select('core/block-editor');
  return getBlockOrder(clientId).length > 0;
}

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const blockClass = attributes.modification;
      return {className: blockClass};
    },
    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Container responsive type">
            <SelectControl
              label="Container width"
              value={attributes.modification}
              options={[
                {label: 'Responsive', value: 'container'},
                {label: 'Full width', value: 'container-fluid'},
              ]}
              onChange={(modification) => setAttributes({modification})}
            />
          </PanelBody>
        </InspectorControls>
      );

      const renderOutput = (
        <div {...blockProps} key="blockControls">
          <InnerBlocks
            renderAppender={
              checkHasChildBlocks(clientId)
                ? undefined
                : () => <InnerBlocks.ButtonBlockAppender/>
            }
          />
        </div>
      );

      return [
        renderControls,
        renderOutput,
      ];
    },
    save: props => {
      const {attributes} = props;

      const blockClass = attributes.modification;

      const blockProps = useBlockProps.save({
        className: blockClass,
      });

      return (
        <div {...blockProps}>
          <InnerBlocks.Content/>
        </div>
      );
    },
  },
);
