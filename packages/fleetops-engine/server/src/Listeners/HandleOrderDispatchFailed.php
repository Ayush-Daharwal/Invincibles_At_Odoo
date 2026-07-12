<?php

namespace Transitops\FleetOps\Listeners;

use Transitops\FleetOps\Events\OrderDispatchFailed;
use Transitops\FleetOps\Notifications\OrderDispatchFailed as OrderDispatchFailedNotification;
use Transitops\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleOrderDispatchFailed implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle(OrderDispatchFailed $event)
    {
        /** @var \Transitops\FleetOps\Models\Order $order */
        $order = $event->getModelRecord();

        /** @var User */
        $createdBy = User::where('uuid', $order->created_by_uuid)->first();

        // notify driver assigned order was canceled
        if ($createdBy) {
            $createdBy->notify(new OrderDispatchFailedNotification($order, $event));
        }
    }
}
