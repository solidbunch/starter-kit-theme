import metadata from '../block.json';

const {registerBlockType} = wp.blocks;
const {useBlockProps, RichText, AlignmentToolbar, BlockControls} = wp.blockEditor;

registerBlockType(
  metadata,
  {
    edit: (props) => {
      const {attributes, setAttributes, className, onReplace, mergeBlocks, onRemove} = props;
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
            identifier="content"
            value={content}
            onChange={onChangeContent}
            onMerge={ mergeBlocks }
            onReplace={ onReplace }
            onRemove={ onRemove }
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
      const blockProps = useBlockProps.save();
      const {className} = blockProps;

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
