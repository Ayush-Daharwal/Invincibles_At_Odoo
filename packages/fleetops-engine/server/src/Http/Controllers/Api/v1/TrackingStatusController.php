<?php

namespace Transitops\FleetOps\Http\Controllers\Api\v1;

use Transitops\FleetOps\Http\Requests\CreateTrackingStatusRequest;
use Transitops\FleetOps\Http\Requests\UpdateTrackingStatusRequest;
use Transitops\FleetOps\Http\Resources\v1\DeletedResource;
use Transitops\FleetOps\Http\Resources\v1\TrackingStatus as TrackingStatusResource;
use Transitops\FleetOps\Models\Order;
use Transitops\FleetOps\Models\TrackingStatus;
use Transitops\FleetOps\Support\Utils;
use Transitops\Http\Controllers\Controller;
use Transitops\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;

class TrackingStatusController extends Controller
{
    /**
     * Creates a new Transitops TrackingStatus resource.
     *
     * @param \Transitops\Http\Requests\CreateTrackingStatusRequest $request
     *
     * @return \Transitops\Http\Resources\TrackingStatus
     */
    public function create(CreateTrackingStatusRequest $request)
    {
        // get request input
        $input = $request->only(['status', 'details', 'code', 'city', 'province', 'postal_code', 'country', 'location', 'latitude', 'longitude']);

        // if no location provided but latitude/longitude
        if (empty($input['location']) && isset($input['latitude']) && isset($input['longitude'])) {
            $latitude  = data_get($input, 'latitude');
            $longitude = data_get($input, 'longitude');

            // unset latitude and longitude
            unset($input['latitude'], $input['longitude']);

            // create location
            $input['location'] = new Point($latitude, $longitude);
        }

        // if no code set create a code from the status
        if (empty($input['code'])) {
            $input['code'] = TrackingStatus::prepareCode($input['status']);
        }

        // make sure company is set
        $input['company_uuid'] = session('company');

        // tracking number assignment
        if ($request->has('tracking_number')) {
            $input['tracking_number_uuid'] = Utils::getUuid('tracking_numbers', [
                'public_id'    => $request->input('tracking_number'),
                'company_uuid' => session('company'),
            ]);
        }

        // tracking number assignment
        if ($request->has('order')) {
            $input['tracking_number_uuid'] = Order::where('public_id', $request->input('order'))->value('tracking_number_uuid');
        }

        // create the trackingStatus
        $trackingStatus = TrackingStatus::create($input);

        // response the driver resource
        return new TrackingStatusResource($trackingStatus);
    }

    /**
     * Updates a Transitops TrackingStatus resource.
     *
     * @param string                                               $id
     * @param \Transitops\Http\Requests\UpdateTrackingStatusRequest $request
     *
     * @return \Transitops\Http\Resources\TrackingStatus
     */
    public function update($id, UpdateTrackingStatusRequest $request)
    {
        // find for the trackingStatus
        try {
            $trackingStatus = TrackingStatus::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'TrackingStatus resource not found.',
                ],
                404
            );
        }

        // get request input
        $input = $request->only(['status', 'details', 'code', 'city', 'province', 'postal_code', 'country', 'location', 'latitude', 'longitude']);

        // if no location provided but latitude/longitude
        if (empty($input['location']) && isset($input['latitude']) && isset($input['longitude'])) {
            $latitude  = data_get($input, 'latitude');
            $longitude = data_get($input, 'longitude');

            // unset latitude and longitude
            unset($input['latitude'], $input['longitude']);

            // create location
            $input['location'] = new Point($latitude, $longitude);
        }

        // if no code set create a code from the status
        if (empty($trackingStatus->code)) {
            $input['code'] = TrackingStatus::prepareCode(data_get($input, 'status', $trackingStatus->status));
        }

        // update the trackingStatus
        $trackingStatus->update($input);

        // response the trackingStatus resource
        return new TrackingStatusResource($trackingStatus);
    }

    /**
     * Query for Transitops TrackingStatus resources.
     *
     * @return \Transitops\Http\Resources\TrackingStatusCollection
     */
    public function query(Request $request)
    {
        $results = TrackingStatus::queryWithRequest($request);

        return TrackingStatusResource::collection($results);
    }

    /**
     * Finds a single Transitops TrackingStatus resources.
     *
     * @return \Transitops\Http\Resources\TrackingStatusCollection
     */
    public function find($id)
    {
        // find for the trackingStatus
        try {
            $trackingStatus = TrackingStatus::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'TrackingStatus resource not found.',
                ],
                404
            );
        }

        // response the trackingStatus resource
        return new TrackingStatusResource($trackingStatus);
    }

    /**
     * Deletes a Transitops TrackingStatus resources.
     *
     * @return \Transitops\Http\Resources\TrackingStatusCollection
     */
    public function delete($id)
    {
        // find for the driver
        try {
            $trackingStatus = TrackingStatus::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'TrackingStatus resource not found.',
                ],
                404
            );
        }

        // delete the trackingStatus
        $trackingStatus->delete();

        // response the trackingStatus resource
        return new DeletedResource($trackingStatus);
    }
}
