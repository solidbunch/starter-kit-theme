/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {useSelect} = wp.data;
const {InspectorControls, useBlockProps, InnerBlocks} = wp.blockEditor;
const {PanelBody, SelectControl, RadioControl, RangeControl} = wp.components;

const sizeOptions = ['sm', 'md', 'lg', 'xl', 'xxl'];
const numberOfGrid = 12;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {

      const data = {
        'data-col-lg': attributes.size ?? 'default'
      }

      if (attributes.size === 'custom') {
        data['data-col-lg'] = attributes.modification.lg ?? 6;
      }

      return data;
    },

    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
      const blockProps = useBlockProps({
        className: [className]
      });

      const {hasChildBlocks} = useSelect((select) => {
        const {getBlockOrder} = select('core/block-editor');

        return {
          hasChildBlocks: getBlockOrder(clientId).length > 0,
        };
      });

      //const blockClassName = 'col-xs-' + attributes.modification.xs + ' col-lg-' + attributes.modification.lg;
      const blockClassName = className;

      return [
        <InspectorControls>
          <PanelBody title="Column settings">
            <SelectControl
              label="Size"
              value={attributes.size}
              options={[
                {label: 'default', value: 'default'},
                {label: 'auto', value: 'auto'},
                {label: 'custom', value: 'custom'},
              ]}
              onChange={(size) => setAttributes({size})}
            />
            {attributes.size === 'custom' &&
              <RangeControl
                label="Width"
                value={attributes.modification.lg}
                onChange={value => {
                  const modificationObject = {...attributes.modification};
                  modificationObject.lg = value;
                  setAttributes({...attributes, modification: modificationObject});
                }}
                min={1}
                max={numberOfGrid}
                {...props}
              />
            }
          </PanelBody>
        </InspectorControls>,
        <div {...blockProps} key="blockControls">
          <InnerBlocks
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

      let blockClassName = 'col';
      const combinedClass = [];

      if (attributes.size === 'auto') {
        blockClassName = 'col-auto';
      }

      if (attributes.size === 'custom') {
        blockClassName = 'col-sm-' + attributes.modification.sm + ' col-lg-' + attributes.modification.lg;
      }

      if (blockClassName) {
        combinedClass.push(blockClassName);
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
    },
  });
