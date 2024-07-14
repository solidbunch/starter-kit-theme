const fs = require('fs');

// Функция для парсинга SCSS файла
function parseScss(filePath) {
  const data = fs.readFileSync(filePath, 'utf8');
  const lines = data.split('\n');
  const jsonObject = {};
  let currentBlockName = null;
  let currentObject = {};

  lines.forEach(line => {
    line = line.trim();

    // Обработка начала блока
    if (/^\/\/\s*start\s*/i.test(line)) {
      currentBlockName = line.replace(/^\/\/\s*start\s*/i, '').trim();
      currentObject = {};
    }

    // Обработка конца блока
    if (/^\/\/\s*end\s*/i.test(line)) {
      jsonObject[currentBlockName] = currentObject;
      currentBlockName = null;
      currentObject = {};
    }

    // Обработка переменных и объектов
    if (currentBlockName && !line.startsWith('//')) {
      const [key, value] = line.split(':').map(item => item.trim());
      if (key && value) {
        const cleanKey = key.replace(/[$"]/g, '');
        const cleanValue = value.replace(/[,;]/g, '');
        if (cleanValue !== '(' && cleanValue !== ')') {
          currentObject[cleanKey] = cleanValue;
        }
      }
    }
  });

  return jsonObject;
}

// Запись результата в файл
function writeJson(filePath, jsonObject) {
  const jsonContent = JSON.stringify(jsonObject, null, 2);
  fs.writeFileSync(filePath, jsonContent, 'utf8');
}

// Основная функция
function createJsonVariables(customScssPath, customJsonPath) {
  const jsonObject = parseScss(customScssPath);
  writeJson(customJsonPath, jsonObject);

  console.log('Парсинг завершен. Результат записан в variables.json');
}

module.exports = createJsonVariables;
