import metadata from '../block.json';

const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, RichText, AlignmentToolbar} = wp.blockEditor;
const {PanelBody, SelectControl, BlockControls} = wp.components;

const alignTextOptions = [
  {label: 'left', value: 'text-start'},
  {label: 'center', value: 'text-center'},
  {label: 'right', value: 'text-end'},
];

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const {defaultClass,  alignText} = attributes.modification || {};
      const blockClass = `${defaultClass || ''}  ${alignText || ''}`.trim();

      return {className: blockClass};
    },

    edit: props => {
      const {attributes, setAttributes, className} = props;
      const {content, alignment} = attributes;
      
      const blockProps = useBlockProps({
        className: [className],
      });
      function onChangeContent(newContent) {
        setAttributes({content: newContent});
      }

      function onChangeAlignment(newAlignment) {
        setAttributes({alignment: newAlignment === undefined ? 'none' : newAlignment});
      }
      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Section styles">
            <SelectControl
              label="Align text"
              value={attributes.alignment || ''}
              options={alignTextOptions}
              onChange={(alignText) =>
                setAttributes({
                  modification: {
                    ...attributes.modification,
                    alignText,
                  },
                })
              }
            />
          </PanelBody>
        </InspectorControls>
      );
      
      const renderOutput = (
        // <RichText
        //   {...blockProps}
        //   tagName="p"
        //   key="blockControls"
        //   value={attributes.content}
        //   onChange={ ( content ) => setAttributes( {content} ) }
        //   placeholder="Type / to choose a block"
        // />
        <>
          <AlignmentToolbar
            value={ alignment }
            onChange={ onChangeAlignment }
          />
          <RichText
            tagName="p"
            className={ `custom-align-${alignment}` }
            value={ content }
            onChange={ onChangeContent }
            style={{textAlign: alignment}}
          />
        </>
      );
      
      return [
        renderControls,
        renderOutput,
      ];
    },

    save: (props) => {
      const {attributes} = props;
      const {content, alignment} = attributes;
      const {className} = useBlockProps.save();

      const {defaultClass, alignText} = attributes.modification || {};
      const blockClass = `${defaultClass || ''} ${alignText || ''} ${className}`.trim();
      // Create a new object for the attributes, excluding the 'class' attribute if it's empty
      const blockProps = {};

      if (blockClass) {
        blockProps.className = blockClass;
      }
      return <RichText.Content { ...blockProps } tagName="p" value={content } className={ `custom-align-${alignment}` }/>;
    },
  },
);
