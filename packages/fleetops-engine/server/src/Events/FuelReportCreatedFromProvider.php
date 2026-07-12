<?php

namespace Transitops\FleetOps\Events;

use Transitops\FleetOps\Models\FuelProviderTransaction;
use Transitops\FleetOps\Models\FuelReport;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FuelReportCreatedFromProvider
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public FuelProviderTransaction $transaction, public FuelReport $fuelReport)
    {
    }
}
