/**
 * Block editor helpers
 */
export default class Utils {

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

  static getDimensionHiDPI(image, hidpi, scratch = false){

    if (!hidpi && scratch) {
      return image;
    }

    if (hidpi) {
      image.startWidth = Math.trunc(image.startWidth / 2);
    } else {
      image.startWidth = Math.trunc(image.startWidth * 2);
    }

    image.width = image.startWidth;
    image.height = Math.trunc(image.width / image.ratio);

    return image;
  }

}
