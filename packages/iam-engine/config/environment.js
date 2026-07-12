'use strict';
const { name, transitops } = require('../package');

module.exports = function (environment) {
    let ENV = {
        modulePrefix: name,
        environment,
        mountedEngineRoutePrefix: getMountedEngineRoutePrefix(),
    };

    return ENV;
};

function getMountedEngineRoutePrefix() {
    let mountedEngineRoutePrefix = 'iam';
    if (transitops && typeof transitops.route === 'string') {
        mountedEngineRoutePrefix = transitops.route;
    }

    return `console.${mountedEngineRoutePrefix}`;
}
