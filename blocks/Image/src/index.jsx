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
      const handleDimensionChange = (updatedAttributes) => {
        setAttributes({
          mainImage: {
            ...attributes.mainImage,
            ...updatedAttributes,
          },
        });
      };
      const handleImageUpload = (breakpoint, media) => {
        setAttributes({
          srcSet: {
            ...attributes.srcSet,
            [breakpoint]: {
              ...attributes.srcSet[breakpoint],
              imageUrl: media.url,
            }
          }
        });
      };

      const handleResetImage = (breakpoint) => {
        setAttributes({
          srcSet: {
            ...attributes.srcSet,
            [breakpoint]: {
              ...attributes.srcSet[breakpoint],
              imageUrl: attributes.src
            }
          }
        });
      };
      
      const handleCheckboxChange = (breakpoint, checked, imageUrl) => {
        setAttributes({
          srcSet: {
            ...attributes.srcSet,
            [breakpoint]: {
              ...attributes.srcSet[breakpoint],
              imageUrl: checked ? imageUrl : '',
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
          <PanelBody title="Image Properties">
            <TabPanel className="custom_tab" activeClass="btn-secondary text-white" tabs={[
              {
                name: 'tab1',
                title: 'Main Image',
                className: 'col btn btn-sm btn-outline-secondary',
              },
              {
                name: 'tab2',
                title: 'Settings',
                className: 'col btn btn-sm btn-outline-secondary',
              },
              {
                name: 'tab3',
                title: 'SrcSet',
                className: 'col btn btn-sm btn-outline-secondary',
              },
            ]}>
              {(tab) => (
                <div>
                  {tab.name === 'tab1' &&
                    <div className='pt-4'>
                      <div className="row_image">
                        <div className='setting_box'>
                          {attributes.mainImage.src && (
                            <img src={attributes.mainImage.src} alt="Uploaded"  />
                          )}
                          <MediaPlaceholder
                            icon="format-image"
                            labels={{title: 'Add Image'}}
                            // onSelect={(media) => {
                            //   const {url, width, height} = media;
                            //   const updatedSrcSet = {...attributes.srcSet};
                            //   Object.keys(updatedSrcSet).forEach((size) => {
                            //     updatedSrcSet[size].imageUrl = url;
                            //   });
                            //   setAttributes({
                            //     mainImage: {
                            //       src:url,
                            //       width,
                            //       height,
                            //     },
                            //     srcSet: updatedSrcSet
                            //   });
                            // }}
                            onSelect={(media) => {
                              setAttributes({
                                mainImage: {
                                  src: media.url,
                                  width: media.width,
                                  height: media.height,
                                }
                              });
                            }}
                          />
                          {attributes.mainImage.width && attributes.mainImage.height && (
                            <div className="image-dimensions row g-2">
                              <TextControl
                                label="width"
                                type="text"
                                className="col"
                                value={attributes.mainImage.width}
                                onChange={(event) => {
                                  const newWidth = event.replace(/\D/g, '');
                                  handleDimensionChange({width: newWidth});
                                }}
                                inputMode="numeric"
                              />
                              <TextControl
                                label="height"
                                type="text"
                                className="col"
                                value={attributes.mainImage.height}
                                onChange={(event) => {
                                  const newHeight = event.replace(/\D/g, '');
                                  handleDimensionChange({height: newHeight});
                                }}
                                inputMode="numeric"
                              />
                            </div>
                          )}
                        </div>
                      </div>
                    </div>
                  }
                  {tab.name === 'tab2' &&
                    <div className='pt-4'>
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
                  {tab.name === 'tab3' &&
                    <div className='pt-4'>
                      <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dicta totam, ullam quos rem perferendis optio vel accusamus eveniet illum ratione rerum, deserunt reiciendis harum. Rerum dolores exercitationem sint praesentium enim.  </p>
                    </div>
                  }
                </div>
              )}
            </TabPanel>
          </PanelBody>
          <PanelBody title="SrcSets" key="sw" initialOpen={ false }>
            {Object.keys(attributes.srcSet).map((breakpoint) => (
              <PanelBody title={`${breakpoint.toUpperCase()}`} key={breakpoint} initialOpen={ false }>
                <div className='setting_box'>
                  <img src={attributes.mainImage.src} alt="Uploaded"  />
                  <MediaPlaceholder
                    labels={{title: 'Change Image'}}
                    onSelect={(media) => handleImageUpload(breakpoint, media)}
                  />
                  {attributes.srcSet[breakpoint].imageUrl !== attributes.src &&
                    <button className='btn btn-danger btn-sm btn_reset' onClick={() => handleResetImage(breakpoint)}>Reset to Default Image</button>
                  }
                </div>
              </PanelBody>
            ))}
          </PanelBody>
        </InspectorControls>
      );
      // { console.log(attributes.srcSet); }
      { console.log(attributes.mainImage); }
      const renderOutput = (
        <div  {...blockProps} key="blockControls">
          {attributes.mainImage.src ? (
            <img src={attributes.mainImage.src} alt="Uploaded" width={attributes.mainImage.width}/>
          ) : (
            <MediaPlaceholder
              icon="format-image"
              labels={{title: 'Add Image'}}
              onSelect={(media) => {
                setAttributes({
                  mainImage: {
                    src: media.url,
                    width: media.width,
                    height: media.height,
                  }
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
    save: props => {
      const {attributes} = props;
      const {mainImage, srcSet,altText,loadingLazy,fetchPriority} = attributes;
      const srcsetValues = Object.entries(srcSet)
        .filter(([breakpoint, data]) => data.imageUrl !== '')
        .map(([breakpoint, data]) => `${data.imageUrl} ${data.viewPort}w`);
    
      // Создание строки srcset, объединяя значения через запятую
      const srcset = srcsetValues.join(', ');
    
      const blockClass = attributes.modification;
    
      const blockProps = useBlockProps.save({
        className: blockClass,
      });
    
      return (
        <figure {...blockProps}>
          <img
            sizes="100vw"
            {...(fetchPriority !== 'auto' ? {fetchpriority: fetchPriority} : {})}
            {...(loadingLazy ? {loading: 'lazy'} : {})}
            {...(srcset ? {srcSet: srcset} : {})}
            src={mainImage.src}
            alt={altText}
            className='img-fluid'
            width={mainImage.width}
            height={mainImage.height}
          />
        </figure>
      );
    },
    
  },
);
