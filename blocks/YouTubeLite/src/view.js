/* Minimal click-to-load for YouTube Lite block */
(function () {
  function toIframe(wrapper) {
    if (!wrapper || wrapper.__ytActivated) return;
    const id = wrapper.getAttribute('data-video-id');
    if (!id) return;

    // Always ensure autoplay=1 is present so video starts immediately after click
    const rawParams = wrapper.getAttribute('data-params') || 'rel=0';
    const search = new URLSearchParams(String(rawParams).replace(/^\?/, ''));
    if (!search.has('autoplay')) {
      search.set('autoplay', '1');
    }
    const params = search.toString();
    const iframe = document.createElement('iframe');
    iframe.setAttribute('src', 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?' + params);
    iframe.setAttribute('title', 'YouTube video player');
    iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
    iframe.setAttribute('allowfullscreen', 'true');
    iframe.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
    iframe.setAttribute('loading', 'eager');
    iframe.style.width = '100%';
    iframe.style.height = '100%';
    iframe.style.border = '0';
    wrapper.__ytActivated = true;
    wrapper.innerHTML = '';
    wrapper.appendChild(iframe);
  }

  document.addEventListener(
    'click',
    function (e) {
      const target = e.target && e.target.closest && e.target.closest('.yt-lite');
      if (!target) return;
      e.preventDefault();
      toIframe(target);
    },
    {capture: true, passive: false}
  );
})();

