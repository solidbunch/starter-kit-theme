const configs = [
    require('./build/core.config'),
    require('./build/shortcodes.config'),
    require('./build/widgets.config')
];

function isEmptyObject(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

const config = [];

const SYNC = process.env.SYNC;

configs.forEach(function (item) {
    if(typeof item.entry !== 'undefined' && isEmptyObject(item.entry) === false ) {
        config.push(item);
    }
});

module.exports = config;
