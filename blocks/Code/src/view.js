const hljs = require('highlight.js/lib/core');

hljs.registerLanguage('bash', require('highlight.js/lib/languages/bash'));
hljs.registerLanguage('ini', require('highlight.js/lib/languages/ini'));
hljs.registerLanguage('json', require('highlight.js/lib/languages/json'));
hljs.registerLanguage('javascript', require('highlight.js/lib/languages/javascript'));
hljs.registerLanguage('php', require('highlight.js/lib/languages/php'));
hljs.registerLanguage('plaintext', require('highlight.js/lib/languages/plaintext'));
hljs.registerLanguage('scss', require('highlight.js/lib/languages/scss'));
//hljs.registerLanguage('xml', require('highlight.js/lib/languages/xml'));
hljs.registerLanguage('yaml', require('highlight.js/lib/languages/yaml'));

(function() {
  'use strict';

  window.addEventListener('load', () => {
    highlightElement();
    addCopyButtons();
  });

  function highlightElement() {
    document.querySelectorAll('pre code').forEach((block) => {
      const className = block.className || '';

      // If the language is specified, we use the standard backlight
      if (className.includes('language-')) {
        hljs.highlightElement(block);
      } else {
        // auto + fallback
        const result = hljs.highlightAuto(block.textContent);

        if (result.relevance < 5) {
          const fallback = hljs.highlight(block.textContent, {language: 'plaintext'});
          block.innerHTML = fallback.value;
          block.classList.add('hljs', 'language-plaintext');
        } else {
          block.innerHTML = result.value;
          block.classList.add('hljs', `language-${result.language}`);
        }
      }
    });
  }

  function addCopyButtons() {
    document.querySelectorAll('pre').forEach((pre) => {
      const button = document.createElement('button');
      button.classList.add('btn', 'copy_clipboard');
      button.innerHTML = '<i class="sk-icon sk-copy"></i>';
      button.dataset.originalIcon = button.innerHTML;
      button.dataset.timeoutId = '';

      button.addEventListener('click', () => {
        const code = pre.querySelector('code').innerText;
        copyToClipboard(code, button);
      });

      pre.appendChild(button);
    });
  }

  function copyToClipboard(text, button) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);

    // change icon 2 seconds
    const originalIcon = button.dataset.originalIcon;
    button.innerHTML = '<i class="sk-icon sk-check"></i>';
    button.classList.add('active');

    if (button.dataset.timeoutId) {
      clearTimeout(button.dataset.timeoutId);
    }

    const timeoutId = setTimeout(() => {
      button.innerHTML = originalIcon;
      button.classList.remove('active');
      button.dataset.timeoutId = '';
    }, 2000);

    button.dataset.timeoutId = timeoutId;
  }

})();
