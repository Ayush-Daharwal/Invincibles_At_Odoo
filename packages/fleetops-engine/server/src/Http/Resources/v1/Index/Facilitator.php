<?php

namespace Transitops\FleetOps\Http\Resources\v1\Index;

use Transitops\Http\Resources\TransitopsResource;
use Transitops\Support\Http;

/**
 * Lightweight Facilitator resource for index views.
 * Handles polymorphic facilitator types (Contact, Vendor, IntegratedVendor) with minimal data.
 */
class Facilitator extends TransitopsResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function toArray($request): array
    {
        $isInternal = Http::isInternalRequest();

        return [
            'id'           => $this->when($isInternal, $this->id, $this->public_id),
            'uuid'         => $this->when($isInternal, $this->uuid),
            'public_id'    => $this->when($isInternal, $this->public_id),
            'company_uuid' => $this->when($isInternal, $this->company_uuid),
            'name'         => $this->name,
            'phone'        => $this->phone ?? null,
            'email'        => $this->email ?? null,
        ];
    }
}
