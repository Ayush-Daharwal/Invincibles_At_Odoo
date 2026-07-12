<?php

namespace Transitops\Storefront\Observers;

use Transitops\Models\Company;
use Transitops\Storefront\Support\Storefront;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     *
     * @return void
     */
    public function created(Company $company)
    {
        // Add the default storefront order config
        Storefront::createStorefrontConfig($company);
    }
}
