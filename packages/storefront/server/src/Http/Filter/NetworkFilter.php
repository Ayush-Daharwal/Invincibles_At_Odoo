<?php

namespace Transitops\Storefront\Http\Filter;

use Transitops\Http\Filter\Filter;

class NetworkFilter extends Filter
{
    public function queryForInternal()
    {
        $this->builder->where('company_uuid', $this->session->get('company'));
    }

    public function query(?string $searchQuery)
    {
        $this->builder->search($searchQuery);
    }
}
