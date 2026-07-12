<?php

namespace Transitops\Ledger\Http\Controllers;

use Transitops\Http\Controllers\TransitopsController;

class LedgerResourceController extends TransitopsController
{
    /**
     * The package namespace used to resolve models, resources, filters, and requests.
     */
    public string $namespace = '\\Transitops\\Ledger';
}
