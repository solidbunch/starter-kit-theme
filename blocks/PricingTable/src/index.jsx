/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps} = wp.blockEditor;
const {PanelBody, SelectControl, Spinner} = wp.components;
const {serverSideRender: ServerSideRender} = wp;
const {useState, useEffect} = wp.element;

registerBlockType(
  metadata,
  {
    edit: props => {
      const {attributes, setAttributes, className} = props;
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
