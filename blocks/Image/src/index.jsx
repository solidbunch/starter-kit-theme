/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, InnerBlocks, MediaPlaceholder} = wp.blockEditor;
const {PanelBody, SelectControl, Placeholder, CheckboxControl, TextControl, TextareaControl,TabPanel} = wp.components;
const {useState} = wp.element;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const blockClass = attributes.modification;
      return {className: blockClass};
    },
    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
      const [priorityText, setPriorityText] = useState(getPriorityText(attributes.fetchPriority));
      const blockProps = useBlockProps({
        className: [className],
      });

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
            <TabPanel className="my-tab-panel" activeClass="btn-secondary text-white" tabs={[
              {
                name: 'tab1',
                title: 'Sizes',
                className: 'col btn btn-sm btn-outline-secondary',
              },
              {
                name: 'tab2',
                title: 'Settings',
                className: 'col btn btn-sm btn-outline-secondary',
              },
            ]}>
              {(tab) => (
                <div>
                  {tab.name === 'tab1' &&
                    <div className='pt-4'>
                      {Object.keys(attributes.srcSet).map((breakpoint) => (
                        <div key={breakpoint} className='row_image'>
                          <CheckboxControl
                            key={breakpoint}
                            label={breakpoint.toUpperCase()}
                            checked={!!attributes.srcSet[breakpoint].imageUrl}
                            onChange={(checked) => handleCheckboxChange(breakpoint, checked, attributes.src)}
                          />
                          {attributes.srcSet[breakpoint].imageUrl &&
                            <div className='setting_box'>
                              <img src={attributes.srcSet[breakpoint].imageUrl} alt="Uploaded" className="img-fluid"/>
                              <MediaPlaceholder
                                labels={{title: 'Change Image'}}
                                onSelect={(media) => handleImageUpload(breakpoint, media)}
                              />
                              {attributes.srcSet[breakpoint].imageUrl !== attributes.src &&
                                <button className='btn btn-danger btn-sm btn_reset' onClick={() => handleResetImage(breakpoint)}>Reset to Default Image</button>
                              }
                            </div>
                          }
                        </div>
                        
                      ))}
                      <div className="image-dimensions">
                        
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
                </div>
              )}
            </TabPanel>
          </PanelBody>
        </InspectorControls>
      );
      // { console.log(attributes.srcSet); }
      { console.log(attributes.srcSet); }
      const renderOutput = (
        <div  {...blockProps} key="blockControls">
          {attributes.src ? (
            <img src={attributes.src} alt="Uploaded" />
          ) : (
            <MediaPlaceholder
              icon="format-image"
              labels={{title: 'Add Image'}}
              onSelect={(media) => {
                setAttributes({
                  src: media.url
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
      const {src, srcSet,altText,loadingLazy,fetchPriority} = attributes;
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
            src={src}
            alt={altText}
            className='img-fluid'
            
          />
        </figure>
      );
    },
    
  },
);
