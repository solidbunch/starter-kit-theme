/**
 * Managing or updating the state of the data
 */
export default class Model {

  /**
   * set attributes for Main Image
   *
   * @static
   * @param {*} image
   * @param {*} setAttributes
   */
  static setMainImage(image, setAttributes) {

    setAttributes(
      {
        mainImage: {
          id: image.id,
          url: image.url,
          startWidth: image.startWidth,
          width: image.width,
          height: image.height,
          ratio: image.ratio,
        },
        altText: image.alt
      }
    );
  };

  /**
   * Description placeholder
   *
   * @static
   * @param {*}      image
   * @param {*}      srcSetObj
   * @param {string} breakpoint
   * @param {*}      setAttributes
   */
  static setBreakpoint(image, srcSetObj, breakpoint, setAttributes) {

    image.width = image.width >= srcSetObj[breakpoint].viewPort ? srcSetObj[breakpoint].viewPort : image.width;
    if (!image) {
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

  //Set Width and Height in mainImage or srcSet
  static changeDimension(type, breakpoint, updatedAttributes, props) {
    const {attributes,setAttributes} = props;
    let newAttributes = {};

    if (type === 'mainImage') {
      newAttributes = {mainImage: {...attributes.mainImage, ...updatedAttributes}};
    } else if (type === 'srcSet') {
      newAttributes = {
        srcSet: {
          ...attributes.srcSet,
          [breakpoint]: {...attributes.srcSet[breakpoint], ...updatedAttributes},
        },
      };
    }

    setAttributes(newAttributes);
  };

}
