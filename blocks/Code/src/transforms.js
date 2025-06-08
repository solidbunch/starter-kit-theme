/**
 * Transforms for the starter-kit/code block.
 *
 * This module defines how the custom code block can be:
 * - Created from various block types or raw input (`from`)
 * - Converted into other block types (`to`)
 *
 * FROM:
 * - Typing triple backticks (```), like in Markdown, creates a code block.
 * - Paragraph blocks are converted into code blocks, preserving plain text.
 * - HTML blocks are converted into code blocks with rich text content.
 * - Raw <pre><code>...</code></pre> HTML is detected and transformed into a code block.
 *
 * TO:
 * - Code blocks can be converted back into paragraphs, retaining their content as plain text.
 *
 */

/**
 * WordPress dependencies
 */
const {createBlock} = wp.blocks;
const {create, toHTMLString} = wp.richText;

const transforms = {
  from: [
    {
      type: 'enter',
      regExp: /^```$/,
      transform: () => createBlock('starter-kit/code'),
      priority: 5,
    },
    {
      type: 'block',
      blocks: ['core/paragraph'],
      transform: ({content}) =>
        createBlock('starter-kit/code', {
          content,
        }),
      priority: 2,
    },
    {
      type: 'block',
      blocks: ['core/html'],
      transform: ({content: text}) => {
        return createBlock('starter-kit/code', {
          // The HTML is plain text (with plain line breaks), so
          // convert it to rich text.
          content: toHTMLString({value: create({text})}),
        });
      },
      priority: 2,
    },
    {
      type: 'raw',
      isMatch: (node) =>
        node.nodeName === 'PRE' &&
        node.children.length === 1 &&
        node.firstChild.nodeName === 'CODE',
      schema: {
        pre: {
          children: {
            code: {
              children: {
                '#text': {},
              },
            },
          },
        },
      },
      priority: 5,
    },
  ],
  to: [
    {
      type: 'block',
      blocks: ['core/paragraph'],
      transform: ({content}) =>
        createBlock('core/paragraph', {
          content,
        }),
      priority: 2,
    },
  ],
};

export default transforms;
