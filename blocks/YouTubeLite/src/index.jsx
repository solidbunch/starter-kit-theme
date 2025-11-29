import metadata from '../block.json';

const {registerBlockType} = wp.blocks;
const {__} = wp.i18n;
const {TextControl, PanelBody} = wp.components;
const {InspectorControls, useBlockProps} = wp.blockEditor;

function extractId(input) {
  if (!input) return '';
  // youtu.be/<id>
  let m = String(input).match(/youtu\.be\/([a-zA-Z0-9_-]{6,})/i);
  if (m && m[1]) return m[1];
  // youtube.com/watch?v=<id>
  m = String(input).match(/[?&]v=([a-zA-Z0-9_-]{6,})/i);
  if (m && m[1]) return m[1];
  // youtube.com/embed/<id>
  m = String(input).match(/youtube\.com\/embed\/([a-zA-Z0-9_-]{6,})/i);
  if (m && m[1]) return m[1];
  // Assume raw ID
  if (/^[a-zA-Z0-9_-]{6,}$/.test(input)) return input;
  return '';
}

const PlaySvg = () => (
  <svg xmlns="http://www.w3.org/2000/svg" width="68" height="48" viewBox="0 0 68 48">
    <path fill="#f03"
      d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55c-2.93.78-4.63 3.26-5.42 6.19C.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26"/>
    <path fill="#fff" d="M45 24 27 14v20"/>
  </svg>
);

registerBlockType(
  metadata,
  {
    edit: ({attributes, setAttributes}) => {
      const {url, videoId, title, poster, params, aspectRatio} = attributes;
      const effectiveId = videoId || extractId(url);
      const thumbnail = poster || (effectiveId ? `https://i.ytimg.com/vi/${effectiveId}/hqdefault.jpg` : '');

      const blockProps = useBlockProps({
        className: 'yt-lite',
      });

      return (
        <>
          <InspectorControls>
            <PanelBody title={__('Settings', 'starter-kit')}>
              <TextControl
                label={__('YouTube URL or ID', 'starter-kit')}
                value={url}
                onChange={(v) => {
                  const id = extractId(v);
                  setAttributes({
                    url: v,
                    videoId: id,
                    poster: id ? `https://i.ytimg.com/vi/${id}/hqdefault.jpg` : poster,
                  });
                }}
                help={__('Paste a YouTube URL or video ID', 'starter-kit')}
              />
              <TextControl
                label={__('Title', 'starter-kit')}
                value={title}
                onChange={(v) => setAttributes({title: v})}
              />
              <TextControl
                label={__('Poster (optional)', 'starter-kit')}
                value={poster}
                onChange={(v) => setAttributes({poster: v})}
                help={__('Leave empty to use the default YouTube thumbnail', 'starter-kit')}
              />
              <TextControl
                label={__('Iframe params', 'starter-kit')}
                value={params}
                onChange={(v) => setAttributes({params: v})}
                help={__('Example: rel=0&start=10', 'starter-kit')}
              />
              <TextControl
                label={__('Aspect ratio', 'starter-kit')}
                value={aspectRatio}
                onChange={(v) => setAttributes({aspectRatio: v})}
                help={__('CSS aspect-ratio value, e.g. 16/9 or 4/3', 'starter-kit')}
              />
            </PanelBody>
          </InspectorControls>
          <div
            {...blockProps}
            role="button"
            aria-label={title}
          >
            {thumbnail ? (
              <img
                src={thumbnail}
                alt={title}
              />
            ) : (
              <div className="yt-lite__placeholder">
                {__('Paste a YouTube URL', 'starter-kit')}
              </div>
            )}
            <div
              className="yt-lite__play"
              aria-hidden="true"
            >
              <PlaySvg />
            </div>
          </div>
        </>
      );
    },
    save: (props) => {
      const {attributes} = props;
      const {videoId, title, poster, params} = attributes;
      const thumbnail = poster || (videoId ? `https://i.ytimg.com/vi/${videoId}/hqdefault.jpg` : '');

      const {className} = useBlockProps.save();
      const blockClass = ['yt-lite', className].filter(Boolean).join(' ').trim();

      const blockProps = {
        className: blockClass,
        'data-video-id': videoId || '',
        'data-params': params || 'rel=0',
        role: 'button',
        'aria-label': title || 'YouTube video',
      };

      return (
        <div {...blockProps}>
          {thumbnail ? (
            <img
              src={thumbnail}
              alt={title || 'YouTube video'}
              loading="lazy"
              decoding="async"
            />
          ) : null}
          <div
            className="yt-lite__play"
            aria-hidden="true"
          >
            <PlaySvg />
          </div>
        </div>
      );
    },
  });

