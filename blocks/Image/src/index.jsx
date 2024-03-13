/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, MediaPlaceholder} = wp.blockEditor;
const {PanelBody, SelectControl, CheckboxControl, TextControl, TextareaControl,TabPanel} = wp.components;
const {useState} = wp.element;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const blockClass = attributes.modification;
      return {className: blockClass};
    },
    edit: props => {
      const {attributes, setAttributes, className} = props;
      const [priorityText, setPriorityText] = useState(getPriorityText(attributes.fetchPriority));
      const blockProps = useBlockProps({
        className: [className],
      });
      // width/ height
      const handleDimensionChange = (index, breakpoint, updatedAttributes) => {
        setAttributes({
          ...(index === 0
            ? {mainImage: {...attributes.mainImage, ...updatedAttributes}}
            : {
              srcSet: {
                ...attributes.srcSet,
                [breakpoint]: {...attributes.srcSet[breakpoint], ...updatedAttributes},
              },
            }),
        });
      };
      // upload
      const handleImageUpload = (index, breakpoint, media) => {
        const updatedSrcSet = {...attributes.srcSet};

        Object.keys(updatedSrcSet).forEach((brPoint) => {
          const viewport = updatedSrcSet[brPoint].viewPort;
          const ratio = media.width / media.height;
          updatedSrcSet[brPoint] = {
            ...updatedSrcSet[brPoint],
            imageUrl: media.url,
            id: media.id,
            width: viewport,
            height: Math.trunc(viewport / ratio),
            ratio
          };
        });

        setAttributes({
          ...(index === 0
            ? {
              mainImage: {
                ...attributes.mainImage,
                src: media.url,
                width: media.width,
                height: media.height,
                id: media.id,
                ratio:media.width / media.height
              },
              srcSet: updatedSrcSet,
            }
            : {
              srcSet: {
                ...attributes.srcSet,
                [breakpoint]: {
                  ...attributes.srcSet[breakpoint],
                  imageUrl: media.url,
                  id: media.id,
                  width:updatedSrcSet[breakpoint].viewPort,
                  ratio: media.width / media.height,
                  height: Math.trunc(updatedSrcSet[breakpoint].viewPort / (media.width / media.height)),
                },
              },
            }),
        });
      };

      const handleResetImage = (breakpoint) => {
        setAttributes({
          srcSet: {
            ...attributes.srcSet,
            [breakpoint]: {
              ...attributes.srcSet[breakpoint],
              imageUrl: attributes.mainImage.src,
              id: attributes.mainImage.id,
              ratio:attributes.mainImage.ratio,
              width:attributes.srcSet[breakpoint].viewPort,
              height:attributes.srcSet[breakpoint].viewPort / attributes.mainImage.ratio,
            }
          }
        });
      };

      function getPriorityText(value) {
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
      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Image Properties" className="image_container">
            <TabPanel className="custom_tab" activeClass="btn-secondary text-white" tabs={[
              {
                name: 'tab1',
                title: 'Responsive',
                className: 'col btn btn-sm btn-outline-secondary',
              },
              {
                name: 'tab2',
                title: 'Settings',
                className: 'col btn btn-sm btn-outline-secondary',
              },
            ]}>
              {(tab) => (
                <div className='custom_panel'>
                  {tab.name === 'tab1' &&
                    <div className='pt-4'>
                      {!attributes.mainImage.src ? (
                        <div className="px-3">
                          <div className="row_image">
                            <div className='setting_box'>
                              <MediaPlaceholder
                                icon="format-image"
                                labels={{title: 'Add Image'}}
                                onSelect={(media) => {
                                  const {url, width, height, id} = media;
                                  const ratio = width / height;
                                  const updatedSrcSet = {...attributes.srcSet};

                                  Object.keys(updatedSrcSet).forEach((brPoint) => {
                                    const viewport = updatedSrcSet[brPoint].viewPort;
                                    updatedSrcSet[brPoint] = {
                                      ...updatedSrcSet[brPoint], // Keep other properties intact
                                      imageUrl: url,
                                      id,
                                      ratio,
                                      width: viewport,
                                      height: Math.trunc(viewport / ratio)
                                    };
                                  });

                                  setAttributes({
                                    mainImage: {src: url, width, height, id, ratio},
                                    srcSet: updatedSrcSet
                                  });
                                }}
                              />

                            </div>
                          </div>
                        </div>
                      ) : (
                        <div>
                          {Object.keys(attributes.srcSet)
                            .reverse()
                            .map((breakpoint, index) => (
                              <PanelBody
                                title={`SrcSet: ${breakpoint.toUpperCase()}`}
                                key={breakpoint}
                                initialOpen={index === 0}
                              >
                                <div className='row_image'>
                                  <div className='setting_box'>
                                    <img src={
                                      index === 0 ? attributes.mainImage.src : attributes.srcSet[breakpoint].imageUrl
                                    } alt="Uploaded" />

                                    <MediaPlaceholder
                                      labels={{title: 'Change Image'}}
                                      onSelect={(media) => handleImageUpload(index,breakpoint, media)}
                                    />
                                    {attributes.srcSet[breakpoint].id !== attributes.mainImage.id && (
                                      <button
                                        className='btn btn-danger btn-sm btn_reset'
                                        onClick={() => handleResetImage(breakpoint)}
                                      >
                                        Reset to Default Image
                                      </button>
                                    )}
                                    <div className="image-dimensions row g-2">
                                      <TextControl
                                        label="width"
                                        type="text"
                                        className="col"
                                        value={index === 0 ? attributes.mainImage.width : attributes.srcSet[breakpoint].width}
                                        onChange={(event) => {
                                          const newWidth = parseInt(event.replace(/\D/g, ''), 10);
                                          handleDimensionChange(index, breakpoint, {width: newWidth});
                                        }}
                                        inputMode="numeric"
                                      />
                                      <TextControl
                                        label="height"
                                        type="text"
                                        className="col"
                                        value={index === 0 ? attributes.mainImage.height : attributes.srcSet[breakpoint].height}
                                        onChange={(event) => {
                                          const newHeight = parseInt(event.replace(/\D/g, ''), 10);
                                          handleDimensionChange(index, breakpoint, {height: newHeight});
                                        }}
                                        inputMode="numeric"
                                      />
                                    </div>
                                  </div>
                                </div>
                              </PanelBody>
                            ))}
                        </div>
                      )}
                    </div>
                  }
                  {tab.name === 'tab2' &&
                    <div className='pt-4 px-3'>
                      <TextareaControl
                        label="Alt Text"
                        value={attributes.altText}
                        onChange={(value) => {
                          setAttributes({
                            altText: value
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
                          {label: 'Priority: High', value: 'high'}
                        ]}
                        onChange={(value) => {
                          setAttributes({fetchPriority: value});
                          setPriorityText(getPriorityText(value));
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

      { console.log(attributes.mainImage); }
      { console.log(attributes.srcSet); }
      const renderOutput = (
        <div  {...blockProps} key="blockControls">
          {attributes.mainImage.src ? (
            <img src={attributes.mainImage.src} alt="Uploaded" width={attributes.mainImage.width} height={attributes.mainImage.height}/>
          ) : (
            <MediaPlaceholder
              icon="format-image"
              labels={{title: 'Add Image'}}
              onSelect={(media) => {
                const {url, width, height, id} = media;
                const ratio = width / height;
                const updatedSrcSet = {...attributes.srcSet};

                Object.keys(updatedSrcSet).forEach((brPoint) => {
                  const viewport = updatedSrcSet[brPoint].viewPort;
                  updatedSrcSet[brPoint] = {
                    ...updatedSrcSet[brPoint], // Keep other properties intact
                    imageUrl: url,
                    id,
                    ratio,
                    width: viewport,
                    height: Math.trunc(viewport / ratio)
                  };
                });

                setAttributes({
                  mainImage: {src: url, width, height, id, ratio},
                  srcSet: updatedSrcSet
                });
              }}
            />
          )}
        </div>
      );

      return [
        renderControls,
        renderOutput,
      ];
    },
    save: () => {
      // Rendering in PHP
      return null;
    },

  },
);
