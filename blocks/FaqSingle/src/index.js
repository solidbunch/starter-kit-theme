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

const blockMainCssClass = 'accordion-item';

registerBlockType(
  blockMetadata,
  {
    edit: props => {
      const {attributes, className, setAttributes, clientId} = props;

      const {accordionItemId} = attributes;
      if (!accordionItemId) {
        setAttributes( {accordionItemId: `accordion-item-${clientId}`} );
      }
      // https://make.wordpress.org/core/2020/11/18/block-api-version-2/
      const blockProps = useBlockProps( {
        className: [blockMainCssClass, className]
      });

      const renderControls = (
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
        </InspectorControls>
      );

      const renderOutput = (
        <section {...blockProps} key="blockControls">
          <div className={'accordion-header d-flex'}>
            <span className={'col-auto pe-2'}>
              {attributes.markQuestion}
            </span>
            <RichText
              tagName="h4"
              multiline={false}
              className={'col'}
              format="string"
              placeholder="Question here?"
              onChange={question => {setAttributes({question});}}
              value={attributes.question}
            />
          </div>
          <div className={'accordion-collapse'}>
            <div className={'accordion-body d-flex'}>
              <span className={'col-auto pe-2'}>
                {attributes.markAnswer}
              </span>
              <RichText
                tagName="div"
                multiline={false}
                className={'col'}
                format="string"
                placeholder="Answer here?"
                onChange={answer => {setAttributes({answer});}}
                value={attributes.answer}
              />
            </div>
          </div>
        </section>
      );

      return [
        renderControls,
        renderOutput
      ];
    }, // end edit
    save: props => {
      const {attributes} = props;
      const {accordionItemId} = attributes;
      // https://make.wordpress.org/core/2020/11/18/block-api-version-2/
      const blockProps = useBlockProps.save({
        className: blockMainCssClass
      });

      return (
        <section {...blockProps}>
          <h2 className={'accordion-header'}>
            <RichText.Content
              tagName="button"
              multiline={false}
              type="button"
              className={'accordion-button collapsed'}
              data-bs-toggle="collapse"
              data-bs-target={`#${accordionItemId}`}
              aria-expanded="false"
              value={ attributes.question }
            />
          </h2>

          <div className={'accordion-collapse collapse'} id={accordionItemId}>
            <div className={'accordion-body'}>
              <RichText.Content
                tagName="p"
                className={'__answer-text mb-0'}
                multiline={false}
                value={attributes.answer}
              />
            </div>
          </div>
        </section>
      );
    }
  });
