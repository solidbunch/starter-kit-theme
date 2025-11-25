import metadata from '../block.json';

const {registerBlockType} = wp.blocks;
const {__} = wp.i18n;
const {TextControl, PanelBody} = wp.components;
const {InspectorControls, useBlockProps} = wp.blockEditor || wp.editor;

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
    <path d="M66.52 7.74a8 8 0 0 0-5.63-5.66C56.7.67 34 .67 34 .67s-22.7 0-26.89 1.41A8 8 0 0 0 1.48 7.74 84.3 84.3 0 0 0 .07 24a84.3 84.3 0 0 0 1.41 16.26 8 8 0 0 0 5.63 5.66C11.3 47.33 34 47.33 34 47.33s22.7 0 26.89-1.41a8 8 0 0 0 5.63-5.66A84.3 84.3 0 0 0 67.93 24a84.3 84.3 0 0 0-1.41-16.26z" fill="#212121" fillOpacity=".8" />
    <path d="M45 24 27 14v20" fill="#fff" />
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
            style={{
              position: 'relative',
              display: 'block',
              width: '100%',
              backgroundColor: '#000',
              overflow: 'hidden',
              aspectRatio: aspectRatio || '16/9',
              cursor: 'pointer',
            }}
          >
            {thumbnail ? (
              <img
                src={thumbnail}
                alt={title}
                style={{width: '100%', height: '100%', objectFit: 'cover', filter: 'brightness(0.8)'}}
              />
            ) : (
              <div style={{color: '#fff', padding: '1rem'}}>{__('Paste a YouTube URL', 'starter-kit')}</div>
            )}
            <div
              className="yt-lite__play"
              aria-hidden="true"
              style={{
                position: 'absolute',
                top: '50%',
                left: '50%',
                transform: 'translate(-50%,-50%)',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                width: '68px',
                height: '48px',
                borderRadius: '10px',
                background: 'rgba(0,0,0,.6)',
              }}
            >
              <PlaySvg />
            </div>
          </div>
        </>
      );
    },
    save: ({attributes}) => {
      const {videoId, title, poster, params, aspectRatio} = attributes;
      const thumbnail = poster || (videoId ? `https://i.ytimg.com/vi/${videoId}/hqdefault.jpg` : '');
      return (
        <div
          className="yt-lite"
          data-video-id={videoId || ''}
          data-params={params || 'rel=0'}
          role="button"
          aria-label={title || 'YouTube video'}
          style={{position: 'relative', display: 'block', width: '100%', backgroundColor: '#000', overflow: 'hidden', aspectRatio: aspectRatio || '16/9', cursor: 'pointer'}}
        >
          {thumbnail ? (
            <img src={thumbnail} alt={title || 'YouTube video'} loading="lazy" decoding="async" style={{width: '100%', height: '100%', objectFit: 'cover', filter: 'brightness(0.8)'}} />
          ) : null}
          <div className="yt-lite__play" aria-hidden="true" style={{position: 'absolute', top: '50%', left: '50%', transform: 'translate(-50%,-50%)', display: 'flex', alignItems: 'center', justifyContent: 'center', width: '68px', height: '48px', borderRadius: '10px', background: 'rgba(0,0,0,.6)'}}>
            <PlaySvg />
          </div>
        </div>
      );
    },
  });

