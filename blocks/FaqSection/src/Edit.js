import faqSingleBlockMetadata from "../../FaqSingle/block.json";

/**
 * Internal component libraries
 */
const {Component} = wp.element;
const {
  InnerBlocks
} = wp.blockEditor;
const {Button} = wp.components;
const ALLOWED_BLOCKS = [faqSingleBlockMetadata.name];
const verifySchemaButtonText = 'Verify FAQs schema.org';

export default class Edit extends Component {

  componentDidUpdate() {
    const {enableSchema} = this.props;

    if (enableSchema === 'enabled') {
      this.parseSchemaData();
    }
  }

  parseSchemaData = () => {
    const {setAttributes, attributes} = this.props;
    const faqSectionClientData = wp.data.select('core/block-editor').getBlock(this.props.clientId);
    let data = [];
    if (faqSectionClientData.innerBlocks.length) {
      for (let faqSingleBlockData of faqSectionClientData.innerBlocks) {
        let question = faqSingleBlockData.attributes.question;
        let answer = faqSingleBlockData.attributes.answer;

        // When the faqSingle is added the values are empty
        let faq = {
          question,
          // Remove all br tags
          answer: answer ? answer.replace(/<br\s*\/?>/gi, ' ') : ''
        };

        data.push(faq);
      }
    }

    // On the componentDidMount attributes.data is undefined
    if (this.isObject(attributes.data) && this.deepEqual(attributes.data, data)) {
      return;
    }

    setAttributes({data});
  };

  deepEqual = (object1, object2) => {
    const keys1 = Object.keys(object1);
    const keys2 = Object.keys(object2);

    if (keys1.length !== keys2.length) {
      return false;
    }

    for (const key of keys1) {
      const val1 = object1[key];
      const val2 = object2[key];
      const areObjects = this.isObject(val1) && this.isObject(val2);
      if (
        areObjects && !this.deepEqual(val1, val2) ||
        !areObjects && val1 !== val2
      ) {
        return false;
      }
    }

    return true;
  };

  isObject = (object) => {
    return object != null && typeof object === 'object';
  };

  /**
   * Verify schema org button as the rich text component has bug to not trigger parent rerendering when we paste
   * html using copy/paste, so we need to have a button to click so we are sure all schema org is created.
   *
   * This should always be ok, but just in case as this is a bug, we need to click the button before we exit or save post
   *
   * @param {Event} event
   */
  verifySchema = (event) => {
    const button = event.currentTarget;

    button.innerText = 'Verifying.....';
    setTimeout(() => {
      button.innerText = 'Verified. Thank you.';
    }, 700);

    setTimeout(() => {
      button.innerText = verifySchemaButtonText;
      this.parseSchemaData();
    }, 1500);
  };

  render() {
    const {blockprops, cssclass, enableSchema} = this.props;

    const buttonWrapper = enableSchema == 'enabled' ? (
      <div className={cssclass + '-verify-schema'}>
        <Button
          className="is-primary"
          onClick={this.verifySchema}>
          {verifySchemaButtonText}
        </Button>
      </div>
    ) : null;

    return (
      <div {...blockprops}>
        {buttonWrapper}
        <div className={cssclass}>
          <InnerBlocks
            allowedBlocks={ALLOWED_BLOCKS}
            orientation="vertical"
          />
        </div>
        {buttonWrapper}
      </div>
    );
  }
}
