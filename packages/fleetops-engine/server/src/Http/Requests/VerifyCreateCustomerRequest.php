<?php

namespace Transitops\FleetOps\Http\Requests;

use Transitops\Http\Requests\TransitopsRequest;

/**
 * Validates the body of `POST /v1/customers/request-creation-code`.
 */
class VerifyCreateCustomerRequest extends TransitopsRequest
{
    public function authorize(): bool
    {
        return request()->session()->has('api_credential')
            || request()->session()->has('is_sanctum_token');
    }

    public function rules(): array
    {
        return [
            'mode'     => 'required|in:email,sms',
            'identity' => 'required|string',
            // Optional profile context — when provided, used to greet the
            // customer in the verification email and pre-seed the User row.
            'name'     => 'nullable|string|max:255',
            'phone'    => 'nullable|string|max:32',
        ];
    }
}
