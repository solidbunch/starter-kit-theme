/**
 * Managing or updating the state of the data
 */
export default class Model {

  static setMainImage(image, setAttributes) {

    setAttributes(
      {
        mainImage: {
          id: image.id,
          src: image.url,
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
      imageUrl: image.url,
      width: image.width >= srcSetObj[breakpoint].viewPort ? srcSetObj[breakpoint].viewPort : image.width,
      startWidth: image.width,
      ratio: image.ratio,
      height: Math.trunc(image.width / image.ratio)
    };

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
        srcSetObj[brPoint] = {};
      } else {
        srcSetObj[brPoint] = {
          ...srcSetObj[brPoint],
          imageUrl: image.url,
          id: image.id,
          ratio: image.ratio,
          width: viewPort,
          height: Math.trunc(viewPort / image.ratio),
          validateSize
        };
      }

    });

    setAttributes({
      srcSet: srcSetObj
    });
  }

}
