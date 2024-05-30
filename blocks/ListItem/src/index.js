/**
 * Block dependencies
 */
import blockMetadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {RichText, InspectorControls, useBlockProps} = wp.blockEditor;
const {PanelBody, TextControl} = wp.components;

const blockMainCssClass = '';

registerBlockType(blockMetadata, {
  edit: props => {
    const {attributes, className, setAttributes} = props;

    const blockProps = useBlockProps({
      className: [blockMainCssClass, className]
    });

    const renderControls = (
      <InspectorControls key="inspectorControls">
        <h1>TEST LI</h1>
      </InspectorControls>
    );

    const renderOutput = (
      <RichText
        {...blockProps}
        key="blockControls"
        tagName="li"
        multiline={false}
        format="string"
        placeholder="Text here"
        onChange={question => setAttributes({question})}
        value={attributes.question}
      />
    );

    return [
      renderControls,
      renderOutput
    ];
  }, // end edit
  save: props => {
    const {attributes} = props;

    const blockProps = useBlockProps.save({
      className: blockMainCssClass
    });

    return (
      <RichText.Content
        {...blockProps}
        tagName="li"
        value={attributes.question}
      />
    );
  }
});
