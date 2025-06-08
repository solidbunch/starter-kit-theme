import metadata from '../block.json';
import transforms from './transforms';

const {registerBlockType} = wp.blocks;
const {useBlockProps, PlainText, AlignmentToolbar, BlockControls} = wp.blockEditor;

const blockCustomClass = 'sk-block-code';

registerBlockType(
  metadata,
  {
    edit: props => {
      const {attributes, setAttributes, className} = props;
      const {content, alignment} = attributes;

      const blockProps = useBlockProps({
        className: [className, blockCustomClass],
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
          <pre {...blockProps}>
            <PlainText
              tagName="code"
              value={content}
              onChange={onChangeContent}
              style={{textAlign: alignment}}
              placeholder="Type / to choose a block"
            />
          </pre>
        </>
      );

      return [
        renderOutput,
      ];
    },

    save: (props) => {
      const {attributes, className} = props;
      const {content, alignment} = attributes;

      const classes = [
        blockCustomClass, //  Custom class for the block
        className, // Class from the block editor
        {
          left: 'text-start',
          right: 'text-end',
          center: 'text-center',
        }[alignment] || '',
      ]
        .filter(Boolean)
        .join(' ');

      const blockProps = useBlockProps.save({
        className: classes,
      });

      return (
        <pre {...blockProps}>
          <code>
            {content}
          </code>
        </pre>
      );
    },
    transforms,
  },
);
