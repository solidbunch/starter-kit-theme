import Model from './Model';
import Utils from './Helper/Utils';

/**
 * Block editor handlers
 */
export default class Handlers {

  /**
   * Add or update existing main or breakpoint image
   *
   * @param {Object} media
   * @param {Object} props
   * @param {string} breakpoint
   *
   * @return {Promise}
   */
  static onChangeImage(media, props, breakpoint = '') {

    return new Promise((resolve) => {
      if (media.id) {
        resolve(media);
      } else {
        const waitForData = setInterval(() => {
          if (media.id) {
            clearInterval(waitForData);
            resolve(media);
          }
        }, 100); // reload 100
      }
    }).then((fullMedia) => {

      const {attributes, setAttributes} = props;
      const srcSetObj = {...attributes.srcSet};

      let image = {
        id: fullMedia.id,
        url: fullMedia.url,
        startWidth: fullMedia.media_details ? fullMedia.media_details.width : fullMedia.width,
        height: fullMedia.media_details ? fullMedia.media_details.height : fullMedia.height,
        alt: fullMedia.alt
      };
      image.ratio = image.width / image.height;

      if (breakpoint) {

        Model.setBreakpoint(image, srcSetObj, breakpoint, setAttributes);

        return;
      }

      image = Utils.getDimensionHiDPI(image, attributes.hidpi, true);

      Model.setMainImage(image, setAttributes);

      Model.setSrcSet(image, srcSetObj, setAttributes);

    }).catch((error) => {
      // eslint-disable-next-line no-console
      console.error("Errors:", error);
    });
  };

  /**
   * Click on checkbox hidpi
   *
   * @static
   * @param {boolean} checked
   * @param {Object}  props
   * @return {void}
   */
  static onChangeHiDPI(checked, props) {

    const {attributes, setAttributes} = props;
    const srcSetObj = {...attributes.srcSet};

    let image = attributes.mainImage;

    image = Utils.getDimensionHiDPI(image, checked);

    Model.setMainImage(image, setAttributes);
    Model.setSrcSet(image, srcSetObj, setAttributes);

    setAttributes({hidpi: checked});
  }

  /**
   * Permission to enter numbers only
   *
   * @static
   * @param {Event} event
   * @return {void}
   */
  static onWidthInputKeyPress(event) {
    const allowedCharacters = /[0-9]/;
    if (!allowedCharacters.test(event.key)) {
      event.preventDefault();
    }
  };

  /**
   * Setting a value to the input if nothing is entered there. When losing focus from the input
   *
   * @static
   * @param {Event}  event
   * @param {Object} props
   * @param {string} breakpoint
   * @return {void}
   */
  static onWidthInputBlur(event, props, breakpoint = '') {
    const {attributes} = props;

    if (event.target.value === "") {
      if (breakpoint === null) {
        const {startWidth, ratio} = attributes.mainImage;
        const newHeight = Math.trunc(startWidth / ratio);
        Model.changeDimension( {width: startWidth, height: newHeight}, props, breakpoint);
      } else {

        let {startWidth, ratio} = breakpoint && attributes.srcSet[breakpoint].id ? attributes.srcSet[breakpoint] : attributes.mainImage;
        let newWidth = startWidth;
        if (breakpoint && newWidth > attributes.srcSet[breakpoint].viewPort) newWidth = attributes.srcSet[breakpoint].viewPort;

        const newHeight = Math.trunc(newWidth / ratio);
        Model.changeDimension({width: newWidth, height: newHeight}, props, breakpoint);
      }
    }
  };

  /**
   * Change Width and Height in mainImage or srcSet
   *
   * @static
   * @param {Event}  event
   * @param {Object} props
   * @param {string} breakpoint
   * @return {void}
   */
  static onWidthInputChange(event, props, breakpoint = '') {
    const {attributes} = props;
    let newWidth = parseInt(event.replace(/\D/g, ''), 10);
    if (isNaN(newWidth)) {
      console.log(newWidth);
      newWidth = '';
    }

    let {startWidth, ratio} = breakpoint && attributes.srcSet[breakpoint].id ? attributes.srcSet[breakpoint] : attributes.mainImage;
    if (newWidth > startWidth) newWidth = startWidth;

    if (breakpoint && newWidth > attributes.srcSet[breakpoint].viewPort ) newWidth = attributes.srcSet[breakpoint].viewPort;

    let newHeight = Math.trunc(newWidth / ratio);

    Model.changeDimension({width: newWidth, height: newHeight}, props, breakpoint);

  };

  /**
   * Reset attributes to Default (Main Image)
   *
   * @static
   * @param {string} breakpoint
   * @param {Object} props
   * @return {void}
   */
  static onResetImage(breakpoint, props) {
    const {attributes, setAttributes} = props;
    const srcSetObj = {...attributes.srcSet};
    let image = {};
    Model.setBreakpoint(image, srcSetObj, breakpoint, setAttributes);
  };

}
