import metadata from '../block.json';
import transforms from './transforms';
import {languages} from './modules/languages';

const {registerBlockType} = wp.blocks;
const {useBlockProps, PlainText, AlignmentToolbar, BlockControls, InspectorControls} = wp.blockEditor;

const {PanelBody, SelectControl} = wp.components;

const blockCustomClass = 'sk-block-code';

registerBlockType(metadata, {
  edit: (props) => {
    const {attributes, setAttributes, className} = props;
    const {content, alignment, language = 'javascript'} = attributes;

    const blockProps = useBlockProps({
      className: [className, blockCustomClass],
    });

    function onChangeContent(newContent) {
      setAttributes({content: newContent});
    }

    function onChangeAlignment(newAlignment) {
      setAttributes({alignment: newAlignment});
    }

    function onChangeLanguage(newLang) {
      setAttributes({language: newLang});
    }

    return (
      <>
        <InspectorControls>
          <PanelBody title="Code Language">
            <SelectControl
              label="Language"
              value={language}
              options={languages}
              onChange={onChangeLanguage}
            />
          </PanelBody>
        </InspectorControls>

        <BlockControls>
          <AlignmentToolbar value={alignment} onChange={onChangeAlignment}/>
        </BlockControls>

        <pre {...blockProps}>
          <PlainText
            tagName="code"
            className={`language-${language}`}
            value={content}
            onChange={onChangeContent}
            style={{textAlign: alignment}}
            placeholder="Write code..."
          />
        </pre>
      </>
    );
  },

  save: (props) => {
    const {attributes, className} = props;
    const {content, alignment, language} = attributes;

    const classes = [
      blockCustomClass,
      className,
      {
        left: 'text-start',
        right: 'text-end',
        center: 'text-center',
      }[alignment] || '',
    ]
      .filter(Boolean)
      .join(' ');

    const blockProps = useBlockProps.save({
      className: classes,
    });

    // If the language is specified, we use the standard highlight, if not, we use the auto highlight
    return (
      <pre {...blockProps}>
        <code className={language !== 'auto' ? `language-${language}` : undefined}>
          {content}
        </code>
      </pre>
    );
  },

  transforms,
});
