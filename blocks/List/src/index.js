import blockMetadata from '../block.json';
const blocksAllowed = ['starter-kit/list-item'];
const blockTemplate = [['starter-kit/list-item']];

const {registerBlockType} = wp.blocks;
const {InspectorControls, InnerBlocks, useBlockProps, BlockControls} = wp.blockEditor;
const {ToolbarGroup, ToolbarButton} = wp.components;

const blockMainCssClass = '';

registerBlockType(blockMetadata, {
  edit: props => {
    const {className, attributes, setAttributes} = props;
    const {listType} = attributes;

    const blockProps = useBlockProps({
      className: [blockMainCssClass, className]
    });

    const onChangeListType = (type) => {
      setAttributes({listType: type});
    };

    const renderControls = (
      <InspectorControls key="inspectorControls">
        <h1>{listType === 'ol' ? 'Ordered List' : 'Unordered List'}</h1>
      </InspectorControls>
    );

    const renderBlockControls = (
      <BlockControls key="blockControls">
        <ToolbarGroup>
          <ToolbarButton
            icon="editor-ul"
            label="Unordered List"
            isPressed={listType === 'ul'}
            onClick={() => onChangeListType('ul')}
          />
          <ToolbarButton
            icon="editor-ol"
            label="Ordered List"
            isPressed={listType === 'ol'}
            onClick={() => onChangeListType('ol')}
          />
        </ToolbarGroup>
      </BlockControls>
    );

    const TagName = listType === 'ul' ? 'ul' : 'ol';

    const renderOutput = (
      <TagName {...blockProps}>
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
      renderBlockControls,
      renderOutput
    ];
  },
  save: ({attributes}) => {
    const {listType} = attributes;
    const TagName = listType === 'ul' ? 'ul' : 'ol';

    const blockProps = useBlockProps.save({
      className: blockMainCssClass
    });

    return (
      <TagName {...blockProps}>
        <InnerBlocks.Content />
      </TagName>
    );
  }
});
