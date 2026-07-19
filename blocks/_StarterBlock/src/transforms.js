/**
 * Block transforms (optional) — how this block can be created from / converted to other blocks.
 * Delete this file (and its import in index.jsx) if the block doesn't need transforms.
 *
 * See Heading/src/transforms.js for a fuller example (raw HTML, prefix and slash-command
 * transforms).
 */
import metadata from '../block.json';

const {createBlock} = wp.blocks;

const transforms = {
  from: [
    {
      type: 'block',
      blocks: ['core/paragraph'],
      // metadata.name, not a hardcoded string — keeps the transform working after the
      // copy-rename flow changes the block name in block.json
      transform: ({content}) => createBlock(metadata.name, {heading: content}),
    },
  ],
  to: [
    {
      type: 'block',
      blocks: ['core/paragraph'],
      transform: ({heading}) => createBlock('core/paragraph', {content: heading}),
    },
  ],
};

export default transforms;
