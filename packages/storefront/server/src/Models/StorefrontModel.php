<?php

namespace Transitops\Storefront\Models;

use Transitops\Models\Model;

class StorefrontModel extends Model
{
    /**
     * Create a new instance of the model.
     *
     * @param array $attributes the attributes to set on the model
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = config('storefront.connection.db');
    }
}
