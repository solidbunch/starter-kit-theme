/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;

const {InspectorControls, useBlockProps, RichText, InnerBlocks} = wp.blockEditor;
const {PanelBody, TextControl, SelectControl, CheckboxControl} = wp.components;

const allowedBlocks = ['core/heading', 'core/paragraph'];

const blockMainCssClass = 'starter-block';

registerBlockType(
  metadata,
  {
    edit: props => {
      const {attributes, setAttributes} = props;
      const {className} = props;

      const blockProps = useBlockProps({
        className: [blockMainCssClass, className],
      });

      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Starter Block Settings">
            <TextControl
              label="Attribute 1 stored in the block’s comment delimiter"
              value={attributes.attribute1}
              onChange={(attribute1) => setAttributes({attribute1})}
            />
            <SelectControl
              label="Select Attribute 2 stored in .some-class1 element HTML text"
              value={attributes.attribute2}
              options={[
                {label: 'Label1', value: 'value1'},
                {label: 'Label2', value: 'value2'},
                {label: 'Label3', value: 'value3'},
              ]}
              onChange={(attribute2) => setAttributes({attribute2})}
            />
            <CheckboxControl
              label="Attribute 3? Boolean type"
              checked={attributes.attribute3}
              onChange={(attribute3) => setAttributes({attribute3})}
            />
          </PanelBody>
        </InspectorControls>
      );

      const renderOutput = (
        <div {...blockProps} key="blockControls">
          <div className="some-class">
            <RichText
              tagName="h4"
              multiline={false}
              format="string"
              placeholder="Put some text here. Attribute4 stored in H4 element HTML"
              onChange={attribute4 => {
                setAttributes({attribute4});
              }}
              value={attributes.attribute4}
            />
            <i className="icon"></i>
          </div>
          <div className="some-class1">{attributes.attribute2}</div>
          <div className="some-class2">
            <InnerBlocks
              allowedBlocks={allowedBlocks}
              orientation="vertical"
            />
          </div>
        </div>
      );

      return [
        renderControls,
        renderOutput,
      ];
    },

    save: props => {
      const {attributes} = props;

      return (
        <div className={blockMainCssClass}>
          <div className="some-class">
            <RichText.Content
              tagName="h4"
              multiline={false}
              value={attributes.attribute4}
            />
            <i className="icon"></i>
          </div>
          <div className="some-class1">{attributes.attribute2}</div>
          <div className="some-class2">
            <InnerBlocks.Content/>
          </div>
        </div>
      );
    },
  });
