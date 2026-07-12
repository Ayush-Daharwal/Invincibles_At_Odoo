<?php

namespace Transitops\Storefront\Providers;

use Transitops\Storefront\Models\Product;
use Transitops\Storefront\Observers\ProductObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The model observers for your application.
     *
     * @var array
     */
    // protected $observers = [
    //     Product::class => [ProductObserver::class],
    // ];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*
         * Order Events
         */
        \Transitops\FleetOps\Events\OrderStarted::class        => [\Transitops\Storefront\Listeners\HandleOrderStarted::class],
        \Transitops\FleetOps\Events\OrderDispatched::class     => [\Transitops\Storefront\Listeners\HandleOrderDispatched::class],
        \Transitops\FleetOps\Events\OrderCompleted::class      => [\Transitops\Storefront\Listeners\HandleOrderCompleted::class],
        \Transitops\FleetOps\Events\OrderDriverAssigned::class => [\Transitops\Storefront\Listeners\HandleOrderDriverAssigned::class],
    ];
}
