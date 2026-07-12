<?php

namespace Transitops\Storefront\Observers;

use Transitops\FleetOps\Models\Order;
use Transitops\Storefront\Support\Storefront;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @return void
     */
    public function creating(Order $order)
    {
        // Set the storefront order config if none is set already
        if (!$order->order_config_uuid) {
            $orderConfig = Storefront::getDefaultOrderConfig();
            if ($orderConfig) {
                $order->order_config_uuid = $orderConfig->uuid;
            }
        }
    }
}
