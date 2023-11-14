/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const { registerBlockType } = wp.blocks;
const { useSelect } = wp.data;
const { InspectorControls, useBlockProps, InnerBlocks } = wp.blockEditor;
const { PanelBody, SelectControl, RangeControl, CheckboxControl } = wp.components;

const bootstrapBreakpoints = ['xs', 'sm', 'md', 'lg', 'xl', 'xxl'];
const numberOfGrid = 12;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const data = {
        'data-col-lg': attributes.size ?? 'default'
      };

      if (attributes.size === 'custom') {
        data['data-col-lg'] = attributes.modification.lg ?? 6;
      }

      return data;
    },

    edit: props => {
      const { attributes, setAttributes, clientId, className } = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      const { hasChildBlocks } = useSelect((select) => {
        const { getBlockOrder } = select('core/block-editor');

        return {
          hasChildBlocks: getBlockOrder(clientId).length > 0,
        };
      });

      return [
        <InspectorControls key="settings">
          <PanelBody title="Column settings">
            {/* <SelectControl
              label="Size"
              value={attributes.size}
              options={[
                { label: 'default', value: 'default' },
                { label: 'auto', value: 'auto' },
                { label: 'custom', value: 'custom' },
              ]}
              onChange={(size) => setAttributes({ size })}
            />
            {attributes.size === 'custom' &&
              <RangeControl
                label="Width"
                value={attributes.modification.lg}
                onChange={value => {
                  const modificationObject = { ...attributes.modification };
                  modificationObject.xs = value;
                  setAttributes({ ...attributes, modification: modificationObject });
                }}
                min={1}
                max={numberOfGrid}
                {...props}
              />
            } */}
            {bootstrapBreakpoints.map((btStep) => (
              <div key={btStep} title={`Column settings - ${btStep}`}>
                <CheckboxControl
                  label={`Enable ${btStep}`}
                  checked={attributes.breakpoints && attributes.breakpoints[btStep]}
                  onChange={(isChecked) => {
                    const breakpointsObject = { ...attributes.breakpoints };
                    breakpointsObject[btStep] = isChecked;
                    setAttributes({ ...attributes, breakpoints: breakpointsObject });
                    console.log();
                  }}
                />
                {attributes.breakpoints && attributes.breakpoints[btStep] && (
                  <>
                    <SelectControl
                      label="Size"
                      value={attributes.size}
                      options={[
                        { label: 'default', value: 'default' },
                        { label: 'auto', value: 'auto' },
                        { label: 'custom', value: 'custom' },
                      ]}
                      onChange={(size) => setAttributes({ size })}
                    />
                    {attributes.size === 'custom' &&
                      <RangeControl
                        label="Width"
                        value={attributes.modification[btStep]}
                        onChange={value => {
                          const modificationObject = { ...attributes.modification };
                          modificationObject[btStep] = value;
                          setAttributes({ ...attributes, modification: modificationObject });
                        }}
                        min={1}
                        max={numberOfGrid}
                        {...props}
                      />
                    }
                  </>
                )}
              </div>
            ))}
          </PanelBody>


        </InspectorControls>,
        <div {...blockProps} key="blockControls">
          <InnerBlocks
            renderAppender={
              hasChildBlocks
                ? undefined
                : () => <InnerBlocks.ButtonBlockAppender />
            }
          />
        </div>
      ];
    },

    save: props => {
      const { attributes } = props;

      let blockClassName = 'col';
      const combinedClass = [];

      if (attributes.size === 'auto') {
        blockClassName = 'col-auto';
      }

      if (attributes.size === 'custom') {
        // blockClassName = 'col-sm-' + attributes.modification.sm + ' col-lg-' + attributes.modification.lg;
        blockClassName = `
        col-${attributes.modification.xs}
        col-sm-${attributes.modification.sm}
        col-md-${attributes.modification.md}
        col-lg-${attributes.modification.lg}
        col-xl-${attributes.modification.xl}
        col-xxl-${attributes.modification.xxl}`
          ;
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
          <InnerBlocks.Content />
        </div>
      );
    },
  }
);
