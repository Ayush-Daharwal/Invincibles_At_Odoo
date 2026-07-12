<?php

namespace Transitops\FleetOps\Http\Controllers\Api\v1;

use Transitops\FleetOps\Http\Requests\CreateEntityRequest;
use Transitops\FleetOps\Http\Requests\UpdateEntityRequest;
use Transitops\FleetOps\Http\Resources\v1\DeletedResource;
use Transitops\FleetOps\Http\Resources\v1\Entity as EntityResource;
use Transitops\FleetOps\Models\Entity;
use Transitops\FleetOps\Models\Payload;
use Transitops\FleetOps\Models\Place;
use Transitops\FleetOps\Support\Utils;
use Transitops\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Creates a new Transitops Entity resource.
     *
     * @param \Transitops\Http\Requests\CreateEntityRequest $request
     *
     * @return \Transitops\Http\Resources\Entity
     */
    public function create(CreateEntityRequest $request)
    {
        // get request input
        $input = $request->only([
            'name',
            'type',
            'internal_id',
            'description',
            'meta',
            'length',
            'width',
            'height',
            'weight',
            'weight_unit',
            'dimensions_unit',
            'declared_value',
            'price',
            'sales_price',
            'sku',
            'currency',
            'meta',
            'supplier_uuid',
        ]);

        // payload assignment
        if ($request->has('payload')) {
            $input['payload_uuid'] = Utils::getUuid('payloads', [
                'public_id'    => $request->input('payload'),
                'company_uuid' => session('company'),
            ]);
        }

        // customer assignment
        if ($request->has('customer')) {
            $customer = Utils::getUuid(
                ['contacts', 'vendors'],
                [
                    'public_id'    => $request->input('customer'),
                    'company_uuid' => session('company'),
                ]
            );

            if (is_array($customer)) {
                $input['customer_uuid'] = Utils::get($customer, 'uuid');
                $input['customer_type'] = Utils::getModelClassName(Utils::get($customer, 'table'));
            }
        }

        // driver assignment
        if ($request->has('driver')) {
            $input['driver_uuid'] = Utils::getUuid('drivers', [
                'public_id'    => $request->input('driver'),
                'company_uuid' => session('company'),
            ]);
        }

        // if destination is set
        if ($request->has('destination') || $request->has('waypoint')) {
            $destinationKey = $request->or(['destination', 'waypoint']);

            if ($request->has('payload')) {
                $payload = Payload::where('public_id', $request->input('payload'))->first();

                if ($payload) {
                    // if a destination or waypoint is explicitly set
                    $destination = $payload->findDestinationFromKey($destinationKey);
                    if ($destination instanceof Place) {
                        $input['destination_uuid'] = $destination->uuid;
                    }
                }
            }
        }

        // make sure company is set
        $input['company_uuid'] = session('company');

        // create the entity
        $entity = Entity::create($input);

        // response the driver resource
        return new EntityResource($entity);
    }

    /**
     * Updates a Transitops Entity resource.
     *
     * @param string                                       $id
     * @param \Transitops\Http\Requests\UpdateEntityRequest $request
     *
     * @return \Transitops\Http\Resources\Entity
     */
    public function update($id, UpdateEntityRequest $request)
    {
        // find for the entity
        try {
            $entity = Entity::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Entity resource not found.',
                ],
                404
            );
        }

        // get request input
        $input = $request->only([
            'name',
            'type',
            'internal_id',
            'description',
            'meta',
            'length',
            'width',
            'height',
            'weight',
            'weight_unit',
            'dimensions_unit',
            'declared_value',
            'price',
            'sales_price',
            'sku',
            'currency',
            'meta',
            'supplier_uuid',
        ]);

        // payload assignment
        if ($request->has('payload')) {
            $input['payload_uuid'] = Utils::getUuid('payloads', [
                'public_id'    => $request->input('payload'),
                'company_uuid' => session('company'),
            ]);
        }

        // customer assignment
        if ($request->has('customer')) {
            $customer = Utils::getUuid(
                ['contacts', 'vendors'],
                [
                    'public_id'    => $request->input('payload'),
                    'company_uuid' => session('company'),
                ]
            );
            if (is_array($customer)) {
                $input['customer_uuid']   = Utils::get($customer, 'uuid');
                $input['customer_object'] = Utils::singularize(Utils::get($customer, 'table'));
            }
        }

        // driver assignment
        if ($request->has('driver')) {
            $input['driver_uuid'] = Utils::getUuid('drivers', [
                'public_id'    => $request->input('driver'),
                'company_uuid' => session('company'),
            ]);
        }

        // if destination is set
        if ($request->has('destination') || $request->has('waypoint')) {
            $destinationKey = $request->or(['destination', 'waypoint']);

            if ($request->has('payload')) {
                $payload = Payload::where('public_id', $request->input('payload'))->first();

                if ($payload) {
                    // if a destination or waypoint is explicitly set
                    $destination = $payload->findDestinationFromKey($destinationKey);
                    if ($destination instanceof Place) {
                        $attributes['destination_uuid'] = $destination->uuid;
                    }
                }
            }
        }

        // update the entity
        $entity->update($input);

        // response the entity resource
        return new EntityResource($entity);
    }

    /**
     * Query for Transitops Entity resources.
     *
     * @return \Transitops\Http\Resources\EntityCollection
     */
    public function query(Request $request)
    {
        $results = Entity::queryWithRequest($request);

        return EntityResource::collection($results);
    }

    /**
     * Finds a single Transitops Entity resources.
     *
     * @return \Transitops\Http\Resources\EntityCollection
     */
    public function find($id, Request $request)
    {
        // find for the entity
        try {
            $entity = Entity::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Entity resource not found.',
                ],
                404
            );
        }

        // response the entity resource
        return new EntityResource($entity);
    }

    /**
     * Deletes a Transitops Entity resources.
     *
     * @return \Transitops\Http\Resources\EntityCollection
     */
    public function delete($id, Request $request)
    {
        // find for the driver
        try {
            $entity = Entity::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Entity resource not found.',
                ],
                404
            );
        }

        // delete the entity
        $entity->delete();

        // response the entity resource
        return new DeletedResource($entity);
    }
}
