const {addFilter} = wp.hooks;
const {createHigherOrderComponent} = wp.compose;

const withCustomOption = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    // Check if the block is from the specified category
    if (props.name.includes('category-name')) {
      // Add your custom option UI and functionality here
    }

    return <BlockEdit {...props} />;
  };
}, 'withCustomOption');

addFilter(
  'editor.BlockEdit',
  'starter_kit/add-spacer-option',
  withCustomOption,
);
