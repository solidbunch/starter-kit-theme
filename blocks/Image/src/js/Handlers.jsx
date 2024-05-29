import Model from './Model';
import Utils from './Helper/Utils';

const {useDispatch} = wp.data;
const {store: noticesStore} = wp.notices;

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

      let image = {
        id: fullMedia.id,
        url: fullMedia.url,
        startWidth: fullMedia.media_details ? fullMedia.media_details.width : fullMedia.width,
        alt: fullMedia.alt,
      };

      image.ratio = image.startWidth / (fullMedia.media_details ? fullMedia.media_details.height : fullMedia.height);

      if (breakpoint) {

        Model.setBreakpoint(image, breakpoint, props);

        return;
      }

      image = Utils.getDimensionHiDPI(image, attributes.hidpi, true);

      Model.setMainImage(image, setAttributes);

      Model.setSrcSet(image, props);

    }).catch((error) => {
      // eslint-disable-next-line no-console
      console.error('Errors:', error);
    });
  };

  /**
   * Run updates when new image added by url
   *
   * @param {string} newURL
   * @param {Object} props
   *
   * @return {void}
   */
  static onSelectURL(newURL, props) {

    const {attributes, setAttributes} = props;

    const img = new Image();
    img.src = newURL;

    img.onload = () => {
      let image = {
        id: "",
        url: newURL,
        startWidth: img.naturalWidth,
        alt: "",
        ratio: (img.naturalWidth / img.naturalHeight)
      };

      image = Utils.getDimensionHiDPI(image, attributes.hidpi, true);

      Model.setMainImage(image, setAttributes);

      Model.setSrcSet(image, props);

    };
  };

  /**
   * Click on checkbox hidpi
   *
   * @param {boolean} checked
   * @param {Object}  props
   *
   * @return {void}
   */
  static onChangeHiDPI(checked, props) {

    const {attributes, setAttributes} = props;

    let image = attributes.mainImage;

    image = Utils.getDimensionHiDPI(image, checked);

    Model.setMainImage(image, setAttributes);
    Model.setSrcSet(image, props);

    setAttributes({hidpi: checked});
  }

  /**
   * Permission to enter numbers only
   *
   * @static
   * @param {Event} event
   * @return {void}
   */
  static onNumberInputKeyPress(event) {
    const allowedCharacters = /[0-9]/;
    if (!allowedCharacters.test(event.key)) {
      event.preventDefault();
    }
  };

  /**
   * Change Width and Height in mainImage or srcSet
   *
   * @param {Event}  event
   * @param {Object} props
   * @param {string} breakpoint
   *
   * @return {void}
   */
  static onWidthInputChange(event, props, breakpoint = '') {
    const {attributes} = props;

    // Extract numeric value from `event` and parse it to an integer, defaulting to NaN if non-numeric
    let newWidth = parseInt(event.replace(/\D/g, ''), 10);

    newWidth = (isNaN(newWidth) || newWidth === 0) ? '' : newWidth;

    let startWidth = attributes.mainImage.startWidth;

    if (breakpoint) {
      // Decide based on the existence of an `id` in the srcSet for the given breakpoint
      startWidth = attributes.srcSet[breakpoint].startWidth
        ? attributes.srcSet[breakpoint].startWidth
        : attributes.srcSet[breakpoint].viewPort;
    }

    // Adjust `newWidth` to not exceed `startWidth` if `newWidth` is a number
    newWidth = (typeof newWidth === 'number' && newWidth > startWidth) ? startWidth : newWidth;

    Model.changeDimension({width: newWidth}, props, breakpoint);

  };

  /**
   * Reset breakpoint image attributes to mainImage (default)
   *
   * @param {string} breakpoint
   * @param {Object} props
   *
   * @return {void}
   */
  static onResetImage(breakpoint, props) {
    const image = {};
    Model.setBreakpoint(image, breakpoint, props);
  };

  static onUploadError(message) {
    const {createErrorNotice} = useDispatch( noticesStore );
    createErrorNotice(message, {type: 'snackbar'});
  }

}
