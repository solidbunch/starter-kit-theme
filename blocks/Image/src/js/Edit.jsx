import Handlers from './Handlers';
import Utils from './Helper/Utils';

const {useDispatch} = wp.data;
const {store: noticesStore} = wp.notices;

/**
 * Internal block libraries
 */
const {InspectorControls, useBlockProps, MediaPlaceholder} = wp.blockEditor;
const {PanelBody, SelectControl, CheckboxControl, TextControl, TextareaControl, TabPanel} = wp.components;
const {useState} = wp.element;

const ALLOWED_MEDIA_TYPES = ['image'];

/**
 * Block editor class
 */
export default class Edit {

  /**
   * Render Controls(Sidebar in right part) in Editor
   *
   * @param {Object} props
   * @param {Object} metadata
   *
   * @param {Object} variables
   * @return {JSX.Element}
   */
  static renderControls(props, metadata, variables) {

    const {attributes, setAttributes} = props;

    const [priorityText, setPriorityText] = useState(Utils.getPriorityText(attributes.fetchPriority));

    const {createErrorNotice} = useDispatch(noticesStore);
    
    console.log(variables['grid-breakpoints']);
    console.log(attributes);
    
    // Function to initialize size attributes based on grid-breakpoints
    function initializeSrcSetfromVariables() {
      const SrcSetfromVariables = {};
      const breakpoints = variables['grid-breakpoints'];

      Object.keys(breakpoints).forEach((breakpoint, index) => {
        if (index !== 0) { 
          SrcSetfromVariables[breakpoint] = {
            "viewPort": breakpoints[breakpoint],
            "enabled": true
          };
        }
      });
      return SrcSetfromVariables;
    }
    if (!attributes.srcSet || Object.keys(attributes.srcSet).length === 0) {
      setAttributes({srcSet: initializeSrcSetfromVariables()});
    }
    
    return (
      <InspectorControls key="controls">
        <PanelBody title="Image Properties" className="image_container">
          <TabPanel className="custom_tab" activeClass="btn-secondary text-white" tabs={[
            {
              name: 'responsive-tab',
              title: 'Responsive',
              className: 'col btn btn-sm btn-outline-secondary',
            },
            {
              name: 'settings-tab',
              title: 'Settings',
              className: 'col btn btn-sm btn-outline-secondary',
            },
          ]}>
            {(tab) => (
              <div className="custom_panel">
                {tab.name === 'responsive-tab' &&
                  <div className="pt-4">
                    {!attributes.mainImage.url ? (
                      <div className="px-3">
                        <div className="row_image">
                          <div className="starter-kit-image-block">
                            <MediaPlaceholder
                              icon={metadata.icon}
                              labels={{title: 'Add Image'}}
                              onSelect={(media) => Handlers.onChangeImage(media, props)}
                              onSelectURL={(newURL) => Handlers.onSelectURL(newURL, props)}
                              onError={(message) => Handlers.onUploadError(createErrorNotice, message)}
                              accept="image/*"
                              allowedTypes={ALLOWED_MEDIA_TYPES}
                            />

                          </div>
                        </div>
                      </div>
                    ) : (
                      <div>
                        <div className="px-4 mb-5">
                          <div className="row_image">
                            <div className="starter-kit-image-block">
                              <div className="img_holder">
                                <img src={attributes.mainImage.url} alt="Main" />
                              </div>
                              <MediaPlaceholder
                                labels={{title: 'Main Image'}}
                                onSelect={(media) => Handlers.onChangeImage(media, props)}
                                onSelectURL={(newURL) => Handlers.onSelectURL(newURL, props)}
                                onError={(message) => Handlers.onUploadError(createErrorNotice, message)}
                                accept="image/*"
                                allowedTypes={ALLOWED_MEDIA_TYPES}
                              />
                              <CheckboxControl
                                className="pb-3"
                                label="HiDPI"
                                checked={attributes.hidpi}
                                onChange={
                                  (checked) => Handlers.onChangeHiDPI(checked, props)
                                }
                              />
                              <div className="image-dimensions row g-2">
                                <TextControl
                                  label="width"
                                  type="number"
                                  className="col"
                                  value={Utils.getImageWidth(attributes, '', true)}
                                  placeholder={attributes.mainImage.startWidth}
                                  onKeyPress={Handlers.onNumberInputKeyPress}
                                  onChange={(event) => Handlers.onWidthInputChange(event, props)}
                                  inputMode="numeric"
                                  min="1"
                                  max={attributes.mainImage.startWidth}
                                />

                                <TextControl
                                  label="height"
                                  type="text"
                                  className="col"
                                  value={Utils.getImageHeight(attributes)}
                                  disabled
                                />

                              </div>
                            </div>
                          </div>
                        </div>
                        {Object.keys(attributes.srcSet)
                          .reverse()
                          .map((breakpoint) => (
                            // hide breakpoints, when image with < breakpoint viewPort
                            attributes.srcSet[breakpoint].enabled ? (
                              <PanelBody
                                title={`SrcSet: ${breakpoint.toUpperCase()} : ${attributes.srcSet[breakpoint].viewPort}px`}
                                key={breakpoint}
                                initialOpen={false}
                              >
                                <div className="row_image" key={breakpoint}>
                                  <div className="starter-kit-image-block">
                                    <div className="img_holder">
                                      <img src={attributes.srcSet[breakpoint].url
                                        ? attributes.srcSet[breakpoint].url
                                        : attributes.mainImage.url} alt={`Breakpoint ${attributes.srcSet[breakpoint].viewPort}`} />
                                    </div>
                                    <MediaPlaceholder
                                      labels={{title: 'Change Image'}}
                                      onSelect={(media) => Handlers.onChangeImage(media, props, breakpoint)}
                                      onError={(message) => Handlers.onUploadError(createErrorNotice, message)}
                                      accept="image/*"
                                      allowedTypes={ALLOWED_MEDIA_TYPES}
                                    />
                                    {attributes.srcSet[breakpoint].id && (
                                      <button
                                        className="btn btn-danger btn-sm btn_reset"
                                        onClick={() => Handlers.onResetImage(breakpoint, props)}
                                      >
                                        Reset to Default Image
                                      </button>
                                    )}
                                    <div className="image-dimensions row g-2">
                                      <TextControl
                                        label="width"
                                        type="number"
                                        className="col"
                                        value={Utils.getImageWidth(attributes, breakpoint, true)}
                                        placeholder={attributes.srcSet[breakpoint].startWidth ? attributes.srcSet[breakpoint].startWidth : attributes.srcSet[breakpoint].viewPort}
                                        onKeyPress={Handlers.onNumberInputKeyPress}
                                        onChange={(event) => Handlers.onWidthInputChange(event, props, breakpoint)}
                                        inputMode="numeric"
                                        min="1"
                                        max={attributes.srcSet[breakpoint].startWidth ? attributes.srcSet[breakpoint].startWidth : attributes.srcSet[breakpoint].viewPort}
                                      />
                                      <TextControl
                                        label="height"
                                        type="text"
                                        className="col"
                                        value={Utils.getImageHeight(attributes, breakpoint)}
                                        disabled
                                      />
                                    </div>
                                  </div>
                                </div>
                              </PanelBody>
                            ) : null
                          ))}

                      </div>
                    )}
                  </div>
                }
                {tab.name === 'settings-tab' &&
                  <div className="pt-4 px-3">
                    <div className="box_breakpoint mb-3">
                      <CheckboxControl
                        label="Wrap an image into a link"
                        checked={attributes.link.addLink}
                        onChange={(checked) => setAttributes({link: {...attributes.link, addLink: checked}})}
                      />
                      {attributes.link.addLink && (
                        <>
                          <TextControl
                            label="Href"
                            value={attributes.link.href}
                            onChange={(value) => setAttributes({link: {...attributes.link, href: value}})}
                          />
                          <CheckboxControl
                            label="Open in New Tab"
                            checked={attributes.link.targetBlank}
                            onChange={(checked) => setAttributes({link: {...attributes.link, targetBlank: checked}})}
                          />
                        </>
                      )}

                    </div>
                    <TextareaControl
                      label="Alt Text"
                      value={attributes.altText}
                      onChange={(value) => {
                        setAttributes({
                          altText: value,
                        });
                      }}
                    />
                    <CheckboxControl
                      label="Lazy Loading"
                      checked={attributes.loadingLazy}
                      onChange={(checked) => setAttributes({loadingLazy: checked})}
                    />
                    <SelectControl
                      label="Fetch Priority"
                      value={attributes.fetchPriority}
                      options={[
                        {label: 'Priority: Auto', value: 'auto'},
                        {label: 'Priority: Low', value: 'low'},
                        {label: 'Priority: High', value: 'high'},
                      ]}
                      onChange={(value) => {
                        setAttributes({fetchPriority: value});
                        setPriorityText(Utils.getPriorityText(value));
                      }}
                    />
                    <div>
                      {priorityText && <p>{priorityText}</p>}
                    </div>
                  </div>
                }
              </div>
            )}
          </TabPanel>
        </PanelBody>
      </InspectorControls>
    );
  };

