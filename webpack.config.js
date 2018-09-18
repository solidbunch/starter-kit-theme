const configs = [
    require('./assets/build/core.config'),
    require('./assets/build/shortcodes.config'),
    require('./assets/build/widgets.config')
];

function isEmptyObject(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

const config = [];

configs.forEach(function (item) {
    if(typeof item.entry !== 'undefined' && isEmptyObject(item.entry) === false ) {
        config.push(item);
    }
});

module.exports = config;