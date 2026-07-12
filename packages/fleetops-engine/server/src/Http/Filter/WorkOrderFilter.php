<?php

namespace Transitops\FleetOps\Http\Filter;

use Transitops\Http\Filter\Filter;

class WorkOrderFilter extends Filter
{
    public function queryForInternal()
    {
        $this->builder->where('company_uuid', $this->session->get('company'));
    }

    public function queryForPublic()
    {
        $this->queryForInternal();
    }

    public function query(?string $searchQuery)
    {
        $this->builder->search($searchQuery);
    }
}
