import Model from './Model';
import Utils from './Helper/Utils';

/**
 * Block editor handlers
 */
export default class Handlers {

  static onChangeImage(media, props, breakpoint = null) {

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

        Model.setBreakpoint(image, srcSetObj, breakpoint, setAttributes);

        return;
      }

      image = Utils.getDimensionHiDPI(image, attributes.hidpi, true);

      Model.setMainImage(image, setAttributes);

      Model.setSrcSet(image, srcSetObj, hideBiggerBreakpoints, setAttributes);

    }).catch((error) => {
      // eslint-disable-next-line no-console
      console.error("Errors:", error);
    });
  };

  static onChangeHiDPI(checked, props) {

    const {attributes, setAttributes} = props;
    const srcSetObj = {...attributes.srcSet};
    const hideBiggerBreakpoints = attributes.hideBiggerBreakpoints || true;

    let image = attributes.mainImage;

    image = Utils.getDimensionHiDPI(image, checked);

    Model.setMainImage(image, setAttributes);
    Model.setSrcSet(image, srcSetObj, hideBiggerBreakpoints, setAttributes);

    setAttributes({hidpi: checked});
  }

}
