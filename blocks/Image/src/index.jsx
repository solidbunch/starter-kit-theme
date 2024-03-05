/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, InnerBlocks, MediaPlaceholder} = wp.blockEditor;
const {PanelBody, SelectControl , Placeholder ,CheckboxControl, TextControl} = wp.components;

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
      const handleCheckboxChange = (breakpoint, checked, imageUrl) => {
        setAttributes({
          srcSet: {
            ...attributes.srcSet,
            [breakpoint]: {
              ...attributes.srcSet[breakpoint],
              imageUrl: checked ? imageUrl : '',
            }
          }
        });
      };
      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Select Sizes">
            {Object.keys(attributes.srcSet).map((breakpoint) => (
              <CheckboxControl
                key={breakpoint}
                label={breakpoint.toUpperCase()}
                checked={!!attributes.srcSet[breakpoint].imageUrl}
                onChange={(checked) => handleCheckboxChange(breakpoint, checked, attributes.imageUrl)}
              />
            ))}
          </PanelBody>
        </InspectorControls>
      );
      { console.log(attributes.srcSet); }
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
          
          <img src={attributes.imageUrl} alt="Saved"  />
        </figure>
      );
    },
  },
);
