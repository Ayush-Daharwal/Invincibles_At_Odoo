<?php

namespace Transitops\FleetOps\Support;

use Transitops\FleetOps\Models\Order;
use Transitops\FleetOps\Tracking\TrackingIntelligenceService;
use Transitops\FleetOps\Tracking\TrackingOptions;

class OrderTracker
{
    public function __construct(protected Order $order)
    {
    }

    public function eta(array $options = []): array
    {
        return app(TrackingIntelligenceService::class)->eta($this->order, TrackingOptions::fromArray($options));
    }

    public function toArray(array $options = []): array
    {
        return app(TrackingIntelligenceService::class)->track($this->order, TrackingOptions::fromArray($options));
    }
}
