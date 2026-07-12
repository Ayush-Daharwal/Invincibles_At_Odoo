export default function getMountedEngineRoutePrefix(defaultName, transitops = {}) {
    let mountedEngineRoutePrefix = defaultName;
    if (transitops && typeof transitops.route === 'string') {
        mountedEngineRoutePrefix = transitops.route;
    }

    return `console.${mountedEngineRoutePrefix}.`;
}
