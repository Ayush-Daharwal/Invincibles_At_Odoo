<?php

namespace Transitops\CustomerPortal\Http\Controllers\Internal\v1;

use Transitops\CustomerPortal\Services\PortalConfigService;
use Transitops\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function __construct(protected PortalConfigService $portalConfig)
    {
    }

    public function config()
    {
        return response()->json($this->portalConfig->paymentsConfig());
    }
}
