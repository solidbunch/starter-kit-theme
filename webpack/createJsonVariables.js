const fs = require('fs');

// Function to parse SCSS file
function parseScss(filePath) {
  const data = fs.readFileSync(filePath, 'utf8');
  const lines = data.split('\n');
  const jsonObject = {};
  let currentBlockName = null;
  let currentObject = {};

  lines.forEach(line => {
    line = line.trim();

    // Handle start of block
    if (/^\/\/\s*start\s*/i.test(line)) {
      currentBlockName = line.replace(/^\/\/\s*start\s*/i, '').trim();
      currentObject = {};
    }

    // Handle end of block
    if (/^\/\/\s*end\s*/i.test(line)) {
      jsonObject[currentBlockName] = currentObject;
      currentBlockName = null;
      currentObject = {};
    }

    // Handle variables and objects
    if (currentBlockName && !line.startsWith('//')) {
      const [key, value] = line.split(':').map(item => item.trim());
      if (key && value) {
        const cleanKey = key.replace(/[$"]/g, '');
        let cleanValue = value.replace(/[,;]/g, '');

        // Convert px values and zero values to numbers
        if (/^\d+px$/.test(cleanValue)) {
          cleanValue = parseInt(cleanValue.replace('px', ''), 10);
        } else if (cleanValue === '0') {
          cleanValue = 0;
        }

        if (cleanValue !== '(' && cleanValue !== ')') {
          currentObject[cleanKey] = cleanValue;
        }
      }
    }
  });

  return jsonObject;
}

// Function to write result to file
function writeJson(filePath, jsonObject) {
  const jsonContent = JSON.stringify(jsonObject, null, 2);
  fs.writeFileSync(filePath, jsonContent, 'utf8');
}

// Main function
function createJsonVariables(customScssPath, customJsonPath) {
  const jsonObject = parseScss(customScssPath);
  writeJson(customJsonPath, jsonObject);

  console.log('Parsing completed. Result saved to variables.json');
}

module.exports = createJsonVariables;
