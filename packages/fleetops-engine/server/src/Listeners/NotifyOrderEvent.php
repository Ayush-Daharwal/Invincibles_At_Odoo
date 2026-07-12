<?php

namespace Transitops\FleetOps\Listeners;

use Transitops\FleetOps\Notifications\OrderAssigned;
use Transitops\FleetOps\Notifications\OrderCanceled;
use Transitops\FleetOps\Notifications\OrderCompleted;
use Transitops\FleetOps\Notifications\OrderDispatched;
use Transitops\FleetOps\Notifications\OrderDispatchFailed;
use Transitops\FleetOps\Notifications\OrderFailed;
use Transitops\Support\NotificationRegistry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyOrderEvent implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        // Get the order record from the event
        $order = $event->getModelRecord();

        if ($order) {
            // Send a notification for order events
            if ($event instanceof \Transitops\FleetOps\Events\OrderCanceled) {
                $reason = $event->activity ? $event->activity->get('details') : '';
                NotificationRegistry::notify(OrderCanceled::class, $order, $reason, $event->waypoint);
            }

            if ($event instanceof \Transitops\FleetOps\Events\OrderCompleted) {
                NotificationRegistry::notify(OrderCompleted::class, $order, $event->waypoint);
            }

            if ($event instanceof \Transitops\FleetOps\Events\OrderFailed) {
                $reason = $event->activity ? $event->activity->get('details') : '';
                NotificationRegistry::notify(OrderFailed::class, $order, $reason, $event->waypoint);
            }

            if ($event instanceof \Transitops\FleetOps\Events\OrderDispatchFailed) {
                NotificationRegistry::notify(OrderDispatchFailed::class, $order);
            }

            if ($event instanceof \Transitops\FleetOps\Events\OrderDispatched) {
                NotificationRegistry::notify(OrderDispatched::class, $order, $event->waypoint);
            }

            if ($event instanceof \Transitops\FleetOps\Events\OrderDriverAssigned) {
                NotificationRegistry::notify(OrderAssigned::class, $order);
            }
        }
    }
}
