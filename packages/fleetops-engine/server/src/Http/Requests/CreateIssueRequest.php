<?php

namespace Transitops\FleetOps\Http\Requests;

use Transitops\Http\Requests\TransitopsRequest;

class CreateIssueRequest extends TransitopsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->session()->has('api_credential') || request()->session()->has('is_sanctum_token');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'driver'       => ['required'],
            'location'     => ['required'],
            'order'        => ['nullable', 'exists:orders,public_id'],
            'order_uuid'   => ['nullable', 'exists:orders,uuid'],
            'report'       => ['required'],
            'category'     => ['nullable'],
            'type'         => ['nullable'],
            'priority'     => ['nullable'],
            'tags'         => ['nullable', 'array'],
            'tags.*'       => ['string'],
        ];
    }
}
