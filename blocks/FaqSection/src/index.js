/**
 * Block dependecies
 */
// import Edit from './Edit';
import blockMetadata from '../block.json';
const blocksAllowed = ['starter-kit/faq-single'];
const blockTemplate = [
  ['starter-kit/faq-single'],
  ['starter-kit/faq-single']
];
/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {
  InnerBlocks,
  useBlockProps
} = wp.blockEditor;

const blockMainCssClass = 'accordion';

registerBlockType(
  blockMetadata,
  {
    edit: props => {
      const {className} = props;
      const blockProps = useBlockProps( {
        className: [blockMainCssClass, className]
      });

      const renderOutput = (
        <div {...blockProps}>
          <InnerBlocks
            allowedBlocks={blocksAllowed}
            template= {blockTemplate}
            templateLock= 'false'
            orientation="vertical"
          />
        </div>
      );
      return [
        renderOutput
      ];
    },
    save: () => {
      const blockProps = useBlockProps.save({
        className: blockMainCssClass
      });

      return (
        <div {...blockProps}>
          <InnerBlocks.Content />
        </div>
      );
    }
  }
);
