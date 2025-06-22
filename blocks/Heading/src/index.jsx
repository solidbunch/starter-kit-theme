import metadata from '../block.json';
import transforms from './transforms';

const {registerBlockType} = wp.blocks;
const {useBlockProps, RichText, AlignmentToolbar, BlockControls, HeadingLevelDropdown} = wp.blockEditor;

registerBlockType(
  metadata,
  {
    edit: (props) => {
      const {attributes, setAttributes, className} = props;
      const {content, alignment, level} = attributes;
      const tagName = 'h' + level;
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
          <BlockControls group="block">
            <HeadingLevelDropdown
              value={level}
              onChange={(newLevel) =>
                setAttributes({level: newLevel})
              }
            />
            <AlignmentToolbar
              value={alignment}
              onChange={onChangeAlignment}
            />
          </BlockControls>
          <RichText
            {...blockProps}
            tagName={tagName}
            value={content}
            onChange={onChangeContent}
            style={{textAlign: alignment}}
            placeholder="Heading"
          />
        </>
      );

      return [
        renderOutput,
      ];
    },

    save: (props) => {
      const {attributes} = props;
      const {content, alignment, level} = attributes;
      const TagName = 'h' + level;
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
        <TagName {...blockProps}>
          <RichText.Content value={content} />
        </TagName>
      );
    },
    transforms,
  }
);
