import metadata from '../block.json';
import transforms from './transforms';
import {hljs, languages} from './modules/languages';

const {registerBlockType} = wp.blocks;
const {
  useBlockProps,
  PlainText,
  AlignmentToolbar,
  BlockControls,
  InspectorControls,
} = wp.blockEditor;

const {PanelBody, SelectControl} = wp.components;
const {useEffect} = wp.element;

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

    useEffect(() => {
      // Highlight the code when content or language changes
      if (hljs) {
        const codeElement = document.querySelector(`.${blockCustomClass} code`);
        if (codeElement) {
          // If the language is specified, we use the standard highlight
          if (language && language !== 'auto') {
            hljs.highlightElement(codeElement);
          } else {
            // auto + fallback
            const result = hljs.highlightAuto(codeElement.textContent);
            codeElement.innerHTML = result.value;
            codeElement.classList.add('hljs', `language-${result.language}`);
          }
        }
      }

    }, [content, language]);

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

    return (
      <pre {...blockProps}>
        <code className={`language-${language}`}>
          {content}
        </code>
      </pre>
    );
  },

  transforms,
});
