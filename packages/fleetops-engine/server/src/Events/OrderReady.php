<?php

namespace Transitops\FleetOps\Events;

use Transitops\Events\ResourceLifecycleEvent;
use Transitops\FleetOps\Flow\Activity;

class OrderReady extends ResourceLifecycleEvent
{
    /**
     * The event name.
     *
     * @var string
     */
    public $eventName = 'ready';

    /**
     * Assosciated activity which triggered the event.
     */
    public ?Activity $activity = null;
}
