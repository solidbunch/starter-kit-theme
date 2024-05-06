/**
 * Block editor helpers
 */
export default class Utils {

  /**
   * the function processes the incoming values from the Fetch Priority select and returns the required string
   *
   * @param {string} value
   * @return {string}
   */
  static getPriorityText(value) {
    switch (value) {
    case 'auto':
      return 'Default mode, which indicates no preference for the fetch priority. The browser decides what is best for the user.';
    case 'low':
      return 'Fetch the image at a low priority relative to other images.';
    case 'high':
      return 'Fetch the image at a high priority relative to other images.';
    default:
      return '';
    }
  }

  /**
   * setting the image size to 2 times smaller or the original size
   *
   * @param {Object}  image
   * @param {boolean} hidpi
   * @param {boolean} [scratch=false]
   *
   * @return {Object}
   */
  static getDimensionHiDPI(image, hidpi, scratch = false) {

    if (!hidpi && scratch) {
      return image;
    }

    if (hidpi) {
      image.startWidth = Math.trunc(image.startWidth / 2);
    } else {
      image.startWidth = Math.trunc(image.startWidth * 2);
    }

    return image;
  }

  /**
   * Returns the actual image width depending on the existence of different width attributes
   *
   * @param {Object}  attributes
   * @param {string}  [breakpoint='']
   * @param {boolean} [showEmpty=false]
   *
   * @return {number}
   */
  static getImageWidth(attributes, breakpoint = '', showEmpty = false) {
    let resultWidth = '';

    if (!breakpoint) {

      // Use main image width details
      const mainImage = attributes.mainImage;
      if (showEmpty) {
        resultWidth = mainImage.width !== undefined ? mainImage.width : mainImage.startWidth;
      } else {
        resultWidth = mainImage.width || mainImage.startWidth;
      }
    } else {

      // Use breakpoint specific width details
      const bpAttributes = attributes.srcSet[breakpoint];
      if ((showEmpty && bpAttributes.width !== undefined) || bpAttributes.width) {
        resultWidth = bpAttributes.width;
      } else {
        resultWidth = bpAttributes.startWidth || bpAttributes.viewPort;
      }
    }

    return resultWidth;
  }

  /**
   * Returns the actual image height depending on the existence of different width attributes
   *
   * @param {Object} attributes
   * @param {string} [breakpoint='']
   *
   * @return {number}
   */
  static getImageHeight(attributes, breakpoint = '') {

    const imageWidth = Utils.getImageWidth(attributes, breakpoint);
    const ratio = (breakpoint && attributes.srcSet[breakpoint].ratio)
      ? attributes.srcSet[breakpoint].ratio
      : attributes.mainImage.ratio;

    return Math.trunc(imageWidth / ratio);
  }

}
