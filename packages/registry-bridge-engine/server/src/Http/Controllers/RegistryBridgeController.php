<?php

namespace Transitops\RegistryBridge\Http\Controllers;

use Transitops\Http\Controllers\TransitopsController;

class RegistryBridgeController extends TransitopsController
{
    /**
     * The package namespace used to resolve from.
     */
    public string $namespace = '\\Transitops\\RegistryBridge';
}
