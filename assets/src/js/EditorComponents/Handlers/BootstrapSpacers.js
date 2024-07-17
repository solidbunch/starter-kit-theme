import variables from '../../../../../assets/build/variables.json';
const {InspectorControls} = wp.blockEditor;
const {PanelBody, RangeControl, CheckboxControl} = wp.components;

export default class BootstrapSpacers {

  // ToDo store grid variables in one place - maybe scss
  static numberOfGrid = 5;

  static spacersTypes = ['m', 'p'];
  static spacersDirection = ['t', 'b', 'e', 's'];

  /**
   * Register spacer attribute to all blocks in category
   * @param {Object} settings
   * @param {string} blockName
   *
   * @return {Object} settings
   */
  static addSpacerAttribute(settings, blockName) {
    // Check if the block is from the custom category

    if (blockName.startsWith('starter-kit/')) { 
      // Define your custom attribute
      const spacerAttributes = { 
        spacers: {
          type: 'object',
          default: Object.keys(variables['grid-breakpoints'] || {}).reduce((acc, key) => {
            acc[key] = {};
            return acc;
          }, {}),
        },
      }; 

      // Merge the custom attribute with existing attributes
      settings.attributes = {
        ...settings.attributes,
        ...spacerAttributes,
      };
    }

    return settings;
  }

  /**
   * Update editor block wrapper classes with spacers
   *
   * @param {Object} settings
   * @param {string} blockName
   *
   * @return {Object} settings
   */
  static modifyBlockWrapperClass(settings, blockName) {

    // Check if the block is one of your custom blocks
    if (blockName.startsWith('starter-kit/')) {
      const originalGetEditWrapperProps = settings.getEditWrapperProps;

      settings.getEditWrapperProps = (attributes) => {
        // Call original getEditWrapperProps if it exists
        let props = originalGetEditWrapperProps ? originalGetEditWrapperProps(attributes) : {};

        const spacersClasses = BootstrapSpacers.generateClasses(attributes);

        props.className = [props.className, spacersClasses].filter(Boolean).join(' ');

        return props;
      };
    }

    return settings;
  };

  /**
   * Add InspectorControls for spacer options for all blocks in category
   */
  static editSpacerClasses = wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {

      const {attributes, setAttributes} = props;
      if (props.name.startsWith('starter-kit/')) {

        return (

          <>

            <BlockEdit {...props} />
            <InspectorControls key="controls">
              <PanelBody title="Spacers" initialOpen={false}>
                {Object.keys(attributes.spacers).map((breakpoint) => (

                  <div key={breakpoint} title={`breakpoint settings - ${breakpoint}`} className={`box_breakpoint ${attributes.spacers[breakpoint].valueRange !== undefined && attributes.spacers[breakpoint].valueRange !== '' ? 'active' : ''}`}>

                    <CheckboxControl
                      label={`Enable ${breakpoint}`}
                      checked={
                        attributes.spacers &&
                        attributes.spacers[breakpoint].valueRange !== undefined &&
                        attributes.spacers[breakpoint].valueRange !== ''
                      }
                      onChange={(isChecked) => {
                        const spacersObject = {...attributes.spacers};
                        if (isChecked) {
                          spacersObject[breakpoint] = {
                            ...spacersObject[breakpoint],
                            valueRange: {},
                          };
                        } else {
                          // spacersObject[breakpoint] = { ...spacersObject[breakpoint], valueRange: "" };
                          delete spacersObject[breakpoint].valueRange;
                        }
                        setAttributes({...attributes, spacers: spacersObject});
                      }}
                    />

                    {attributes.spacers && attributes.spacers[breakpoint].valueRange !== undefined && attributes.spacers[breakpoint].valueRange !== '' && (
                      <>
                        {BootstrapSpacers.spacersTypes.map((spacerType) => (
                          BootstrapSpacers.spacersDirection.map((spacerDirection) => {
                            const uniqueKey = `${spacerType}${spacerDirection}-${breakpoint}`;
                            const maxGrid = spacerType === 'p'
                              ? BootstrapSpacers.numberOfGrid
                              : BootstrapSpacers.numberOfGrid + 1;

                            return (
                              <RangeControl
                                key={uniqueKey}
                                allowReset={false}
                                label={
                                  (() => {
                                    let labelValue;
                                    if (attributes.spacers[breakpoint]?.valueRange?.[uniqueKey] !==
                                      undefined) {
                                      if (attributes.spacers[breakpoint].valueRange[uniqueKey] ===
                                        (BootstrapSpacers.numberOfGrid + 1)) {
                                        labelValue = 'auto';
                                      } else {
                                        labelValue = attributes.spacers[breakpoint].valueRange[uniqueKey];
                                      }
                                    } else {
                                      labelValue = 'none';
                                    }
                                    return `${uniqueKey}-${labelValue}`;
                                  })()
                                }

                                value={
                                  (() => {
                                    if (attributes.spacers[breakpoint]?.valueRange?.[uniqueKey] !==
                                      undefined) {
                                      return attributes.spacers[breakpoint].valueRange[uniqueKey];
                                    }
                                    return -1;
                                  })()
                                }

                                onChange={value => {
                                  const spacersObject = {...attributes.spacers};

                                  if (value === -1) {

                                    delete spacersObject[breakpoint].valueRange[uniqueKey];
                                  } else {

                                    spacersObject[breakpoint] = {
                                      ...spacersObject[breakpoint],
                                      valueRange: {
                                        ...spacersObject[breakpoint].valueRange,

                                        [uniqueKey]: value,
                                      },
                                    };
                                  }
                                  setAttributes(
                                    {...attributes, spacers: spacersObject});
                                }}

                                min={-1}
                                max={maxGrid}
                                withInputField={false}
                                {...props}
                              />
                            );
                          })
                        ))}
                      </>
                    )}

                  </div>
                ))}
              </PanelBody>
            </InspectorControls>
          </>

        );
      }
      return <BlockEdit {...props} />;
    };
  }, 'editSpacerClasses');

  /**
   * Save generated spacer classes
   *
   * @param {Object} props
   * @param {Object} blockType
   * @param {Object} attributes
   *
   * @return {Object} props
   */
  static saveSpacerClasses(props, blockType, attributes) {

    if (blockType.name.startsWith('starter-kit/')) {
      const spacersClasses = BootstrapSpacers.generateClasses(attributes);

      props.className = [props.className, spacersClasses].filter(Boolean).join(' ');
    }

    return props;
  };

  /**
   * Generate spacer classes function
   *
   * @param {Object} attributes
   *
   * @return {string} classes
   */
  static generateClasses(attributes) {
    const classes = [];

    Object.values(attributes.spacers).forEach((item) => {
      if (item.valueRange) {
        Object.keys(item.valueRange).forEach(i => {
          const modifiedValue = item.valueRange[i] === (BootstrapSpacers.numberOfGrid + 1)
            ? 'auto'
            : item.valueRange[i];
          const modifiedClass = `${i}-${modifiedValue}`.replace('-xs', '');
          classes.push(modifiedClass);
        });
      }
    });

    return classes.join(' ');
  }

}
