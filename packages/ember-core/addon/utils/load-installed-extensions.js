import loadExtensions from './load-extensions';
import transitopsApiFetch from './transitops-api-fetch';
import isAuthenticated from './is-authenticated';

export default async function loadInstalledExtensions(additionalCoreEngines = []) {
    const CORE_ENGINES = [
        '@transitops/fleetops-engine',
        '@transitops/storefront-engine',
        '@transitops/registry-bridge-engine',
        '@transitops/dev-engine',
        '@transitops/iam-engine',
        '@transitops/ledger-engine',
        '@transitops/pallet-engine',
        '@transitops/ai-engine',
        '@transitops/customer-portal-engine',
        '@transitops/vroom-engine',
        '@transitops/valhalla-engine',
        ...additionalCoreEngines,
    ];
    const INDEXED_ENGINES = await loadExtensions();
    // const INSTALLED_ENGINES = await transitopsApiFetch('get', 'engines', {}, { namespace: '~registry/v1', fallbackResponse: [] });

    let INSTALLED_ENGINES = [];
    if (isAuthenticated()) {
        INSTALLED_ENGINES = await transitopsApiFetch('GET', 'engines', {}, { namespace: '~registry/v1', fallbackResponse: [] });
    }

    const isInstalledEngine = (engineName) => {
        return CORE_ENGINES.includes(engineName) || INSTALLED_ENGINES.find((pkg) => pkg.name === engineName);
    };

    return INDEXED_ENGINES.filter((pkg) => {
        return isInstalledEngine(pkg.name);
    });
}
