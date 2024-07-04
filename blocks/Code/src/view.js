import hljs from 'highlight.js';
(function () {
  "use strict";

  window.addEventListener('load', () => {
    highlightElement();
    addCopyButtons();
  });

  function highlightElement() {
    document.querySelectorAll('pre code').forEach((block) => {
      hljs.highlightElement(block);
    });
  }

  function addCopyButtons() {
    document.querySelectorAll('pre').forEach((pre) => {
      const button = document.createElement('button');
      button.classList.add('btn','copy_clipboard');
      button.innerHTML = '<i class="sk-icon sk-copy"></i>';
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
    const originalIcon = button.innerHTML;
    button.innerHTML = '<i class="sk-icon sk-check"></i>';
    button.classList.add('active');

    setTimeout(() => {
      button.innerHTML = originalIcon;
      button.classList.remove('active');
    }, 2000);
  }

})();
