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