  /**
   * Render Output Image in Left Part from Editor (image or placeHolder for loading image)
   *
   * @param {Object} props
   * @param {Object} metadata
   *
   * @return {JSX.Element}
   */
  static renderOutput(props, metadata) {
    const {attributes, className} = props;

    const blockProps = useBlockProps({
      className: [className],
    });

    const {createErrorNotice} = useDispatch(noticesStore);

    const mainImage = attributes.mainImage;
    const imageWidth = Utils.getImageWidth(attributes);
    const imageHeight = Utils.getImageHeight(attributes);

    let content;

    if (mainImage.url) {
      content = (
        <figure {...blockProps} key="blockControls">
          <img
            className={attributes.imageClass}
            // Gutenberg using iframe in editor with different base url.
            // This will fix all relative image urls - make it absolute for editor.
            src={Utils.ensureAbsoluteUrl(mainImage.url)}
            alt={attributes.altText}
            {...(imageWidth && {width: imageWidth})}
            {...(imageHeight && {height: imageHeight})}
            loading={attributes.loadingLazy ? 'lazy' : 'eager'}
            data-fetch-priority={attributes.fetchPriority}
          />
        </figure>
      );
    } else {

      content = (
        <MediaPlaceholder
          icon={metadata.icon}
          labels={{title: 'Add Image'}}
          onSelect={(media) => Handlers.onChangeImage(media, props)}
          onSelectURL={(newURL) => Handlers.onSelectURL(newURL, props)}
          onError={(message) => Handlers.onUploadError(createErrorNotice, message)}
          accept="image/*"
          allowedTypes={ALLOWED_MEDIA_TYPES}
        />
      );
    }

    return <>{content}</>;
  }
}
