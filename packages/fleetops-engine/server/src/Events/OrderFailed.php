<?php

namespace Transitops\FleetOps\Events;

use Transitops\Events\ResourceLifecycleEvent;
use Transitops\FleetOps\Flow\Activity;
use Transitops\FleetOps\Models\Waypoint;

class OrderFailed extends ResourceLifecycleEvent
{
    /**
     * The event name.
     *
     * @var string
     */
    public $eventName = 'failed';

    /**
     * Assosciated activity which triggered the event.
     */
    public ?Activity $activity = null;

    /**
     * Assosciated order waypoint which event is for.
     */
    public ?Waypoint $waypoint = null;
}
