import blockMetadata from '../block.json';
const blocksAllowed = ['starter-kit/list-item'];
const blockTemplate = [['starter-kit/list-item']];

const {registerBlockType} = wp.blocks;
const {InspectorControls, InnerBlocks, useBlockProps, BlockControls} = wp.blockEditor;
const {ToolbarGroup, ToolbarButton} = wp.components;

registerBlockType(blockMetadata, {
  edit: props => {
    const {className, attributes, setAttributes} = props;
    const {listType} = attributes;

    const blockProps = useBlockProps({className});

    const onChangeListType = (type) => {
      setAttributes({listType: type});
    };

    const renderControls = (
      <>
        <InspectorControls key="inspectorControls">
          <div className="card m-3">
            <div className="cardbody">
              <p className='text-center mb-0'>{listType === 'ol' ? 'Ordered List' : 'Unordered List'}</p>
            </div>
          </div>
        </InspectorControls>
        <BlockControls key="blockControls">
          <ToolbarGroup>
            {['ul', 'ol'].map(type => (
              <ToolbarButton
                key={type}
                icon={`editor-${type}`}
                label={`${type === 'ul' ? 'Unordered' : 'Ordered'} List`}
                isPressed={listType === type}
                onClick={() => onChangeListType(type)}
              />
            ))}
          </ToolbarGroup>
        </BlockControls>
      </>
    );
    const TagName = listType === 'ul' ? 'ul' : 'ol';
    const renderOutput = (
      <TagName {...blockProps} key="list">
        <InnerBlocks
          allowedBlocks={blocksAllowed}
          template={blockTemplate}
          templateLock={false}
          orientation="vertical"
        />
      </TagName>
    );

    return [
      renderControls,
      renderOutput
    ];
  },
  save: ({attributes}) => {
    const {listType} = attributes;
    const TagName = listType === 'ul' ? 'ul' : 'ol';
    const {className} = useBlockProps.save();
    const blockProps = className ? {className} : {};

    return (
      <TagName {...blockProps}>
        <InnerBlocks.Content />
      </TagName>
    );
  }
});
