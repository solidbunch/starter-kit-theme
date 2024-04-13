/**
 * Block editor handlers
 */
export default class EditorHandlers {

  static changeImage(media, props, breakpoint = null) {

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
      const hideBiggerBreakpoints = attributes.hideBiggerBreakpoints || true;

      let image = {
        id: fullMedia.id,
        url: fullMedia.url,
        width: fullMedia.media_details ? fullMedia.media_details.width : fullMedia.width,
        height: fullMedia.media_details ? fullMedia.media_details.height : fullMedia.height,
      };
      image.ratio = image.width / image.height;
      image.startWidth =  image.width;

      if (breakpoint) {

        EditorHandlers.updateBreakpoint(image, srcSetObj, breakpoint, setAttributes);

        return;
      }

      image = EditorHandlers.setDimensionHiDPI(image, attributes.hidpi);

      EditorHandlers.updateMainImage(image, setAttributes);

      EditorHandlers.updateSrcSet(image, srcSetObj, hideBiggerBreakpoints, setAttributes);

    }).catch((error) => {
      // eslint-disable-next-line no-console
      console.error("Errors:", error);
    });
  };

  static updateMainImage(image, setAttributes) {

    setAttributes(
      {
        mainImage: {
          id: image.id,
          src: image.url,
          startWidth: image.width,
          width: image.width,
          height: image.height,
          ratio: image.ratio
        },
      }
    );
  };

  static updateBreakpoint(image, srcSetObj, breakpoint, setAttributes) {

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

  static setDimensionHiDPI(image, hidpi){

    if (!hidpi) {
      return image;
    }

    image.width = Math.trunc(image.width / 2);
    image.startWidth = image.width;
    image.height = Math.trunc(image.width / image.ratio);

    return image;
  }

  static updateSrcSet(image, srcSetObj, hideBiggerBreakpoints, setAttributes) {

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
