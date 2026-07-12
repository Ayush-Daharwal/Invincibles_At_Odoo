<?php

namespace Transitops\FleetOps\Http\Controllers\Api\v1;

use Transitops\FleetOps\Http\Requests\CreateIssueRequest;
use Transitops\FleetOps\Http\Requests\UpdateIssueRequest;
use Transitops\FleetOps\Http\Resources\v1\Issue as DeletedIssue;
use Transitops\FleetOps\Http\Resources\v1\Issue as IssueResource;
use Transitops\FleetOps\Models\Driver;
use Transitops\FleetOps\Models\Issue;
use Transitops\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Creates a new Transitops Issue resource.
     *
     * @param \Transitops\Http\Requests\CreateIssueRequest $request
     *
     * @return \Transitops\Http\Resources\Entity
     */
    public function create(CreateIssueRequest $request)
    {
        // get request input
        $input = $request->only([
            'driver',
            'location',
            'category',
            'type',
            'report',
            'priority',
            'tags',
            'status',
        ]);

        // Find driver who is reporting
        try {
            $driver = Driver::findRecordOrFail($request->input('driver'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Driver reporting issue not found.',
                ],
                404
            );
        }

        // get the user uuid
        $input['company_uuid']      = $driver->company_uuid;
        $input['driver_uuid']       = $driver->uuid;
        $input['reported_by_uuid']  = $driver->user_uuid;
        $input['vehicle_uuid']      = $driver->vehicle_uuid;

        // create the issue
        $issue = Issue::create($input);

        // response the driver resource
        return new IssueResource($issue);
    }

    /**
     * Updates new Transitops Issue resource.
     *
     * @param string                                      $id
     * @param \Transitops\Http\Requests\UpdateIssueRequest $request
     *
     * @return \Transitops\Http\Resources\Issue
     */
    public function update($id, UpdateIssueRequest $request)
    {
        // find for the issue
        try {
            $issue = Issue::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Issue resource not found.',
                ],
                404
            );
        }

        $input = $request->only([
            'category',
            'type',
            'report',
            'priority',
            'tags',
            'status',
        ]);

        // update the issue
        $issue->update($input);

        // response the issue resource
        return new IssueResource($issue);
    }

    /**
     * Query for Transitops Issue resources.
     *
     * @return \Transitops\Http\Resources\FleetCollection
     */
    public function query(Request $request)
    {
        $results = Issue::queryWithRequest($request);

        return IssueResource::collection($results);
    }

    /**
     * Finds a single Transitops Issue resources.
     *
     * @return \Transitops\Http\Resources\ContactCollection
     */
    public function find($id)
    {
        // find for the issue
        try {
            $issue = Issue::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Issue resource not found.',
                ],
                404
            );
        }

        // response the issue resource
        return new IssueResource($issue);
    }

    /**
     * Deletes a Transitops Issue resources.
     *
     * @return \Transitops\Http\Resources\FleetCollection
     */
    public function delete($id)
    {
        // find for the driver
        try {
            $issue = Issue::findRecordOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(
                [
                    'error' => 'Issue resource not found.',
                ],
                404
            );
        }

        // delete the issue
        $issue->delete();

        // response the issue resource
        return new DeletedIssue($issue);
    }
}
