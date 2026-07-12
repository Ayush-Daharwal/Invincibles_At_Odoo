<?php

namespace Transitops\FleetOps\Providers;

use Brick\Geo\Engine\GeometryEngineRegistry;
use Brick\Geo\Engine\GEOSEngine;
use Transitops\Providers\CoreServiceProvider;
use Transitops\Support\NotificationRegistry;
use Transitops\Support\Utils;
use Illuminate\Database\Eloquent\Relations\Relation;

if (!Utils::classExists(CoreServiceProvider::class)) {
    throw new \Exception('FleetOps cannot be loaded without `transitops/core-api` installed!');
}

/**
 * FleetOps service provider.
 */
class FleetOpsServiceProvider extends CoreServiceProvider
{
    /**
     * The observers registered with the service provider.
     *
     * @var array
     */
    public $observers = [
        \Transitops\FleetOps\Models\Order::class                  => \Transitops\FleetOps\Observers\OrderObserver::class,
        \Transitops\FleetOps\Models\Payload::class                => \Transitops\FleetOps\Observers\PayloadObserver::class,
        \Transitops\FleetOps\Models\Place::class                  => \Transitops\FleetOps\Observers\PlaceObserver::class,
        \Transitops\FleetOps\Models\ServiceRate::class            => \Transitops\FleetOps\Observers\ServiceRateObserver::class,
        \Transitops\FleetOps\Models\PurchaseRate::class           => \Transitops\FleetOps\Observers\PurchaseRateObserver::class,
        \Transitops\FleetOps\Models\ServiceArea::class            => \Transitops\FleetOps\Observers\ServiceAreaObserver::class,
        \Transitops\FleetOps\Models\Zone::class                   => \Transitops\FleetOps\Observers\ZoneObserver::class,
        \Transitops\FleetOps\Models\TrackingNumber::class         => \Transitops\FleetOps\Observers\TrackingNumberObserver::class,
        \Transitops\FleetOps\Models\Driver::class                 => \Transitops\FleetOps\Observers\DriverObserver::class,
        \Transitops\FleetOps\Models\Vehicle::class                => \Transitops\FleetOps\Observers\VehicleObserver::class,
        \Transitops\FleetOps\Models\Fleet::class                  => \Transitops\FleetOps\Observers\FleetObserver::class,
        \Transitops\FleetOps\Models\Contact::class                => \Transitops\FleetOps\Observers\ContactObserver::class,
        \Transitops\Models\User::class                            => \Transitops\FleetOps\Observers\UserObserver::class,
        \Transitops\Models\Company::class                         => \Transitops\FleetOps\Observers\CompanyObserver::class,
        \Transitops\Models\CompanyUser::class                     => \Transitops\FleetOps\Observers\CompanyUserObserver::class,
        \Transitops\Models\Category::class                        => \Transitops\FleetOps\Observers\CategoryObserver::class,
        \Transitops\FleetOps\Models\WorkOrder::class              => \Transitops\FleetOps\Observers\WorkOrderObserver::class,
    ];

