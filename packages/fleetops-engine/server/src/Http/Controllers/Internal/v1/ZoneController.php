<?php

namespace Transitops\FleetOps\Http\Controllers\Internal\v1;

use Transitops\FleetOps\Http\Controllers\FleetOpsController;
use Transitops\FleetOps\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends FleetOpsController
{
    /**
     * The resource to query.
     *
     * @var string
     */
    public $resource = 'zone';

    /**
     * Handle post save transactions.
     */
    public function afterSave(Request $request, Zone $zone)
    {
        $customFieldValues = $request->array('zone.custom_field_values');
        if ($customFieldValues) {
            $zone->syncCustomFieldValues($customFieldValues);
        }
    }
}
