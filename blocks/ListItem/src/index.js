/**
 * Block dependencies
 */
import blockMetadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {RichText, InspectorControls, useBlockProps} = wp.blockEditor;

registerBlockType(blockMetadata, {
  edit: props => {
    const {attributes, className, setAttributes} = props;

    const blockProps = useBlockProps({className});

    const renderControls = (
      <InspectorControls key="inspectorControls">
        <h1>TEST LI</h1>
      </InspectorControls>
    );

    const renderOutput = (
      <RichText
        {...blockProps}
        key="blockControls"
        multiline="li"
        format="string"
        placeholder="Text here"
        onChange={text => setAttributes({text})}
        value={attributes.text}
      />
    );

    return [
      renderControls,
      renderOutput
    ];
  }, // end edit
  save: props => {
    const {attributes} = props;

    const {className} = useBlockProps.save();
    const blockProps = className ? {className} : {};

    return (
      <RichText.Content
        {...blockProps}
        value={attributes.text}
      />
    );
  }
});
