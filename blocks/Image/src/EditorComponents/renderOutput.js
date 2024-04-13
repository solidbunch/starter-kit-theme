import EditorHandlers from "../Handlers/EditorHandlers";

const {useBlockProps, MediaPlaceholder} = wp.blockEditor;

const RenderOutput = (props) => {

  const {attributes, className} = props;

  const blockProps = useBlockProps({
    className: [className],
  });

  return (
    <div  {...blockProps} key="blockControls">
      {attributes.mainImage.src ? (
        <img src={attributes.mainImage.src} alt="Uploaded" width={attributes.mainImage.width} height={attributes.mainImage.height}/>
      ) : (
        <MediaPlaceholder
          icon="format-image"
          labels={{title: 'Add Image'}}
          onSelect={(media) => EditorHandlers.changeImage(media, props)}
        />
      )}

    </div>
  );
};

export default RenderOutput;
