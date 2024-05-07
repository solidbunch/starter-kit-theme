import metadata from '../block.json';

const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, RichText, AlignmentToolbar,BlockControls} = wp.blockEditor;
const {PanelBody, SelectControl} = wp.components;

registerBlockType(
  metadata,
  {

    edit: props => {
      const {attributes, setAttributes, className} = props;
      const {content, alignment} = attributes;
      
      const blockProps = useBlockProps({
        className: [className],
      });

      function onChangeContent(newContent) {
        setAttributes({content: newContent});
      }

      const onChangeAlignment = (newAlignment) => {
        let customAlignment;
        switch (newAlignment) {
        case 'left':
          customAlignment = 'start';
          break;
        case 'right':
          customAlignment = 'end';
          break;
        case 'center':
          customAlignment = 'center';
          break;
        default:
          customAlignment = null; 
        }
        setAttributes({alignment: newAlignment, customAlignment});
      };
    
      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Section styles">
            {/* <SelectControl
              label="Align text"
              value={attributes.alignment || ''}
              options={alignTextOptions}
              onChange={(alignText) =>
                setAttributes({
                  modification: {
                    ...attributes.modification,
                    alignText,
                  },
                })
              }
            /> */}
          </PanelBody>
        </InspectorControls>
      );
      
      const renderOutput = (
        <>
          <BlockControls>
            <AlignmentToolbar
              value={alignment}
              onChange={onChangeAlignment}
            />
          </BlockControls>
          <RichText
            {...blockProps}
            tagName="p"
            value={content}
            onChange={onChangeContent}
            style={{textAlign: alignment}}
            placeholder="Type / to choose a block"
          />
        </>
      );
      
      return [
        renderControls,
        renderOutput,
      ];
    },

    save: (props) => {
      const {attributes} = props;
      const {content, customAlignment} = attributes;
      const {className} = useBlockProps.save();
      const blockClass = `${customAlignment ? `text-${customAlignment}` : ""} ${className}`.trim();
      // Create a new object for the attributes, excluding the 'class' attribute if it's empty
      const blockProps = {};

      if (blockClass) {
        blockProps.className = blockClass;
      }
      return (
        <RichText.Content
          {...blockProps}
          tagName="p"
          value={content}
        />
      );
    },
  },
);
