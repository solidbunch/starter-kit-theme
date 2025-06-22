/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {useBlockProps} = wp.blockEditor;
const {serverSideRender: ServerSideRender} = wp;

registerBlockType(
  metadata,
  {
    edit: (props) => {
      const {attributes, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      const renderOutput = (
        <div {...blockProps} key="blockControls">
          <ServerSideRender
            block={metadata.name}
            attributes={attributes}
          />
        </div>
      );

      return [
        renderOutput,
      ];
    },
    save: () => {
      // Rendering in PHP
      return null;
    },
  },
);
