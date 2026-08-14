import blockMetadata from '../block.json';
const blocksAllowed = ['starter-kit/list-item'];
const blockTemplate = [['starter-kit/list-item']];

const {registerBlockType} = wp.blocks;
const {InspectorControls, InnerBlocks, useBlockProps, BlockControls} = wp.blockEditor;
const {ToolbarGroup, ToolbarButton, PanelBody, TextControl} = wp.components;

const getListStartAttribute = (listType, start) =>
  listType === 'ol' && Number.isInteger(start) && start !== 1 ? start : undefined;

registerBlockType(blockMetadata, {
  edit: props => {
    const {className, attributes, setAttributes} = props;
    const {listType, start} = attributes;

    const startAttr = getListStartAttribute(listType, start);
    const blockProps = useBlockProps({className, ...(startAttr !== undefined ? {start: startAttr} : {})});

    const onChangeListType = (type) => {
      setAttributes({listType: type});
    };

    const onChangeStart = (value) => {
      const parsed = Number(value);
      setAttributes({start: value !== '' && Number.isInteger(parsed) ? parsed : undefined});
    };

    const renderControls = (
      <>
        <InspectorControls key="inspectorControls">
          <div className="card m-3">
            <div className="cardbody">
              <p className='text-center mb-0'>{listType === 'ol' ? 'Ordered List' : 'Unordered List'}</p>
            </div>
          </div>
          {listType === 'ol' && (
            <PanelBody title="Ordered List Settings">
              <TextControl
                label="Start value"
                type="number"
                value={start ?? ''}
                onChange={onChangeStart}
              />
            </PanelBody>
          )}
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
    const {listType, start} = attributes;
    const TagName = listType === 'ul' ? 'ul' : 'ol';
    const {className} = useBlockProps.save();
    const blockProps = className ? {className} : {};

    const startAttr = getListStartAttribute(listType, start);
    if (startAttr !== undefined) {
      blockProps.start = startAttr;
    }

    return (
      <TagName {...blockProps}>
        <InnerBlocks.Content />
      </TagName>
    );
  }
});
