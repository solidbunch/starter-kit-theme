/**
 * Block dependencies
 */
import metadata from '../block.json';

/**
 * Internal block libraries
 */
const {registerBlockType} = wp.blocks;
const {InspectorControls, useBlockProps} = wp.blockEditor;
const {PanelBody, SelectControl, Spinner} = wp.components;
const {serverSideRender: ServerSideRender} = wp;
const {useState, useEffect, useRef} = wp.element;

function preventLinkNavigation(event, isSelected) {
  if (isSelected) {
    event.preventDefault();
  }
}

registerBlockType(
  metadata,
  {
    edit: props => {
      const {attributes, setAttributes, className} = props;
      const blockProps = useBlockProps({
        className: [className],
      });

      const [menuLocations, setMenuLocations] = useState([]);
      const [menus, setMenus] = useState([]);

      useEffect(() => {
        wp.apiFetch({path: '/skt/v1/get-menu-locations'})
          .then(response => {
            setMenuLocations(response);
          })
          .catch(error => {
            // eslint-disable-next-line no-console
            console.error('Error fetching menu locations: ', error);
          });

        wp.apiFetch({path: '/skt/v1/get-menus'})
          .then(response => {
            setMenus(response);
          })
          .catch(error => {
            // eslint-disable-next-line no-console
            console.error('Error fetching menus: ', error);
          });
      }, []); // The empty dependency array ensures this effect runs only once when the component mounts

      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Navigation Options">
            {menuLocations.length < 1
              ? <Spinner key="siteSpinner"/>
              : (
                <>
                  <SelectControl
                    label="Select Menu Location"
                    value={attributes.menuLocation}
                    options={[
                      {label: 'Select a location', value: ''},
                      ...menuLocations.map(location => ({
                        label: location.name,
                        value: location.slug,
                      })),
                    ]}
                    onChange={(menuLocation) => {
                      setAttributes({menuLocation});
                    }}
                  />
                </>
              )
            }
            {menus.length < 1
              ? <Spinner key="siteSpinner"/>
              : (
                <>
                  <SelectControl
                    label="Or Select specific Menu (optional)"
                    value={attributes.menuId}
                    options={[
                      {label: 'Select a menu', value: ''},
                      ...menus.map(menu => ({
                        label: menu.name,
                        value: menu.id,
                      })),
                    ]}
                    onChange={(menuId) => {
                      setAttributes({menuId});
                    }}
                  />
                </>
              )
            }
            <SelectControl
              label={`Expand menu:`}
              value={attributes.expand}
              options={[
                {label: 'No responsive', value: 'navbar-expand'},
                {label: 'SM and under', value: 'navbar-expand-sm'},
                {label: 'MD and under', value: 'navbar-expand-md'},
                {label: 'LG and under', value: 'navbar-expand-lg'},
                {label: 'XL and under', value: 'navbar-expand-xl'},
                {label: 'XXL and under', value: 'navbar-expand-xxl'},
                {label: 'Always expand', value: ''},
              ]}
              onChange={(expand) => setAttributes({expand})}
            />
          </PanelBody>
        </InspectorControls>
      );

      const blockRef = useRef();

      useEffect(() => {
        // Adding event listener to all anchor tags within the block in the editor
        const links = blockRef.current.querySelectorAll('.header a');
        links.forEach(link => {
          link.onclick = (event) => {
            preventLinkNavigation(event, true); // Prevent the default link behavior
            return false;
          };
        });

        // Cleanup function to remove event listeners
        return () => {
          links.forEach(link => {
            link.onclick = null;
          });
        };
      });

      const renderOutput = (
        <div {...blockProps} key="blockControls" ref={blockRef}>
          <ServerSideRender
            block={metadata.name}
            attributes={attributes}
          />
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
