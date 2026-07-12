<?php

namespace Transitops\Storefront\Expansions;

use Transitops\Build\Expansion;

class OrderFilterExpansion implements Expansion
{
    /**
     * Get the target class to expand.
     *
     * @return string|Class
     */
    public static function target()
    {
        return \Transitops\FleetOps\Http\Filter\OrderFilter::class;
    }

    /**
     * Filter orders by the storefront id.
     *
     * @return \Closure
     */
    public static function storefront()
    {
        return function (?string $storefront) {
            /* @var \Transitops\FleetOps\Http\Filter\OrderFilter $this */
            $this->builder->where('meta->storefront_id', $storefront);
        };
    }
}
