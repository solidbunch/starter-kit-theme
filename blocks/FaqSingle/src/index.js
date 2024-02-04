/**
 * Block dependencies
 */
import blockMetadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {
  RichText,
  InspectorControls,
  useBlockProps
} = wp.blockEditor;
const {
  PanelBody,
  TextControl
} = wp.components;

const blockMainCssClass = 'blnb-faq';

registerBlockType(
  blockMetadata,
  {
    edit: props => {
      const {attributes, className, setAttributes} = props;

      // https://make.wordpress.org/core/2020/11/18/block-api-version-2/
      const blockProps = useBlockProps( {
        className: [blockMainCssClass, className]
      });

      return [
        <InspectorControls key="inspectorControls">
          <PanelBody title="Additional settings">
            <TextControl
              label="Mark before the question"
              value={attributes.markQuestion}
              onChange={markQuestion => {setAttributes({markQuestion});}}
            />
            <TextControl
              label="Mark before the answer"
              value={attributes.markAnswer}
              onChange={ markAnswer => {setAttributes({markAnswer});} }
            />
          </PanelBody>
        </InspectorControls>,
        <section {...blockProps} key="blockControls">
          <div className={blockMainCssClass + '__question'}>
            <span className={blockMainCssClass + '__question-mark'}>
              {attributes.markQuestion}
            </span>
            <RichText
              tagName="h4"
              multiline={false}
              className={blockMainCssClass + '__headline'}
              format="string"
              placeholder="Question here?"
              onChange={question => {setAttributes({question});}}
              value={attributes.question}
            />
          </div>
          <div className={blockMainCssClass + '__answer'}>
            <div className={blockMainCssClass + '__answer-wrapper'}>
              <span className={blockMainCssClass + '__answer-mark'}>
                {attributes.markAnswer}
              </span>
              <RichText
                tagName="div"
                multiline={false}
                className={blockMainCssClass + '__answer-text'}
                format="string"
                placeholder="Answer here?"
                onChange={answer => {setAttributes({answer});}}
                value={attributes.answer}
              />
            </div>
          </div>
        </section>
      ];
    }, // end edit
    save: props => {
      const {attributes} = props;

      // https://make.wordpress.org/core/2020/11/18/block-api-version-2/
      const blockProps = useBlockProps.save({
        className: blockMainCssClass
      });

      return (
        <section {...blockProps}>
          <div className={blockMainCssClass + '__question'}>
            <span className={blockMainCssClass + '__question-mark'}>
              {attributes.markQuestion}
            </span>
            <RichText.Content
              tagName="h4"
              multiline={false}
              className={blockMainCssClass + '__headline'}
              value={ attributes.question }
            />
          </div>

          <div className={blockMainCssClass + '__answer'}>
            <div className={blockMainCssClass + '__answer-wrapper'}>
              <span className={blockMainCssClass + '__answer-mark'}>
                {attributes.markAnswer}
              </span>
              <RichText.Content
                tagName="div"
                className={blockMainCssClass + '__answer-text'}
                multiline={false}
                value={attributes.answer}
              />
            </div>
          </div>
        </section>
      );
    }
  });
