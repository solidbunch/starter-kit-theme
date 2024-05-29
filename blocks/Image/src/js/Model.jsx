/**
 * Managing or updating the state of the data
 */
export default class Model {

  /**
   * Set attributes for Main Image
   *
   * @param {Object}   image
   * @param {Function} setAttributes
   * @return {void}
   */
  static setMainImage(image, setAttributes) {

    setAttributes(
      {
        mainImage: {
          id: image.id,
          url: image.url,
          startWidth: image.startWidth,
          ratio: image.ratio,
        },
        altText: image.alt,
      },
    );
  };

  /**
   * Setting image values at a specific breakpoint
   *
   * @param {Object} image
   * @param {string} breakpoint
   * @param {Object} props
   *
   * @return {void}
   */
  static setBreakpoint(image, breakpoint, props) {

    const {attributes, setAttributes} = props;
    const srcSetObj = {...attributes.srcSet};

    image.startWidth = image.startWidth >= srcSetObj[breakpoint].viewPort
      ? srcSetObj[breakpoint].viewPort
      : image.startWidth;

    if (!image.id) {
      srcSetObj[breakpoint] = {
        viewPort: srcSetObj[breakpoint].viewPort,
        enabled: srcSetObj[breakpoint].enabled,
      };
    } else {
      srcSetObj[breakpoint] = {
        viewPort: srcSetObj[breakpoint].viewPort,
        enabled: srcSetObj[breakpoint].enabled,
        id: image.id,
        // ToDo add fetch image url by id to not store long data in database
        url: image.url,
        startWidth: image.startWidth,
        ratio: image.ratio,
      };
    }

    setAttributes({
      srcSet: srcSetObj,
    });
  }

  /**
   * Validation and setting of all breakpoints when loading the main image
   *
   * @param {Object} image
   * @param {Object} props
   *
   * @return {void}
   */
  static setSrcSet(image, props) {
    const {attributes, setAttributes} = props;
    const srcSetObj = {...attributes.srcSet};

    Object.keys(srcSetObj).forEach(brPoint => {
      const {viewPort} = srcSetObj[brPoint];

      // Disable breakpoint if breakpoint image with < breakpoint viewPort
      const enableBreakpoint = image.id && image.startWidth && image.startWidth >= viewPort;

      srcSetObj[brPoint] = {
        ...srcSetObj[brPoint],
        enabled: enableBreakpoint,
      };
    });

    setAttributes({
      srcSet: srcSetObj,
    });
  }

  /**
   * Set Width and Height in mainImage or srcSet from input
   *
   * @param {Object} updatedAttributes
   * @param {Object} props
   * @param {string} breakpoint
   *
   * @return {void}
   */
  static changeDimension(updatedAttributes, props, breakpoint = '') {
    const {attributes, setAttributes} = props;
    let newAttributes = {};

    if (breakpoint) {
      newAttributes = {
        srcSet: {
          ...attributes.srcSet,
          [breakpoint]: {...attributes.srcSet[breakpoint], ...updatedAttributes},
        },
      };
    } else {
      newAttributes = {mainImage: {...attributes.mainImage, ...updatedAttributes}};
    }

    setAttributes(newAttributes);
  };

}
