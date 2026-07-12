<?php

namespace Transitops\Valhalla\Http\Controllers;

use Transitops\Http\Controllers\TransitopsController;

class ValhallaResourceController extends TransitopsController
{
    /**
     * The package namespace used to resolve from.
     */
    public string $namespace = '\Transitops\Valhalla';
}
