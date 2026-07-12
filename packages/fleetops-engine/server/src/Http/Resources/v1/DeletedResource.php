<?php

namespace Transitops\FleetOps\Http\Resources\v1;

use Transitops\FleetOps\Support\Utils;
use Transitops\Http\Resources\TransitopsResource;
use Transitops\Support\Http;

class DeletedResource extends TransitopsResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->when(Http::isInternalRequest(), $this->id, $this->public_id),
            'uuid'      => $this->when(Http::isInternalRequest(), $this->uuid),
            'public_id' => $this->when(Http::isInternalRequest(), $this->public_id),
            'object'    => $this->getObjectType(),
            'time'      => $this->deleted_at,
            'deleted'   => true,
        ];
    }

    /**
     * Transform the resource into an webhook payload.
     *
     * @return array
     */
    public function toWebhookPayload()
    {
        return [
            'id'      => $this->public_id,
            'object'  => $this->getObjectType(),
            'time'    => $this->deleted_at,
            'deleted' => true,
        ];
    }

    /**
     * Get the object type for this resource.
     *
     * @return string
     */
    public function getObjectType()
    {
        return Utils::getTypeFromClassName($this->resource);
    }
}
