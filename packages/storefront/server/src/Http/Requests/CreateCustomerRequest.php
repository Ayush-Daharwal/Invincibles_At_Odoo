<?php

namespace Transitops\Storefront\Http\Requests;

use Transitops\Http\Requests\TransitopsRequest;
use Illuminate\Validation\Rule;

class CreateCustomerRequest extends TransitopsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return session('storefront_key') || request()->session()->has('api_credential');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'  => 'required|exists:verification_codes,code',
            'name'  => 'required',
            'email' => [
                'email', 'nullable', Rule::unique('contacts')->where(function ($query) {
                    $query->where('company_uuid', session('company'));

                    return $query->whereNull('deleted_at');
                }),
            ],
            'phone' => [
                'nullable', Rule::unique('contacts')->where(function ($query) {
                    $query->where('company_uuid', session('company'));

                    return $query->whereNull('deleted_at');
                }),
            ],
        ];
    }
}
