/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, InnerBlocks, MediaPlaceholder} = wp.blockEditor;
const {PanelBody, SelectControl , Placeholder} = wp.components;

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
          <PanelBody title="sdsdf">
            <h1>sdsdf</h1>
            
          </PanelBody>
        </InspectorControls>
      );

      const renderOutput = (
        <div  {...blockProps} key="blockControls">
          {attributes.imageUrl ? (
            <img src={attributes.imageUrl} alt="Uploaded" />
          ) : (
            <MediaPlaceholder
              icon="format-image"
              labels={{title: 'Add Image'}}
              onSelect={(media) => {
                setAttributes({
                  imageUrl: media.url
                });
              }}
            />
          )}
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
        <figure {...blockProps}>
          {console.log(attributes)}
          <img src={attributes.imageUrl} alt="Saved "/>
        </figure>
      );
    },
  },
);
