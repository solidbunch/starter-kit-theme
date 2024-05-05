/**
 * Block editor helpers
 */
export default class Utils {

  /**
   * the function processes the incoming values from the Fetch Priority select and returns the required string
   *
   * @static
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
   * @static
   * @param {Object}  image
   * @param {boolean} hidpi
   * @param {boolean} [scratch=false]
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

    image.height = Math.trunc(image.width / image.ratio);

    return image;
  }

  static showWidth(attributes, showEmpty = false, breakpoint = '') {
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

}
