<?php

namespace Transitops\FleetOps\Http\Controllers\Internal\v1;

use Transitops\FleetOps\Exports\FleetExport;
use Transitops\FleetOps\Http\Controllers\FleetOpsController;
use Transitops\FleetOps\Http\Requests\Internal\FleetActionRequest;
use Transitops\FleetOps\Imports\FleetImport;
use Transitops\FleetOps\Models\Driver;
use Transitops\FleetOps\Models\Fleet;
use Transitops\FleetOps\Models\FleetDriver;
use Transitops\FleetOps\Models\FleetVehicle;
use Transitops\FleetOps\Models\Vehicle;
use Transitops\FleetOps\Support\LiveCacheService;
use Transitops\Http\Requests\ExportRequest;
use Transitops\Http\Requests\ImportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class FleetController extends FleetOpsController
{
    /**
     * The resource to query.
     *
     * @var string
     */
    public $resource = 'fleet';

    /**
     * Handle post save transactions.
     */
    public function afterSave(Request $request, Fleet $fleet)
    {
        $customFieldValues = $request->array('fleet.custom_field_values');
        if ($customFieldValues) {
            $fleet->syncCustomFieldValues($customFieldValues);
        }
    }

    /**
     * Query callback when querying record.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param Request                            $request
     */
    public static function onQueryRecord($query, $request): void
    {
        if ($request->has('excludeDriverJobs')) {
            $excludeJobs = $request->array('excludeDriverJobs');
            $query->with('drivers', function ($query) use ($excludeJobs) {
                $query->with('jobs', function ($query) use ($excludeJobs) {
                    if (is_array($excludeJobs)) {
                        $isUuids = Arr::every($excludeJobs, function ($id) {
                            return Str::isUuid($id);
                        });

                        if ($isUuids) {
                            $query->whereNotIn('uuid', $excludeJobs);
                        } else {
                            $query->whereNotIn('public_id', $excludeJobs);
                        }
                    }

                    $query->whereHas(
                        'payload',
                        function ($q) {
                            $q->where(
                                function ($q) {
                                    $q->whereHas('waypoints');
                                    $q->orWhereHas('pickup');
                                    $q->orWhereHas('dropoff');
                                }
                            );
                            $q->with(['entities', 'waypoints', 'dropoff', 'pickup', 'return']);
                        }
                    );
                    $query->whereHas('trackingNumber');
                    $query->whereHas('trackingStatuses');
                    $query->with(
                        [
                            'payload',
                            'trackingNumber',
                            'trackingStatuses',
                        ]
                    );
                });
            });
        }
    }

    /**
     * Export the fleets to excel or csv.
     *
     * @return \Illuminate\Http\Response
     */
    public static function export(ExportRequest $request)
    {
        $format       = $request->input('format', 'xlsx');
        $selections   = $request->array('selections');
        $fileName     = trim(Str::slug('fleets-' . date('Y-m-d-H:i')) . '.' . $format);

        return Excel::download(new FleetExport($selections), $fileName);
    }

    /**
     * Removes a driver from a fleet.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function removeDriver(FleetActionRequest $request)
    {
        $fleet  = Fleet::where('uuid', $request->input('fleet'))->first();
        $driver = Driver::where('uuid', $request->input('driver'))->first();

        // check if driver is already in this fleet
        $deleted = FleetDriver::where([
            'fleet_uuid'  => $fleet->uuid,
            'driver_uuid' => $driver->uuid,
        ])->delete();

        LiveCacheService::invalidate('operations-monitor');

        return response()->json([
            'status'  => 'ok',
            'deleted' => $deleted,
        ]);
    }

    /**
     * Adds a driver to a fleet.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function assignDriver(FleetActionRequest $request)
    {
        $fleet  = Fleet::where('uuid', $request->input('fleet'))->first();
        $driver = Driver::where('uuid', $request->input('driver'))->first();
        $added  = false;

        // check if driver is already in this fleet
        $exists = FleetDriver::where([
            'fleet_uuid'  => $fleet->uuid,
            'driver_uuid' => $driver->uuid,
        ])->exists();

        if (!$exists) {
            $added = FleetDriver::create([
                'fleet_uuid'  => $fleet->uuid,
                'driver_uuid' => $driver->uuid,
            ]);
        }

        LiveCacheService::invalidate('operations-monitor');

        return response()->json([
            'status' => 'ok',
            'exists' => $exists,
            'added'  => (bool) $added,
        ]);
    }

    /**
     * Removes a vehicle from a fleet.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function removeVehicle(FleetActionRequest $request)
    {
        $fleet   = Fleet::where('uuid', $request->input('fleet'))->first();
        $vehicle = Vehicle::where('uuid', $request->input('vehicle'))->first();

        // check if vehicle is already in this fleet
        $deleted = FleetVehicle::where([
            'fleet_uuid'   => $fleet->uuid,
            'vehicle_uuid' => $vehicle->uuid,
        ])->delete();

        LiveCacheService::invalidate('operations-monitor');

        return response()->json([
            'status'  => 'ok',
            'deleted' => $deleted,
        ]);
    }

    /**
     * Adds a vehicle to a fleet.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function assignVehicle(FleetActionRequest $request)
    {
        $fleet   = Fleet::where('uuid', $request->input('fleet'))->first();
        $vehicle = Vehicle::where('uuid', $request->input('vehicle'))->first();
        $added   = false;

        // check if vehicle is already in this fleet
        $exists = FleetVehicle::where([
            'fleet_uuid'   => $fleet->uuid,
            'vehicle_uuid' => $vehicle->uuid,
        ])->exists();

        if (!$exists) {
            $added = FleetVehicle::create([
                'fleet_uuid'   => $fleet->uuid,
                'vehicle_uuid' => $vehicle->uuid,
            ]);
        }

        LiveCacheService::invalidate('operations-monitor');

        return response()->json([
            'status' => 'ok',
            'exists' => $exists,
            'added'  => (bool) $added,
        ]);
    }

    public function import(ImportRequest $request)
    {
        $disk           = $request->input('disk', config('filesystems.default'));
        $files          = $request->resolveFilesFromIds();
        $importedCount  = 0;

        foreach ($files as $file) {
            try {
                $import = new FleetImport();
                Excel::import($import, $file->path, $disk);
                $importedCount += $import->imported;
            } catch (\Throwable $e) {
                return response()->error('Invalid file, unable to proccess.');
            }
        }

        return response()->json(['status' => 'ok', 'message' => 'Import completed', 'imported' => $importedCount]);
    }
}
