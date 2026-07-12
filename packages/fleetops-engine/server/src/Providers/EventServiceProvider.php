<?php

namespace Transitops\FleetOps\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*
         * Order Events
         */
        \Transitops\FleetOps\Events\OrderCanceled::class       => [\Transitops\FleetOps\Listeners\HandleOrderCanceled::class, \Transitops\Listeners\SendResourceLifecycleWebhook::class, \Transitops\FleetOps\Listeners\NotifyOrderEvent::class],
        \Transitops\FleetOps\Events\OrderDispatched::class     => [\Transitops\FleetOps\Listeners\HandleOrderDispatched::class, \Transitops\Listeners\SendResourceLifecycleWebhook::class, \Transitops\FleetOps\Listeners\NotifyOrderEvent::class],
        \Transitops\FleetOps\Events\OrderDispatchFailed::class => [\Transitops\FleetOps\Listeners\HandleOrderDispatchFailed::class, \Transitops\Listeners\SendResourceLifecycleWebhook::class, \Transitops\FleetOps\Listeners\NotifyOrderEvent::class],
        \Transitops\FleetOps\Events\OrderDriverAssigned::class => [\Transitops\FleetOps\Listeners\HandleOrderDriverAssigned::class, \Transitops\Listeners\SendResourceLifecycleWebhook::class, \Transitops\FleetOps\Listeners\NotifyOrderEvent::class],
        \Transitops\FleetOps\Events\OrderCompleted::class      => [\Transitops\Listeners\SendResourceLifecycleWebhook::class, \Transitops\FleetOps\Listeners\NotifyOrderEvent::class, \Transitops\FleetOps\Listeners\HandleDeliveryCompletion::class],
        \Transitops\FleetOps\Events\OrderFailed::class         => [\Transitops\Listeners\SendResourceLifecycleWebhook::class, \Transitops\FleetOps\Listeners\NotifyOrderEvent::class],
        \Transitops\FleetOps\Events\OrderReady::class          => [\Transitops\FleetOps\Listeners\HandleOrderReady::class],

        /*
         * Geofence Events
         *
         * Each event is handled by a domain listener (business logic, event log)
         * and the generic SendResourceLifecycleWebhook listener (webhook delivery).
         */
        \Transitops\FleetOps\Events\GeofenceEntered::class => [
            \Transitops\FleetOps\Listeners\HandleGeofenceEntered::class,
            \Transitops\Listeners\SendResourceLifecycleWebhook::class,
        ],
        \Transitops\FleetOps\Events\GeofenceExited::class  => [
            \Transitops\FleetOps\Listeners\HandleGeofenceExited::class,
            \Transitops\Listeners\SendResourceLifecycleWebhook::class,
        ],
        \Transitops\FleetOps\Events\GeofenceDwelled::class => [
            \Transitops\FleetOps\Listeners\HandleGeofenceDwelled::class,
            \Transitops\Listeners\SendResourceLifecycleWebhook::class,
        ],

        /*
         * Core Events
         */
        \Transitops\Events\UserRemovedFromCompany::class => [\Transitops\FleetOps\Listeners\HandleUserRemovedFromCompany::class],

        /*
         * Scheduling Events
         */
        \Transitops\Events\ScheduleItemCreated::class => [\Transitops\FleetOps\Listeners\NotifyDriverOnShiftChange::class],
        \Transitops\Events\ScheduleItemUpdated::class => [\Transitops\FleetOps\Listeners\NotifyDriverOnShiftChange::class],
    ];
}
