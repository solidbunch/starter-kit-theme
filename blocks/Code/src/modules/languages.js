const hljs = require('highlight.js/lib/core');

// Static map of available language modules
const languageModules = {
  bash: require('highlight.js/lib/languages/bash'),
  ini: require('highlight.js/lib/languages/ini'),
  json: require('highlight.js/lib/languages/json'),
  javascript: require('highlight.js/lib/languages/javascript'),
  php: require('highlight.js/lib/languages/php'),
  plaintext: require('highlight.js/lib/languages/plaintext'),
  scss: require('highlight.js/lib/languages/scss'),
  yaml: require('highlight.js/lib/languages/yaml'),
};

// Human-readable language labels for the UI
const languages = Object.keys(languageModules).map((key) => ({
  label: key,
  value: key,
}));

// Register all languages dynamically using the static map
languages.forEach(({value}) => {
  hljs.registerLanguage(value, languageModules[value]);
});

// Add 'auto' AFTER registration
languages.unshift({label: 'auto', value: 'auto'});

module.exports = {
  hljs,
  languages,
};
