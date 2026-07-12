<?php

namespace Transitops\FleetOps\Http\Filter;

use Transitops\Http\Filter\Filter;

class ServiceQuoteFilter extends Filter
{
    public function queryForInternal()
    {
        $this->builder->where('company_uuid', $this->session->get('company'));
    }

    public function queryForPublic()
    {
        $this->builder->where('company_uuid', $this->session->get('company'));
    }
}
