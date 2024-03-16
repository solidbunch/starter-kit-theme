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
      const blockClass = attributes.defaultClass;
      return {className: blockClass};
    },
    edit: props => {
      const {attributes, setAttributes, className} = props;
      const [priorityText, setPriorityText] = useState(getPriorityText(attributes.fetchPriority));
      const blockProps = useBlockProps({
        className: [className],
      });
      const changeMainDimension = (updatedAttributes) => {
        setAttributes({mainImage: {...attributes.mainImage, ...updatedAttributes}});
      };
      // console.log(blockProps);
      const changeSrcSetDimension = (breakpoint, updatedAttributes) => {
        setAttributes({
          srcSet: {
            ...attributes.srcSet,
            [breakpoint]: {...attributes.srcSet[breakpoint], ...updatedAttributes},
          },
        });
      };
      // Upload/Change main Image
      const changeMainImage = (media) => {
        const {url, width, height, id} = media;
        const ratio = width / height;
        const updatedSrcSet = {...attributes.srcSet};
      
        // Update srcSet for all breakpoints
        Object.keys(updatedSrcSet).forEach((brPoint) => {
          const viewport = updatedSrcSet[brPoint].viewPort;
          updatedSrcSet[brPoint] = {
            ...updatedSrcSet[brPoint],
            imageUrl: url,
            id,
            ratio,
            width: viewport,
            height: Math.trunc(viewport / ratio)
          };
        });
      
        // Update mainImage and srcSet attributes
        setAttributes({
          mainImage: {src: url, width, height, id, ratio},
          srcSet: updatedSrcSet
        });
      };
      const changeSrcSetImage = (breakpoint, media) => {
        const updatedSrcSet = {...attributes.srcSet};
      
        // Calculate ratio
        const ratio = media.width / media.height;
      
        // Update srcSet for the selected breakpoint
        updatedSrcSet[breakpoint] = {
          ...updatedSrcSet[breakpoint],
          imageUrl: media.url,
          id: media.id,
          width: updatedSrcSet[breakpoint].viewPort,
          ratio,
          height: Math.trunc(updatedSrcSet[breakpoint].viewPort / ratio)
        };
      
        // Update attributes
        setAttributes({
          srcSet: updatedSrcSet
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
                                    type="text"
                                    className="col"
                                    value={attributes.mainImage.width}
                                    onChange={(event) => {
                                      const newWidth = parseInt(event.replace(/\D/g, ''), 10);
                                      changeMainDimension({width: newWidth});
                                    }}
                                    inputMode="numeric"
                                  />
                                  <TextControl
                                    label="height"
                                    type="text"
                                    className="col"
                                    value={attributes.mainImage.height}
                                    onChange={(event) => {
                                      const newHeight = parseInt(event.replace(/\D/g, ''), 10);
                                      changeMainDimension({height: newHeight});
                                    }}
                                    inputMode="numeric"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          {Object.keys(attributes.srcSet)
                            .reverse()
                            .map((breakpoint) => (
                              <PanelBody
                                title={`SrcSet: ${breakpoint.toUpperCase()}`}
                                key={breakpoint}
                                initialOpen={false}
                              >
                                <div className='row_image'>
                                  <div className='setting_box'>
                                    <img src={attributes.srcSet[breakpoint].imageUrl} alt="Uploaded" />

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
                                        type="text"
                                        className="col"
                                        value={attributes.srcSet[breakpoint].width}
                                        onChange={(event) => {
                                          const newWidth = parseInt(event.replace(/\D/g, ''), 10);
                                          changeSrcSetDimension(breakpoint, {width: newWidth});
                                        }}
                                        inputMode="numeric"
                                      />
                                      <TextControl
                                        label="height"
                                        type="text"
                                        className="col"
                                        value={attributes.srcSet[breakpoint].height}
                                        onChange={(event) => {
                                          const newHeight = parseInt(event.replace(/\D/g, ''), 10);
                                          changeSrcSetDimension(breakpoint, {height: newHeight});
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
          { console.log(blockProps) }
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
