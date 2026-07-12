<?php

namespace Transitops\Storefront\Providers;

use Transitops\FleetOps\Providers\FleetOpsServiceProvider;
use Transitops\Providers\CoreServiceProvider;

if (!class_exists(CoreServiceProvider::class)) {
    throw new \Exception('Storefront cannot be loaded without `transitops/core-api` installed!');
}

if (!class_exists(FleetOpsServiceProvider::class)) {
    throw new \Exception('Storefront cannot be loaded without `transitops/fleetops-api` installed!');
}

/**
 * Storefront service provider.
 */
class StorefrontServiceProvider extends CoreServiceProvider
{
    /**
     * The observers registered with the service provider.
     *
     * @var array
     */
    public $observers = [
        \Transitops\Storefront\Models\Product::class   => \Transitops\Storefront\Observers\ProductObserver::class,
        \Transitops\Storefront\Models\Network::class   => \Transitops\Storefront\Observers\NetworkObserver::class,
        \Transitops\Storefront\Models\Catalog::class   => \Transitops\Storefront\Observers\CatalogObserver::class,
        \Transitops\Storefront\Models\FoodTruck::class => \Transitops\Storefront\Observers\FoodTruckObserver::class,
        \Transitops\Models\Company::class              => \Transitops\Storefront\Observers\CompanyObserver::class,
    ];

    /**
     * The middleware groups registered with the service provider.
     *
     * @var array
     */
    public $middleware = [
        'storefront.api' => [
            \Transitops\Storefront\Http\Middleware\ThrottleRequests::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Transitops\Storefront\Http\Middleware\SetStorefrontSession::class,
            \Transitops\Http\Middleware\ConvertStringBooleans::class,
            \Transitops\Http\Middleware\SetGlobalHeaders::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Transitops\Http\Middleware\LogApiRequests::class,
        ],
    ];

    /**
     * The console commands registered with the service provider.
     *
     * @var array
     */
    public $commands = [
        \Transitops\Storefront\Console\Commands\NotifyStorefrontOrderNearby::class,
        \Transitops\Storefront\Console\Commands\SendOrderNotification::class,
        \Transitops\Storefront\Console\Commands\PurgeExpiredCarts::class,
        \Transitops\Storefront\Console\Commands\MigrateStripeSandboxCustomers::class,
    ];

    /**
     * Register any application services.
     *
     * Within the register method, you should only bind things into the
     * service container. You should never attempt to register any event
     * listeners, routes, or any other piece of functionality within the
     * register method.
     *
     * More information on this can be found in the Laravel documentation:
     * https://laravel.com/docs/8.x/providers
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(FleetOpsServiceProvider::class);
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     *
     * @throws \Exception if the `transitops/core-api` package is not installed
     * @throws \Exception if the `transitops/fleetops-api` package is not installed
     */
    public function boot()
    {
        $this->registerCommands();
        $this->scheduleCommands(function ($schedule) {
            $schedule->command('storefront:notify-order-nearby')->everyMinute()->storeOutputInDb();
            $schedule->command('storefront:purge-carts')->daily()->storeOutputInDb();
        });
        $this->registerObservers();
        $this->registerMiddleware();
        $this->registerExpansionsFrom(__DIR__ . '/../Expansions');
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config/database.connections.php', 'database.connections');
        $this->mergeConfigFrom(__DIR__ . '/../../config/storefront.php', 'storefront');
        $this->mergeConfigFrom(__DIR__ . '/../../config/api.php', 'storefront.api');
    }
}
