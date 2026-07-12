<?php

namespace Transitops\FleetOps\Http\Controllers\Internal\v1;

use Transitops\FleetOps\Support\GettingStarted;
use Transitops\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GettingStartedController extends Controller
{
    public function status(Request $request)
    {
        return response()->json(
            GettingStarted::forCompany($request->user()->company)->get()
        );
    }
}
