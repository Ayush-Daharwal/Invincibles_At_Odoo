<?php

namespace Transitops\Storefront\Http\Filter;

use Transitops\Http\Filter\Filter;

class GatewayFilter extends Filter
{
    public function queryForInternal()
    {
        $this->builder->where('company_uuid', $this->session->get('company'));
    }
}
