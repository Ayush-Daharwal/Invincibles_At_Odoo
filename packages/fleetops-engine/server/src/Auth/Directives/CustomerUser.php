<?php

namespace Transitops\FleetOps\Auth\Directives;

use Transitops\Contracts\Directive;
use Illuminate\Database\Eloquent\Builder;

class CustomerUser implements Directive
{
    public function apply(Builder $builder): Builder
    {
        $id = session('user', request()->input('customer'));

        return $builder->where(['uuid' => $id]);
    }
}
