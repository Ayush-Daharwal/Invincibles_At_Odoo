<?php

namespace Transitops\FleetOps\Http\Controllers\Api\v1;

use Transitops\FleetOps\Http\Requests\CreateServiceAreaRequest;
use Transitops\FleetOps\Http\Requests\UpdateServiceAreaRequest;
use Transitops\FleetOps\Http\Resources\v1\DeletedResource;
use Transitops\FleetOps\Http\Resources\v1\ServiceArea as ServiceAreaResource;
use Transitops\FleetOps\Models\ServiceArea;
use Transitops\FleetOps\Support\Utils;
use Transitops\Http\Controllers\Controller;
use Transitops\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;

class ServiceAreaController extends Controller
{
    /**
     * Creates a new Transitops ServiceArea resource.
     *
     * @param \Transitops\Http\Requests\CreateServiceAreaRequest $request
     *
     * @return \Transitops\Http\Resources\ServiceArea
     */
    public function create(CreateServiceAreaRequest $request)
    {
        // get request input
        $input = $request->only(['name', 'type', 'status', 'country', 'border', 'color', 'stroke_color', 'trigger_on_entry', 'trigger_on_exit', 'dwell_threshold_minutes', 'speed_limit_kmh']);

        // get radius for creating service area border - default to 500 meters
        $radius = (int) $request->input('radius', 500);

        // make sure company is set
        $input['company_uuid'] = session('company');

        // if parent service area set
        if ($request->filled('parent')) {
            $input['parent_uuid'] = Utils::getUuid('service_areas', [
                'public_id'    => $request->input('parent'),
                'company_uuid' => session('company'),
            ]);
        }

        // if latitude and longitude is provided
        if ($request->has(['latitude', 'longitude'])) {
            // create a polygon given the radius
            $latitude  = $request->input('latitude');
            $longitude = $request->input('longitude');
            $point     = new Point($latitude, $longitude);

            if ($point instanceof Point) {
                $input['border'] = ServiceArea::createMultiPolygonFromPoint($point, $radius);
            }
        }

        // if a location is provided
        if ($request->has('location')) {
            $location = $request->input('location');
            $point    = Utils::getPointFromMixed($location);

            if ($point instanceof Point) {
                $input['border'] = ServiceArea::createMultiPolygonFromPoint($point, $radius);
            }
        }

        // create the serviceArea
        try {
            $serviceArea = ServiceArea::create($input);
            $serviceArea->refresh();
        } catch (\Throwable $e) {
            logger()->error('Unable to create service area.', ['error' => $e->getMessage()]);

            return response()->apiError('Failed to create service area.');
        }

        // response the driver resource
        return new ServiceAreaResource($serviceArea);
    }

    /**
     * Updates a Transitops ServiceArea resource.
     *
     * @param string                                            $id
     * @param \Transitops\Http\Requests\UpdateServiceAreaRequest $request
     *
     * @return \Transitops\Http\Resources\ServiceArea
     */
    public function update($id, UpdateServiceAreaRequest $request)
    {
        // find for the serviceArea
        try {
            $serviceArea = ServiceArea::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'ServiceArea resource not found.',
                ],
                404
            );
        }

        // get request input
        $input = $request->only(['name', 'type', 'status', 'country', 'border', 'color', 'stroke_color', 'trigger_on_entry', 'trigger_on_exit', 'dwell_threshold_minutes', 'speed_limit_kmh']);

        // get radius for creating service area border - default to 500 meters
        $radius = $request->input('radius', 500);

        // if parent service area set
        if ($request->filled('parent')) {
            $input['parent_uuid'] = Utils::getUuid('service_areas', [
                'public_id'    => $request->input('parent'),
                'company_uuid' => session('company'),
            ]);
        }

        // if latitude and longitude is provided
        if ($request->has(['latitude', 'longitude'])) {
            // create a polygon given the radius
            $latitude  = $request->input('latitude');
            $longitude = $request->input('longitude');
            $point     = new Point($latitude, $longitude);

            if ($point instanceof Point) {
                $input['border'] = ServiceArea::createMultiPolygonFromPoint($point, $radius);
            }
        }

        // if a location is provided
        if ($request->has('location')) {
            $location = $request->input('location');
            $point    = Utils::getPointFromMixed($location);

            if ($point instanceof Point) {
                $input['border'] = ServiceArea::createMultiPolygonFromPoint($point, $radius);
            }
        }

        // update the serviceArea
        $serviceArea->update($input);
        $serviceArea->refresh();

        // response the serviceArea resource
        return new ServiceAreaResource($serviceArea);
    }

    /**
     * Query for Transitops ServiceArea resources.
     *
     * @return \Transitops\Http\Resources\ServiceAreaCollection
     */
    public function query(Request $request)
    {
        $results = ServiceArea::queryWithRequest($request);

        return ServiceAreaResource::collection($results);
    }

    /**
     * Finds a single Transitops ServiceArea resources.
     *
     * @return \Transitops\Http\Resources\ServiceAreaCollection
     */
    public function find($id, Request $request)
    {
        // find for the serviceArea
        try {
            $serviceArea = ServiceArea::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'ServiceArea resource not found.',
                ],
                404
            );
        }

        // response the serviceArea resource
        return new ServiceAreaResource($serviceArea);
    }

    /**
     * Deletes a Transitops ServiceArea resources.
     *
     * @return \Transitops\Http\Resources\ServiceAreaCollection
     */
    public function delete($id, Request $request)
    {
        // find for the driver
        try {
            $serviceArea = ServiceArea::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'ServiceArea resource not found.',
                ],
                404
            );
        }

        // delete the serviceArea
        $serviceArea->delete();

        // response the serviceArea resource
        return new DeletedResource($serviceArea);
    }
}
