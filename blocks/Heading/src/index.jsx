import metadata from '../block.json';

const {registerBlockType} = wp.blocks;
const {useBlockProps, RichText, AlignmentToolbar,BlockControls,HeadingLevelDropdown} = wp.blockEditor;

registerBlockType(
  metadata,
  {

    edit: props => {
      const {attributes, setAttributes, className} = props;
      const {content, alignment,level} = attributes;
      const tagName = 'h' + level;
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
      
      const renderOutput = (
        <>
          <BlockControls group="block">
            <HeadingLevelDropdown
              value={ level }
              onChange={ ( newLevel ) =>
                setAttributes( {level: newLevel} )
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
      const {content, customAlignment,level} = attributes;
      const TagName = 'h' + level;
      const {className} = useBlockProps.save();
      const blockClass = `${customAlignment ? `text-${customAlignment}` : ""} ${className}`.trim();
      // Create a new object for the attributes, excluding the 'class' attribute if it's empty
      const blockProps = {};

      if (blockClass) {
        blockProps.className = blockClass;
      }
      return (
        <TagName {...blockProps}>
          <RichText.Content value={ content } />
        </TagName>
      );
    },
  },
);
