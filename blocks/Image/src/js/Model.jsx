/**
 * Managing or updating the state of the data
 */
export default class Model {

  /**
   * Set attributes for Main Image
   *
   * @static
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
        altText: image.alt
      }
    );
  };

  /**
   * Setting image values at a specific breakpoint
   *
   * @static
   * @param {Object}   image
   * @param {Object}   srcSetObj
   * @param {string}   breakpoint
   * @param {Function} setAttributes
   * @return {void}
   */
  static setBreakpoint(image, srcSetObj, breakpoint, setAttributes) {

    image.width = image.width >= srcSetObj[breakpoint].viewPort ? srcSetObj[breakpoint].viewPort : image.width;
    if (!image.id) {
      srcSetObj[breakpoint] = {
        viewPort:srcSetObj[breakpoint].viewPort,
        enabled:srcSetObj[breakpoint].enabled,
      };
    } else {
      srcSetObj[breakpoint] = {
        ...srcSetObj[breakpoint],
        id: image.id,
        // ToDo add fetch image url by id to not store long data in database
        url: image.url,
        width:image.width,
        startWidth: image.width,
        ratio: image.ratio,
        height: Math.trunc(image.width / image.ratio)
      };
    }

    setAttributes({
      srcSet: srcSetObj
    });
  }

  /**
   * Validation and setting of all breakpoints when loading the main image
   *
   * @static
   * @param {Object}   image
   * @param {Object}   srcSetObj
   * @param {Function} setAttributes
   * @return {void}
   */
  static setSrcSet(image, srcSetObj, setAttributes) {
    Object.keys(srcSetObj).forEach(brPoint => {
      const {viewPort} = srcSetObj[brPoint];

      // Disable breakpoint if breakpoint image with < breakpoint viewPort
      const enableBreakpoint = image.width >= viewPort;

      srcSetObj[brPoint] = {
        ...srcSetObj[brPoint],
        enabled: enableBreakpoint,
      };
    });

    setAttributes({
      srcSet: srcSetObj
    });
  }

  /**
   * Set Width and Height in mainImage or srcSet from input
   *
   * @static
   * @param {Object} updatedAttributes
   * @param {Object} props
   * @param {string} breakpoint
   *
   * @return {void}
   */
  static changeDimension(updatedAttributes, props, breakpoint = '') {
    const {attributes,setAttributes} = props;
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