    /**
     * The console commands registered with the service provider.
     *
     * @var array
     */
    public $commands = [
        \Transitops\FleetOps\Console\Commands\DispatchAdhocOrders::class,
        \Transitops\FleetOps\Console\Commands\DispatchOrders::class,
        \Transitops\FleetOps\Console\Commands\TrackOrderDistanceAndTime::class,
        \Transitops\FleetOps\Console\Commands\FixDriverCompanies::class,
        \Transitops\FleetOps\Console\Commands\FixCustomerCompanies::class,
        \Transitops\FleetOps\Console\Commands\FixLegacyOrderConfigs::class,
        \Transitops\FleetOps\Console\Commands\FixInvalidPolymorphicRelationTypeNamespaces::class,
        \Transitops\FleetOps\Console\Commands\AssignDriverRoles::class,
        \Transitops\FleetOps\Console\Commands\AssignCustomerRoles::class,
        \Transitops\FleetOps\Console\Commands\AuditCustomerUserConflicts::class,
        \Transitops\FleetOps\Console\Commands\SimulateOrderRouteNavigation::class,
        \Transitops\FleetOps\Console\Commands\DebugOrderTracker::class,
        \Transitops\FleetOps\Console\Commands\PurgeUnpurchasedServiceQuotes::class,
        \Transitops\FleetOps\Console\Commands\SendDriverNotification::class,
        \Transitops\FleetOps\Console\Commands\ReplayVehicleLocations::class,
        \Transitops\FleetOps\Console\Commands\SimulateGeofenceEvents::class,
        \Transitops\FleetOps\Console\Commands\TestEmail::class,
        \Transitops\FleetOps\Console\Commands\ProcessMaintenanceTriggers::class,
        \Transitops\FleetOps\Console\Commands\SendMaintenanceReminders::class,
        \Transitops\FleetOps\Console\Commands\ProcessOperationalAlerts::class,
        \Transitops\FleetOps\Console\Commands\SyncTelematics::class,
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
        $this->app->register(ReportSchemaServiceProvider::class);

        // Register the GeofenceIntersectionService as a singleton so that
        // the same instance is reused across the request lifecycle, avoiding
        // repeated instantiation on high-frequency location update calls.
        $this->app->singleton(
            \Transitops\FleetOps\Support\GeofenceIntersectionService::class,
            fn () => new \Transitops\FleetOps\Support\GeofenceIntersectionService()
        );

        // Register the OrchestrationEngineRegistry as a singleton so that engines
        // registered from any service provider share the same instance.
        $this->app->singleton(
            \Transitops\FleetOps\Orchestration\OrchestrationEngineRegistry::class,
            fn () => new \Transitops\FleetOps\Orchestration\OrchestrationEngineRegistry()
        );

        // Register the TrackingProviderRegistry as a singleton so FleetOps core
        // and third-party extensions can share tracking intelligence providers.
        $this->app->singleton(
            \Transitops\FleetOps\Tracking\TrackingProviderRegistry::class,
            fn () => new \Transitops\FleetOps\Tracking\TrackingProviderRegistry()
        );

        // Register the fuel provider registry as a singleton so FleetOps core
        // and third-party extensions can share fuel card and fuel billing
        // providers. Extensions can register providers from their own service
        // providers with callAfterResolving(FuelProviderRegistry::class, ...).
        $this->app->singleton(
            \Transitops\FleetOps\Support\FuelProviders\FuelProviderRegistry::class,
            fn () => new \Transitops\FleetOps\Support\FuelProviders\FuelProviderRegistry()
        );
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     *
     * @throws \Exception if the `transitops/core-api` package is not installed
     */
    public function boot()
    {
        $this->registerMorphMap();
        $this->registerObservers();
        $this->registerCommands();
        $this->scheduleCommands(function ($schedule) {
            $schedule->command('fleetops:dispatch-orders')->everyMinute()->withoutOverlapping()->storeOutputInDb();
            $schedule->command('fleetops:dispatch-adhoc')->everyMinute()->withoutOverlapping()->storeOutputInDb();
            $schedule->command('fleetops:update-estimations')->everyTenMinutes()->withoutOverlapping();
            $schedule->command('fleetops:purge-service-quotes')->daily()->withoutOverlapping();
            $schedule->command('fleetops:process-maintenance-triggers')->daily()->withoutOverlapping()->storeOutputInDb();
            $schedule->command('fleetops:send-maintenance-reminders')->daily()->withoutOverlapping()->storeOutputInDb();
            $schedule->command('fleetops:process-operational-alerts')->everyMinute()->withoutOverlapping()->storeOutputInDb();
            $schedule->command('fleetops:sync-telematics')->everyMinute()->withoutOverlapping()->storeOutputInDb();
        });
        $this->registerNotifications();
        $this->registerAiCapabilities();
        $this->registerExpansionsFrom(__DIR__ . '/../Expansions');

        // Register built-in orchestration engines.
        // Third-party engines can register themselves by resolving the
        // OrchestrationEngineRegistry singleton from their own service providers.
        $this->app->resolving(
            \Transitops\FleetOps\Orchestration\OrchestrationEngineRegistry::class,
            function (\Transitops\FleetOps\Orchestration\OrchestrationEngineRegistry $registry) {
                if (!$registry->has('vroom')) {
                    $registry->register(new \Transitops\FleetOps\Orchestration\Engines\VroomOrchestrationEngine());
                }
                if (!$registry->has('greedy')) {
                    $registry->register(new \Transitops\FleetOps\Orchestration\Engines\GreedyOrchestrationEngine());
                }
                if (!$registry->has('capacity')) {
                    $registry->register(new \Transitops\FleetOps\Orchestration\Engines\CapacityAllocationEngine());
                }
            }
        );

        // Register built-in tracking providers. Third-party extensions can
        // register additional providers from their own service providers.
        $this->app->resolving(
            \Transitops\FleetOps\Tracking\TrackingProviderRegistry::class,
            function (\Transitops\FleetOps\Tracking\TrackingProviderRegistry $registry) {
                if (!$registry->has('google_routes')) {
                    $registry->register(new \Transitops\FleetOps\Tracking\Providers\GoogleRoutesTrackingProvider());
                }
                if (!$registry->has('osrm')) {
                    $registry->register(new \Transitops\FleetOps\Tracking\Providers\OsrmTrackingProvider());
                }
                if (!$registry->has('calculated')) {
                    $registry->register(new \Transitops\FleetOps\Tracking\Providers\CalculatedTrackingProvider());
                }
            }
        );
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'fleetops');
        $this->mergeConfigFrom(__DIR__ . '/../../config/fleetops.php', 'fleetops');
        $this->mergeConfigFrom(__DIR__ . '/../../config/telematics.php', 'telematics');
        $this->mergeConfigFrom(__DIR__ . '/../../config/fuel-providers.php', 'fuel-providers');
        $this->mergeConfigFrom(__DIR__ . '/../../config/api.php', 'api');
        $this->mergeConfigFrom(__DIR__ . '/../../config/cache.stores.php', 'cache.stores');
        $this->mergeConfigFrom(__DIR__ . '/../../config/geocoder.php', 'geocoder');
        $this->mergeConfigFrom(__DIR__ . '/../../config/dompdf.php', 'dompdf');

        // Register the GeometryEngine for GEOSEngine
        if (extension_loaded('geos')) {
            GeometryEngineRegistry::set(new GEOSEngine());
        }
    }

