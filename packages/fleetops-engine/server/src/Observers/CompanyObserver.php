<?php

namespace Transitops\FleetOps\Observers;

use Transitops\FleetOps\Support\FleetOps;
use Transitops\Models\Company;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     *
     * @return void
     */
    public function created(Company $company)
    {
        // Add the default transport order config
        FleetOps::createTransportConfig($company);
    }
}
