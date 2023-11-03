/**
 * Block dependencies
 */
import metadata from '../block.json';

//import edit from './edit';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {useBlockProps} = wp.blockEditor;

const {InspectorControls} = wp.blockEditor;
const {PanelBody, SelectControl} = wp.components;
const {serverSideRender: ServerSideRender} = wp;

registerBlockType(metadata, {
  edit: (props) => {
    const {attributes, className, setAttributes} = props;

    const blockProps = useBlockProps({
      className: [className],
    });

    const {category} = attributes;

    return [
      <InspectorControls key="News Controlls">
        <PanelBody title="Settings" initialOpen={true}>
          <SelectControl
            label="Category"
            value={category}
            options={[
              {value: 'category1', label: 'Category 1'},
              {value: 'category2', label: 'Category 2'},
            ]}
            onChange={(val) => setAttributes({category: val})}
          />
        </PanelBody>
      </InspectorControls>,
      <div {...blockProps} key="serverRender">
        <ServerSideRender
          block={metadata.name}
          attributes={attributes}
        />
      </div>,
    ];
  }, // end edit
  save: () => {
    // Rendering in PHP
    return null;
  },
});
