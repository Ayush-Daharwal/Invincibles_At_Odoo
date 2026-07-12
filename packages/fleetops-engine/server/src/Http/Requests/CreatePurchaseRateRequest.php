<?php

namespace Transitops\FleetOps\Http\Requests;

use Transitops\Http\Requests\TransitopsRequest;
use Transitops\Rules\ExistsInAny;
use Illuminate\Validation\Rule;

class CreatePurchaseRateRequest extends TransitopsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->session()->has('api_credential');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_quote' => ['required', Rule::exists('service_quotes', 'public_id')->whereNull('deleted_at')],
            'order'         => ['nullable', Rule::exists('orders', 'public_id')->whereNull('deleted_at')],
            'customer'      => ['nullable', new ExistsInAny(['vendors', 'contacts'], 'public_id')],
        ];
    }
}
