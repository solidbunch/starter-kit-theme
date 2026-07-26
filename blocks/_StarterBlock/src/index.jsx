/**
 * Starter Block — boilerplate for STATIC blocks (the default kind, see blocks/CLAUDE.md).
 * Content saved here is baked into post HTML by save() below; nothing renders server-side.
 *
 * For a DYNAMIC (PHP-rendered) block instead, see the doc comment on Block.php's
 * registerBlockArgs() — the short version: set save: () => null here, and move rendering
 * into Block.php's blockServerSideCallback() + a view/layout.php template.
 */

/**
 * Block dependencies
 */
import metadata from '../block.json';
import transforms from './transforms';

/**
 * Internal block libraries — always use the global wp.* objects, never `@wordpress/*` npm
 * imports (see blocks/CLAUDE.md — WP core already loads these as wp.* on every admin page).
 */
const {registerBlockType} = wp.blocks;

const {InspectorControls, useBlockProps, RichText, InnerBlocks} = wp.blockEditor;
const {PanelBody, TextControl, SelectControl, CheckboxControl} = wp.components;

// InnerBlocks: restrict which child blocks are allowed and seed a default layout
const allowedBlocks = ['core/paragraph', 'core/heading'];
const innerBlocksTemplate = [['core/paragraph', {placeholder: 'Inner block content…'}]];

const blockMainCssClass = 'starter-block';

// Single source for the wrapper class list — edit() and save() must emit matching class
// names, and .filter(Boolean) drops empty segments without leaving double spaces
const blockClasses = (variant, extraClassName) => [
  blockMainCssClass,
  variant && `${blockMainCssClass}--${variant}`,
  extraClassName,
].filter(Boolean).join(' ');

registerBlockType(
  metadata,
  {
    transforms,

    edit: (props) => {
      const {attributes, setAttributes, className} = props;
      const {heading, badgeLabel, iconClass, showIcon, variant} = attributes;

      const blockProps = useBlockProps({
        className: blockClasses(variant, className),
      });

      const renderControls = (
        <InspectorControls key="controls">
          <PanelBody title="Starter Block Settings">
            <TextControl
              label="Badge label — stored as text in .starter-block__badge"
              value={badgeLabel}
              onChange={(value) => setAttributes({badgeLabel: value})}
            />
            <TextControl
              label="Icon class — stored as data-icon attribute on .starter-block__icon"
              value={iconClass}
              onChange={(value) => setAttributes({iconClass: value})}
            />
            <CheckboxControl
              label="Show icon? Boolean attribute"
              checked={showIcon}
              onChange={(value) => setAttributes({showIcon: value})}
            />
            <SelectControl
              label="Variant — plain string attribute, stored in the block's comment delimiter"
              value={variant}
              options={[
                {label: 'Value 1', value: 'value1'},
                {label: 'Value 2', value: 'value2'},
                {label: 'Value 3', value: 'value3'},
              ]}
              onChange={(value) => setAttributes({variant: value})}
            />
          </PanelBody>
        </InspectorControls>
      );

      const renderOutput = (
        <div {...blockProps} key="blockOutput">
          <span className="starter-block__icon" data-icon={iconClass} hidden={!showIcon}></span>
          <RichText
            tagName="h4"
            className="starter-block__heading"
            multiline={false}
            placeholder="Heading — stored as HTML in h4.starter-block__heading"
            value={heading}
            onChange={(value) => setAttributes({heading: value})}
          />
          <span className="starter-block__badge">{badgeLabel}</span>
          <div className="starter-block__content">
            <InnerBlocks
              allowedBlocks={allowedBlocks}
              template={innerBlocksTemplate}
              orientation="vertical"
            />
          </div>
        </div>
      );

      return [
        renderControls,
        renderOutput,
      ];
    },

    save: (props) => {
      const {attributes} = props;
      const {heading, badgeLabel, iconClass, showIcon, variant} = attributes;

      const blockProps = useBlockProps.save({
        className: blockClasses(variant),
      });

      return (
        <div {...blockProps}>
          {/* The sourced element must ALWAYS be in the saved markup: iconClass lives in its
              data-icon, and a sourced attribute whose element is missing is lost on reload —
              so hide via the hidden attribute instead of conditional rendering */}
          <span className="starter-block__icon" data-icon={iconClass} hidden={!showIcon}></span>
          <RichText.Content
            tagName="h4"
            className="starter-block__heading"
            value={heading}
          />
          <span className="starter-block__badge">{badgeLabel}</span>
          <div className="starter-block__content">
            <InnerBlocks.Content/>
          </div>
        </div>
      );
    },
  });
