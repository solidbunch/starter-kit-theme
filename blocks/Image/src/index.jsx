/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps, InnerBlocks, MediaPlaceholder} = wp.blockEditor;
const {PanelBody, SelectControl , Placeholder ,CheckboxControl, TextControl} = wp.components;

registerBlockType(
  metadata,
  {
    getEditWrapperProps(attributes) {
      const blockClass = attributes.modification;
      return {className: blockClass};
    },
    edit: props => {
      const {attributes, setAttributes, clientId, className} = props;
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
      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Select Sizes">
            {Object.keys(attributes.srcSet).map((breakpoint) => (
              <div key={breakpoint}>
                <CheckboxControl
                  key={breakpoint}
                  label={breakpoint.toUpperCase()}
                  checked={!!attributes.srcSet[breakpoint].imageUrl}
                  onChange={(checked) => handleCheckboxChange(breakpoint, checked, attributes.src)}
                />
                {attributes.srcSet[breakpoint].imageUrl &&
                  <div>
                    <img src={attributes.srcSet[breakpoint].imageUrl} alt="Uploaded" className="img-fluid"/>
                    <MediaPlaceholder
                      labels={{title: 'Change Image'}}
                      onSelect={(media) => handleImageUpload(breakpoint, media)}
                    />
                    <button className='btn btn-danger' onClick={() => handleResetImage(breakpoint)}>Default Image</button>
                  </div>
                }
              </div>
            ))}
          </PanelBody>
        </InspectorControls>
      );
      // { console.log(attributes.srcSet); }
      // { console.log(attributes.src); }
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
      const {src, srcSet} = attributes;
    
      // Фильтрация и сбор значений imageUrl и viewPort для всех srcSet,
      // у которых imageUrl не пустая строка
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
          <img src={src} alt="Saved" srcSet={srcset} />
        </figure>
      );
    },
    
  },
);
