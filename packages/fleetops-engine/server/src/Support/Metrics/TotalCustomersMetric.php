<?php

namespace Transitops\FleetOps\Support\Metrics;

use Transitops\FleetOps\Models\Contact;

class TotalCustomersMetric extends AbstractMetric
{
    public static function slug(): string
    {
        return 'total_customers';
    }

    public function format(): string
    {
        return 'count';
    }

    protected function query(?\DateTimeInterface $start, ?\DateTimeInterface $end)
    {
        return Contact::where('company_uuid', $this->company->uuid)
            ->where('type', 'customer');
    }

    protected function aggregate($query): int
    {
        return (int) $query->count();
    }
}
