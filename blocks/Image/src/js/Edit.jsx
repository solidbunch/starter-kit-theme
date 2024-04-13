import Handlers from "./Handlers";
import Utils from "./Helper/Utils";

const {InspectorControls, useBlockProps, MediaPlaceholder} = wp.blockEditor;
const {PanelBody, SelectControl, CheckboxControl, TextControl, TextareaControl,TabPanel} = wp.components;
const {useState} = wp.element;

/**
 * Block editor class
 */
export default class Edit {

  static renderControls(props) {

    const {attributes, setAttributes} = props;

    const [priorityText, setPriorityText] = useState(Utils.getPriorityText(attributes.fetchPriority));

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
              <div className='custom_panel'>
                {tab.name === 'responsive-tab' &&
                  <div className='pt-4'>
                    {!attributes.mainImage.url ? (
                      <div className="px-3">
                        <div className="row_image">
                          <div className='setting_box'>
                            <MediaPlaceholder
                              icon="format-image"
                              labels={{title: 'Add Image'}}
                              onSelect={(media) => Handlers.onChangeImage(media, props)}
                            />

                          </div>
                        </div>
                      </div>
                    ) : (
                      <div>
                        <div className='px-4 mb-5'>
                          <div className='row_image'>
                            <div className='setting_box'>
                              <img src={attributes.mainImage.url} alt="Uploaded" />
                              <MediaPlaceholder
                                labels={{title: 'Main Image'}}
                                onSelect={(media) => Handlers.onChangeImage(media, props)}
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
                                  value={attributes.mainImage.width}
                                  placeholder={attributes.mainImage.startWidth}
                                  onKeyPress={Handlers.onWidthInputKeyPress}
                                  onBlur={Handlers.onWidthInputBlur}
                                  onChange={Handlers.onWidthInputChange}
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
                            // hide breakpoints, when image with < breakpoint viewPort
                            attributes.hideBiggerBreakpoints && attributes.srcSet[breakpoint].id ? (
                              <PanelBody
                                title={`SrcSet: ${breakpoint.toUpperCase()}`}
                                key={breakpoint}
                                initialOpen={false}
                              >
                                <div className='row_image' key={breakpoint}>
                                  <div className='setting_box'>
                                    <img src={attributes.srcSet[breakpoint].url} alt="Uploaded" />
                                    {!attributes.srcSet[breakpoint].validateSize && (
                                      <div className='test_alert'>Bad Image Size</div>
                                    )}
                                    <MediaPlaceholder
                                      labels={{title: 'Change Image'}}
                                      onSelect={(media) => Handlers.onChangeImage(media, props, breakpoint)}
                                    />
                                    {attributes.srcSet[breakpoint].id && attributes.srcSet[breakpoint].id !== attributes.mainImage.id && (
                                      <button
                                        className='btn btn-danger btn-sm btn_reset'
                                        onClick={() => Handlers.onResetImage(breakpoint)}
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
                                        onKeyPress={Handlers.onWidthInputKeyPress}
                                        onBlur={(event) => Handlers.onWidthInputBlur(event, breakpoint)}
                                        onChange={(event) => Handlers.onWidthInputChange(event, breakpoint)}
                                        inputMode="numeric"
                                        min="0"
                                        max={attributes.mainImage.id && attributes.mainImage.id !== attributes.srcSet[breakpoint].id ? attributes.srcSet[breakpoint].startWidth : attributes.mainImage.startWidth}
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
                {tab.name === 'settings-tab' &&
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

  static renderOutput(props) {

    const {attributes, className} = props;

    const blockProps = useBlockProps({
      className: [className],
    });

    return (
      <div  {...blockProps} key="blockControls">
        {attributes.mainImage.url ? (
          <img src={attributes.mainImage.url} alt="Uploaded" width={attributes.mainImage.width} height={attributes.mainImage.height}/>
        ) : (
          <MediaPlaceholder
            icon="format-image"
            labels={{title: 'Add Image'}}
            onSelect={(media) => Handlers.onChangeImage(media, props)}
          />
        )}

      </div>
    );
  };
}
