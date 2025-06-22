/**
 * Gutenberg Heading Block – Transforms
 *
 * This module defines how the core/heading block can be:
 * - Created from other blocks or raw HTML content (`from`)
 * - Converted into other block types (`to`)
 *
 * Included transforms:
 *
 * FROM:
 * - Convert core/paragraph blocks into heading blocks.
 * - Parse raw <h1> to <h6> HTML elements and create corresponding heading blocks.
 * - Support Markdown-style prefixes using '#' (e.g., '#', '##', etc.).
 * - Enable slash command transforms like '/h1', '/h2', etc.
 *
 * TO:
 * - Convert heading blocks back into core/paragraph blocks.
 *
 */

/**
 * WordPress dependencies
 */
const {createBlock, getBlockAttributes} = wp.blocks;

function getLevelFromHeadingNodeName(nodeName) {
  return Number(nodeName.slice(1));
}

const transforms = {
  from: [
    {
      type: 'block',
      isMultiBlock: true,
      blocks: ['core/paragraph'],
      transform: (attributes) =>
        attributes.map(
          ({content, anchor, align: textAlign}) =>
            createBlock('starter-kit/heading', {
              content,
              anchor,
              textAlign,
            }),
        ),
    },
    {
      type: 'raw',
      selector: 'h1,h2,h3,h4,h5,h6',
      schema: ({phrasingContentSchema, isPaste}) => {
        const schema = {
          children: phrasingContentSchema,
          attributes: isPaste ? [] : ['style', 'id'],
        };
        return {
          h1: schema,
          h2: schema,
          h3: schema,
          h4: schema,
          h5: schema,
          h6: schema,
        };
      },
      transform(node) {
        const attributes = getBlockAttributes(
          'core/heading',
          node.outerHTML,
        );
        const {textAlign} = node.style || {};

        attributes.level = getLevelFromHeadingNodeName(node.nodeName);

        if (
          textAlign === 'left' ||
          textAlign === 'center' ||
          textAlign === 'right'
        ) {
          attributes.align = textAlign;
        }

        return createBlock('starter-kit/heading', attributes);
      },
    },
    ...[1, 2, 3, 4, 5, 6].map((level) => ({
      type: 'prefix',
      prefix: Array(level + 1).join('#'),
      priority: 5,
      transform(content) {
        return createBlock('starter-kit/heading', {
          level,
          content,
        });
      },
    })),
    ...[1, 2, 3, 4, 5, 6].map((level) => ({
      type: 'enter',
      regExp: new RegExp(`^/(h|H)${ level }$`),
      priority: 5,
      transform: () => createBlock('starter-kit/heading', {level}),
    })),
  ],
  to: [
    {
      type: 'block',
      isMultiBlock: true,
      blocks: ['core/paragraph'],
      transform: (attributes) =>
        attributes.map(({content, textAlign: align}) =>
          createBlock('core/paragraph', {
            content,
            align,
          }),
        ),
    },
  ],
};

export default transforms;
