/* eslint-env node */
'use strict';
const { name, transitops } = require('../package');

module.exports = function (environment) {
    let ENV = {
        modulePrefix: name,
        environment,
        mountedEngineRoutePrefix: getMountedEngineRoutePrefix(),

        'ember-leaflet': {
            excludeCSS: true,
            excludeJS: true,
            excludeImages: true,
        },
    };

    return ENV;
};

function getMountedEngineRoutePrefix() {
    let mountedEngineRoutePrefix = 'developers';
    if (transitops && typeof transitops.route === 'string') {
        mountedEngineRoutePrefix = transitops.route;
    }

    return `console.${mountedEngineRoutePrefix}`;
}
