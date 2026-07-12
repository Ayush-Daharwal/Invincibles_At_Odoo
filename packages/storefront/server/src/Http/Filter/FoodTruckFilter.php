<?php

namespace Transitops\Storefront\Http\Filter;

use Transitops\FleetOps\Http\Filter\OrderFilter as FleetOpsOrderFilter;
use Transitops\FleetOps\Models\ServiceArea;

class FoodTruckFilter extends FleetOpsOrderFilter
{
    public function queryForInternal()
    {
        $this->builder->where('company_uuid', $this->session->get('company'));
    }

    public function queryForPublic()
    {
        $this->builder->where('company_uuid', $this->session->get('company'));
        $this->builder->whereHas('vehicle');
    }

    public function storefront($storefront)
    {
        $this->builder->whereHas(
            'store',
            function ($query) use ($storefront) {
                $query->where('public_id', $storefront);
            }
        );
    }

    public function serviceArea(string $serviceAreaId)
    {
        $matchingServiceAreaIds = ServiceArea::on(config('transitops.connection.db'))
            ->where(function ($query) use ($serviceAreaId) {
                $query->where('public_id', $serviceAreaId)
                    ->orWhere('uuid', $serviceAreaId);
            })
            ->pluck('uuid')
            ->toArray();

        $this->builder->whereIn('service_area_uuid', $matchingServiceAreaIds);
    }

    public function withDeleted()
    {
        $this->builder->withTrashed();
    }
}
