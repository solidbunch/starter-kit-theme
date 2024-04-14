/**
 * Managing or updating the state of the data
 */
export default class Model {

  static setMainImage(image, setAttributes) {

    setAttributes(
      {
        mainImage: {
          id: image.id,
          url: image.url,
          startWidth: image.startWidth,
          width: image.width,
          height: image.height,
          ratio: image.ratio
        },
      }
    );
  };

  static setBreakpoint(image, srcSetObj, breakpoint, setAttributes) {

    srcSetObj[breakpoint] = {
      ...srcSetObj[breakpoint],
      id: image.id,
      url: image.url,
      width: image.width >= srcSetObj[breakpoint].viewPort ? srcSetObj[breakpoint].viewPort : image.width,
      startWidth: image.width,
      ratio: image.ratio,
      height: Math.trunc(image.width / image.ratio)
    };
    // todo  fix height to viewPort
    setAttributes({
      srcSet: srcSetObj
    });
  }

  static setSrcSet(image, srcSetObj, hideBiggerBreakpoints, setAttributes) {

    Object.keys(srcSetObj).forEach(brPoint => {
      const {viewPort} = srcSetObj[brPoint];
      const validateSize = image.width >= viewPort;

      // hide breakpoint, when image with < breakpoint viewPort
      if (hideBiggerBreakpoints && image.width < viewPort) {
        srcSetObj[brPoint] = {
          viewPort
        };
      } else {
        srcSetObj[brPoint] = {
          ...srcSetObj[brPoint],
          url: image.url,
          id: image.id,
          ratio: image.ratio,
          width: viewPort,
          startWidth: image.startWidth,
          height: Math.trunc(viewPort / image.ratio),
          validateSize
        };
      }

    });

    setAttributes({
      srcSet: srcSetObj
    });
  }

  //Set Width and Height in mainImage or srcSet
  static changeDimension(type, breakpoint, updatedAttributes,setAttributes,attributes) {
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
