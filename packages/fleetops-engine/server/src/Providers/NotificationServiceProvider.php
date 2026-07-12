<?php

namespace Transitops\FleetOps\Providers;

use Transitops\Providers\CoreServiceProvider;
use Transitops\Support\NotificationRegistry;
use Transitops\Support\Utils;

if (!Utils::classExists(CoreServiceProvider::class)) {
    throw new \Exception('FleetOps cannot be loaded without `transitops/core-api` installed!');
}

/**
 * NotificationServiceProvider service provider.
 */
class NotificationServiceProvider extends CoreServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     *
     * @throws \Exception if the `transitops/core-api` package is not installed
     */
    public function boot()
    {
        // Register Notifications
        NotificationRegistry::register([
            \Transitops\FleetOps\Notifications\OrderAssigned::class,
            \Transitops\FleetOps\Notifications\OrderCanceled::class,
            \Transitops\FleetOps\Notifications\OrderDispatched::class,
            \Transitops\FleetOps\Notifications\OrderDispatchFailed::class,
            \Transitops\FleetOps\Notifications\OrderPing::class,
            \Transitops\FleetOps\Notifications\LateDeparture::class,
            \Transitops\FleetOps\Notifications\RouteDeviation::class,
            \Transitops\FleetOps\Notifications\ProlongedStoppage::class,
        ]);

        // Register Notifiables
        NotificationRegistry::registerNotifiable([
            \Transitops\FleetOps\Models\Contact::class,
            \Transitops\FleetOps\Models\Driver::class,
            \Transitops\FleetOps\Models\Vendor::class,
            \Transitops\FleetOps\Models\Fleet::class,
            'dynamic:customer',
            'dynamic:driver',
            'dynamic:facilitator',
        ]);
    }
}
