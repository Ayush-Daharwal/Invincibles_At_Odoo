<?php

namespace Transitops\FleetOps\Listeners;

use Transitops\FleetOps\Events\OrderCanceled;
use Transitops\FleetOps\Models\Driver;
use Transitops\FleetOps\Notifications\OrderCanceled as OrderCanceledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleOrderCanceled implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle(OrderCanceled $event)
    {
        /** @var \Transitops\FleetOps\Models\Order $order */
        $order    = $event->getModelRecord();
        if ($order->isIntegratedVendorOrder()) {
            $order->facilitator->provider()->callback('onCanceled', $order);
        }

        // Notify driver assigned order was canceled
        if ($order->hasDriverAssigned) {
            /** @var \Transitops\Models\Driver */
            $driver = Driver::where('uuid', $order->driver_assigned_uuid)->withoutGlobalScopes()->first();

            if ($driver) {
                $driver->notify(new OrderCanceledNotification($order));
            }
        }
    }
}