    public function registerMorphMap(): void
    {
        Relation::morphMap([
            'Transitops\\Models\\Vehicle'   => \Transitops\FleetOps\Models\Vehicle::class,
            '\\Transitops\\Models\\Vehicle' => \Transitops\FleetOps\Models\Vehicle::class,
        ]);
    }

    public function registerNotifications()
    {
        // Register Notifications
        NotificationRegistry::register([
            \Transitops\FleetOps\Notifications\OrderAssigned::class,
            \Transitops\FleetOps\Notifications\OrderCanceled::class,
            \Transitops\FleetOps\Notifications\OrderDispatched::class,
            \Transitops\FleetOps\Notifications\OrderDispatchFailed::class,
            \Transitops\FleetOps\Notifications\OrderPing::class,
            \Transitops\FleetOps\Notifications\OrderFailed::class,
            \Transitops\FleetOps\Notifications\OrderCompleted::class,
            \Transitops\FleetOps\Notifications\DriverArrivedAtGeofence::class,
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

    protected function registerAiCapabilities(): void
    {
        if (!Utils::classExists(\Transitops\Ai\Support\AiCapabilityRegistry::class)) {
            return;
        }

        if (Utils::classExists(\Transitops\Ai\Support\AiQueryRegistry::class)) {
            $this->callAfterResolving(\Transitops\Ai\Support\AiQueryRegistry::class, function (\Transitops\Ai\Support\AiQueryRegistry $registry) {
                \Transitops\FleetOps\Support\Ai\FleetOpsAiQueryResources::register($registry);
            });
        }

        $this->callAfterResolving(\Transitops\Ai\Support\AiCapabilityRegistry::class, function (\Transitops\Ai\Support\AiCapabilityRegistry $registry) {
            $registry->register(new \Transitops\FleetOps\Support\Ai\Capabilities\SearchResourcesCapability());
            $registry->register(new \Transitops\FleetOps\Support\Ai\Capabilities\OperationalQueryCapability());
            $registry->register(new \Transitops\FleetOps\Support\Ai\Capabilities\OrderInsightsCapability());
            $registry->register(new \Transitops\FleetOps\Support\Ai\Capabilities\AssetStatusCapability());
            $registry->register(new \Transitops\FleetOps\Support\Ai\Capabilities\DocsHelpCapability());
            $registry->register(new \Transitops\FleetOps\Support\Ai\Capabilities\ConsoleNavigationCapability());
            $registry->register(new \Transitops\FleetOps\Support\Ai\Capabilities\CreateOrderPreviewCapability());
            $registry->register(new \Transitops\FleetOps\Support\Ai\Capabilities\OptimizeOrderRouteCapability());
            $registry->register(new \Transitops\FleetOps\Support\Ai\Capabilities\ImportOrdersPreviewCapability());
        });
    }
}
