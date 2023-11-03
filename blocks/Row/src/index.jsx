/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {useSelect} = wp.data;
const {useBlockProps, InnerBlocks} = wp.blockEditor;

const allowedBlocks = ['starter-kit/column'];

registerBlockType(
  metadata,
  {
    edit: props => {
      const {clientId} = props;

      const blockProps = useBlockProps();

      const {hasChildBlocks} = useSelect((select) => {
        const {getBlockOrder} = select('core/block-editor');

        return {
          hasChildBlocks: getBlockOrder(clientId).length > 0,
        };
      });

      return [
        <div {...blockProps} key="blockControls">
          <InnerBlocks
            allowedBlocks={allowedBlocks}
            renderAppender={
              hasChildBlocks
                ? undefined
                : () => <InnerBlocks.ButtonBlockAppender/>
            }
          />
        </div>
      ];
    },

    save: props => {
      const {attributes} = props;

      const combinedClass = [];

      if (attributes.modification) {
        combinedClass.push(attributes.modification);
      }

      if (attributes.className) {
        combinedClass.push(attributes.className);
      }

      const classNameString = combinedClass.join(" ");

      return (
        <div className={classNameString}>
          <InnerBlocks.Content/>
        </div>
      );
    }
  });
