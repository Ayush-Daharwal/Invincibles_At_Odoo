<?php

namespace Transitops\FleetOps\Expansions;

use Transitops\Build\Expansion;
use Transitops\FleetOps\Models\Driver;

class CompanyExpansion implements Expansion
{
    /**
     * Get the target class to expand.
     *
     * @return string|Class
     */
    public static function target()
    {
        return \Transitops\Models\Company::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public static function drivers()
    {
        return function () {
            /** @var \Illuminate\Database\Eloquent\Model $this */
            return $this->hasMany(Driver::class);
        };
    }
}
