<?php

namespace Transitops\FleetOps\Support\Metrics;

use Transitops\FleetOps\Support\LiveOrderQuery;

class ActiveLiveOrdersMetric extends AbstractMetric
{
    public static function slug(): string
    {
        return 'active_live_orders';
    }

    public function format(): string
    {
        return 'count';
    }

    protected function query(?\DateTimeInterface $start, ?\DateTimeInterface $end)
    {
        return LiveOrderQuery::make($this->company->uuid, ['active' => true]);
    }

    protected function aggregate($query): int
    {
        return (int) $query->count();
    }
}
