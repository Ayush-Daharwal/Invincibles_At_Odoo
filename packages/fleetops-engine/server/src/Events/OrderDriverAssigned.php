<?php

namespace Transitops\FleetOps\Events;

use Transitops\Events\ResourceLifecycleEvent;
use Transitops\FleetOps\Flow\Activity;

class OrderDriverAssigned extends ResourceLifecycleEvent
{
    /**
     * The event name.
     *
     * @var string
     */
    public $eventName = 'driver_assigned';

    /**
     * Assosciated activity which triggered the event.
     */
    public ?Activity $activity = null;
}
