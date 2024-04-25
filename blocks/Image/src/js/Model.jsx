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

    image.width = image.width >= srcSetObj[breakpoint].viewPort ? srcSetObj[breakpoint].viewPort : image.width;

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
    setAttributes({
      srcSet: srcSetObj
    });
  }

  static setSrcSet(image, srcSetObj, setAttributes, updatedImage = false) {
    Object.keys(srcSetObj).forEach(brPoint => {
      const {viewPort} = srcSetObj[brPoint];

      // Disable breakpoint if breakpoint image with < breakpoint viewPort
      const enableBreakpoint = image.width >= viewPort;

      if (updatedImage) {
        srcSetObj[brPoint] = {
          enabled: enableBreakpoint,
          id: image.id,
          url: image.url,
          viewPort,
          startWidth: image.startWidth,
          width: viewPort,
          height: Math.trunc(viewPort / image.ratio),
          ratio: image.ratio,
        };
      } else {
        srcSetObj[brPoint] = {
          ...srcSetObj[brPoint],
          enabled: enableBreakpoint,
        };
      }

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
