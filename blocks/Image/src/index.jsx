/**
 * Block dependencies
 */
import metadata from '../block.json';
import {handleKeyPress} from './helpers';
/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, MediaPlaceholder} = wp.blockEditor;
const {PanelBody, SelectControl, CheckboxControl, TextControl, TextareaControl,TabPanel} = wp.components;
const {useState} = wp.element;

// setDisabledBreakpoint  ---  toggler for hide breakpoints , when image with small size
const setDisabledBreakpoint = true;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const blockClass = attributes.defaultClass;
      return {className: blockClass};
    },
    edit: props => {
      const {attributes, setAttributes, className} = props;
      const [priorityText, setPriorityText] = useState(getPriorityText(attributes.fetchPriority));
      const blockProps = useBlockProps({
        className: [className],
      });
      
      //blur
      const handleBlur = (event, breakpoint = null) => {
        const {mainImage, srcSet} = attributes;
      
        if (event.target.value === "") {
          if (breakpoint === null) {
            const {startWidth, ratio} = mainImage;
            const newHeight = Math.trunc(startWidth / ratio);
            changeDimension('mainImage', null, {width: startWidth, height: newHeight});
          } else {
            const {startWidth, viewPort, ratio, id} = srcSet[breakpoint];
            const idValidation = mainImage.id === id;
      
            let newWidth = (!idValidation && startWidth <= viewPort) ? startWidth : viewPort;
            const newHeight = Math.trunc(newWidth / ratio);
            changeDimension('srcSet', breakpoint, {width: newWidth, height: newHeight});
          }
        }
      };
      //change Width and Height in mainImage or srcSet
      const changeDimension = (type, breakpoint, updatedAttributes) => {
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
      
      const changeMainImage = (media) => {
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
      
            // reject
          }
        }).then((fullMedia) => {
          const {width, height} = fullMedia.media_details ? fullMedia.media_details : fullMedia;
  
          const updatedSrcSet = {...attributes.srcSet};
      
          // Update srcSet for all breakpoints
          Object.keys(updatedSrcSet).forEach(brPoint => {
            const {viewPort} = updatedSrcSet[brPoint];
            const validateSize = width >= viewPort;
            const ratio = width / height;
            const newHeight = Math.trunc(viewPort / ratio);
            const shouldDisableBreakpoint = setDisabledBreakpoint && width < viewPort;

            //The process involves checking for a condition if hiding breakpoints and if the width is less than the viewport.
            updatedSrcSet[brPoint] = {
              ...updatedSrcSet[brPoint],
              imageUrl: shouldDisableBreakpoint ? '' : fullMedia.url,
              id: shouldDisableBreakpoint ? '' : fullMedia.id,
              ratio: shouldDisableBreakpoint ? '' : ratio,
              width: shouldDisableBreakpoint ? '' : viewPort,
              height: shouldDisableBreakpoint ? '' : newHeight,
              validateSize
            };
          });
      
          // Update mainImage and srcSet attributes
          setAttributes({
            mainImage: {src: fullMedia.url, width, startWidth: width, height, id: fullMedia.id, ratio: width / height},
            srcSet: updatedSrcSet
          });
        }).catch((error) => {
          // Errors
          // eslint-disable-next-line no-console
          console.error("Errors:", error);
        });
      };
      
      const changeSrcSetImage = (breakpoint, media) => {
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
      
            // reject
          }
        }).then((fullMedia) => {
          const updatedSrcSet = {...attributes.srcSet};
          const {width, height} = fullMedia.media_details ? fullMedia.media_details : fullMedia;
          const ratio = width / height;
          const widthInInput = (width >= updatedSrcSet[breakpoint].viewPort) ? updatedSrcSet[breakpoint].viewPort : width;
      
          updatedSrcSet[breakpoint] = {
            ...updatedSrcSet[breakpoint],
            imageUrl: fullMedia.url,
            id: fullMedia.id,
            width:widthInInput,
            startWidth: width,
            ratio,
            height: Math.trunc(width / ratio)
          };
          // Update attributes
          setAttributes({
            srcSet: updatedSrcSet
          });
        }).catch((error) => {
          // Errors
          // eslint-disable-next-line no-console
          console.error("Errors:", error);
        });
      };

      //reset attributes to Default (Main Image)
      const handleResetImage = (breakpoint) => {
        setAttributes({
          srcSet: {
            ...attributes.srcSet,
            [breakpoint]: {
              ...attributes.srcSet[breakpoint],
              imageUrl: attributes.mainImage.src,
              id: attributes.mainImage.id,
              startWidth:'',
              ratio:attributes.mainImage.ratio,
              width:attributes.srcSet[breakpoint].viewPort,
              height: Math.trunc(attributes.srcSet[breakpoint].viewPort / attributes.mainImage.ratio),
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
                                onSelect={changeMainImage}
                              />

                            </div>
                          </div>
                        </div>
                      ) : (
                        <div>
                          <div className='px-4 mb-5'>
                            <div className='row_image'>
                              <div className='setting_box'>
                                <img src={attributes.mainImage.src} alt="Uploaded" />

                                <MediaPlaceholder
                                  labels={{title: 'Main Image'}}
                                  onSelect={changeMainImage}
                                />
                                <div className="image-dimensions row g-2">
                                  <TextControl
                                    label="width"
                                    type="number"
                                    className="col"
                                    value={attributes.mainImage.width}
                                    placeholder={attributes.mainImage.startWidth}
                                    onKeyPress={handleKeyPress}
                                    onBlur={(event) => handleBlur(event)}
                                    onChange={(event) => {
                                      
                                      let newWidth = parseInt(event.replace(/\D/g, ''), 10);
                                      const {startWidth,ratio} = attributes.mainImage;
                                      if (isNaN(newWidth)) {
                                        newWidth = "";
                                      }
                                      if (newWidth > startWidth) {
                                        newWidth = startWidth;
                                      }
                                      let newHeight = Math.trunc(newWidth / ratio);
                                      changeDimension('mainImage', null, {width: newWidth, height: newHeight});
                                    }}
                                    inputMode="numeric"
                                    min="0"
                                    max={attributes.mainImage.startWidth}
                                  />

                                  <TextControl
                                    label="height"
                                    type="text"
                                    className="col"
                                    value={attributes.mainImage.height}
                                    disabled 
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          {Object.keys(attributes.srcSet)
                            .reverse()
                            .map((breakpoint) => (
                              !setDisabledBreakpoint || attributes.srcSet[breakpoint].validateSize !== false ? (
                                <PanelBody
                                  title={`SrcSet: ${breakpoint.toUpperCase()}`}
                                  key={breakpoint}
                                  initialOpen={false}
                                >
                                  <div className='row_image' key={breakpoint}>
                                    <div className='setting_box'>
                                      <img src={attributes.srcSet[breakpoint].imageUrl} alt="Uploaded" />
                                      {!attributes.srcSet[breakpoint].validateSize && (
                                        <div className='test_alert'>Bad Image Size</div>
                                      )}
                                      <MediaPlaceholder
                                        labels={{title: 'Change Image'}}
                                        onSelect={(media) => changeSrcSetImage(breakpoint, media)}
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
                                          type="number"
                                          className="col"
                                          value={attributes.srcSet[breakpoint].width}
                                          placeholder={attributes.srcSet[breakpoint].width}
                                          onKeyPress={handleKeyPress}
                                          onBlur={(event) => handleBlur(event, breakpoint)}
                                          
                                          onChange={(event) => {
                                            
                                            let newWidth = parseInt(event.replace(/\D/g, ''), 10);
                                            if (isNaN(newWidth)) {
                                              newWidth = "";
                                            }
                                            const {startWidth, ratio,id} = attributes.srcSet[breakpoint];
                                            const idValidation = attributes.mainImage.id === id;
                                            if (!idValidation) {
                                              if (newWidth > startWidth) {
                                                newWidth = startWidth;
                                              }
                                            } else if (newWidth > attributes.mainImage.startWidth) {
                                              newWidth = attributes.mainImage.startWidth;
                                            }
                                            
                                            let newHeight = Math.trunc(newWidth / ratio);
                                            changeDimension('srcSet', breakpoint, {width: newWidth, height: newHeight});
                                          }}
                                          inputMode="numeric"
                                          min="0"
                                          max={attributes.mainImage.id !== attributes.srcSet[breakpoint].id ? attributes.srcSet[breakpoint].startWidth : attributes.mainImage.startWidth}
                                        />
                                        <TextControl
                                          label="height"
                                          type="text"
                                          className="col"
                                          value={attributes.srcSet[breakpoint].height}
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
              onSelect={changeMainImage}
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
