<?php

namespace Transitops\FleetOps\Http\Requests;

use Transitops\Http\Requests\TransitopsRequest;

class CreateServiceQuoteRequest extends TransitopsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }
}
