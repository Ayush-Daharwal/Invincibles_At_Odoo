<?php

namespace Transitops\FleetOps\Observers;

use Transitops\FleetOps\Models\Payload;

class PayloadObserver
{
    /**
     * Handle the Payload "creating" event.
     *
     * @return void
     */
    public function created(Payload $payload)
    {
        $payload->updateOrderDistanceAndTime();
    }
}
