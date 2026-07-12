<?php

namespace Transitops\FleetOps\Http\Controllers\Api\v1;

use Transitops\FleetOps\Http\Requests\CreateVendorRequest;
use Transitops\FleetOps\Http\Requests\UpdateVendorRequest;
use Transitops\FleetOps\Http\Resources\v1\DeletedResource;
use Transitops\FleetOps\Http\Resources\v1\Vendor as VendorResource;
use Transitops\FleetOps\Models\Vendor;
use Transitops\FleetOps\Support\Utils;
use Transitops\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Creates a new Transitops Vendor resource.
     *
     * @param \Transitops\Http\Requests\CreateVendorRequest $request
     *
     * @return \Transitops\Http\Resources\Vendor
     */
    public function create(CreateVendorRequest $request)
    {
        // get request input
        $input = $request->only(['name', 'type', 'email', 'phone', 'meta']);

        // make sure company is set
        $input['company_uuid'] = session('company');

        // address assignment
        if ($request->has('address')) {
            $input['place_uuid'] = Utils::getUuid(
                'places',
                [
                    'public_id'    => $request->input('address'),
                    'company_uuid' => session('company'),
                ]
            );
        }

        // create the vendor
        $vendor = Vendor::updateOrCreate(
            [
                'company_uuid' => session('company'),
                'name'         => strtoupper($input['name']),
            ],
            $input
        );

        // response the driver resource
        return new VendorResource($vendor);
    }

    /**
     * Updates a Transitops Vendor resource.
     *
     * @param string                                       $id
     * @param \Transitops\Http\Requests\UpdateVendorRequest $request
     *
     * @return \Transitops\Http\Resources\Vendor
     */
    public function update($id, UpdateVendorRequest $request)
    {
        // find for the vendor
        try {
            $vendor = Vendor::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Vendor resource not found.',
                ],
                404
            );
        }

        // get request input
        $input = $request->only(['name', 'type', 'email', 'phone', 'meta']);

        // address assignment
        if ($request->has('address')) {
            $input['place_uuid'] = Utils::getUuid(
                'places',
                [
                    'public_id'    => $request->input('address'),
                    'company_uuid' => session('company'),
                ]
            );
        }

        // update the vendor
        $vendor->update($input);
        $vendor->flushAttributesCache();

        // response the vendor resource
        return new VendorResource($vendor);
    }

    /**
     * Query for Transitops Vendor resources.
     *
     * @return \Transitops\Http\Resources\VendorCollection
     */
    public function query(Request $request)
    {
        $results = Vendor::queryWithRequest($request);

        return VendorResource::collection($results);
    }

    /**
     * Finds a single Transitops Vendor resources.
     *
     * @return \Transitops\Http\Resources\VendorCollection
     */
    public function find($id, Request $request)
    {
        // find for the vendor
        try {
            $vendor = Vendor::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Vendor resource not found.',
                ],
                404
            );
        }

        // response the vendor resource
        return new VendorResource($vendor);
    }

    /**
     * Deletes a Transitops Vendor resources.
     *
     * @return \Transitops\Http\Resources\VendorCollection
     */
    public function delete($id, Request $request)
    {
        // find for the driver
        try {
            $vendor = Vendor::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Vendor resource not found.',
                ],
                404
            );
        }

        // delete the vendor
        $vendor->delete();

        // response the vendor resource
        return new DeletedResource($vendor);
    }
}
