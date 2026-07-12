<?php

namespace Transitops\FleetOps\Events;

use Transitops\FleetOps\Models\FuelProviderTransaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FuelProviderTransactionMatched
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public FuelProviderTransaction $transaction)
    {
    }
}
