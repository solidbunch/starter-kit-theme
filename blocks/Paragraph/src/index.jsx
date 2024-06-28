import metadata from '../block.json';

const {registerBlockType} = wp.blocks;
const {useBlockProps, RichText, AlignmentToolbar, BlockControls} = wp.blockEditor;

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
        setAttributes({alignment: newAlignment});
      };
      
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
        renderOutput,
      ];
    },

    save: (props) => {
      const {attributes} = props;
      const {content, alignment} = attributes;
      const {className} = useBlockProps.save();
      
      let alignmentClass;
      switch (alignment) {
      case 'left':
        alignmentClass = 'text-start';
        break;
      case 'right':
        alignmentClass = 'text-end';
        break;
      case 'center':
        alignmentClass = 'text-center';
        break;
      default:
        alignmentClass = '';
      }
      
      const blockClass = `${alignmentClass} ${className}`.trim();
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
  }
);
