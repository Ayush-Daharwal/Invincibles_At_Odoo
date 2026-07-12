<?php

namespace Transitops\Storefront\Http\Filter;

use Transitops\Http\Filter\Filter;

class AddonCategoryFilter extends Filter
{
    public function queryForInternal()
    {
        // Query only this company sessions resources
        $this->builder->where(
            [
                'company_uuid' => $this->session->get('company'),
                'for'          => 'storefront_product_addon',
            ]
        );
    }
}
