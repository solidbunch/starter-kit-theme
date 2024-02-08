/**
 * Block dependecies
 */
import Edit from './Edit';
import blockMetadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {
  // https://developer.wordpress.org/block-editor/tutorials/block-tutorial/nested-blocks-inner-blocks/
  InnerBlocks,
  InspectorControls,
  useBlockProps
} = wp.blockEditor;
const {
  PanelBody,
  SelectControl
} = wp.components;

const blockMainCssClass = 'accordion';

registerBlockType(
  blockMetadata,
  {
    edit: props => {
      const {attributes, className, setAttributes} = props;

      // https://make.wordpress.org/core/2020/11/18/block-api-version-2/
      const blockProps = useBlockProps( {
        className: [blockMainCssClass, className]
      });

      // options for schema.org
      let schemaOptions = [
        {
          label: 'Enabled',
          value: 'enabled'
        },
        {
          label: 'Disabled',
          value: 'disabled'
        }
      ];

      return [
        <InspectorControls key="inspectorControls">
          <PanelBody title="Additional settings">
            <SelectControl
              label="Generate Schema.org"
              value={ attributes.enableSchema }
              options={ schemaOptions }
              onChange={ enableSchema => {setAttributes({enableSchema});} }
            />
          </PanelBody>
        </InspectorControls>,
        <Edit {...props} blockprops={blockProps} cssclass={blockMainCssClass} enableSchema={ attributes.enableSchema } key="blockControls" />
      ];
    },
    save: (props) => {
      const {attributes} = props;
      const blockProps = useBlockProps.save({
        className: blockMainCssClass
      });

      return (
        <div {...blockProps}>
          <div className={blockMainCssClass}>
            <InnerBlocks.Content />
          </div>
          
        </div>
      );
    }
  }
);
