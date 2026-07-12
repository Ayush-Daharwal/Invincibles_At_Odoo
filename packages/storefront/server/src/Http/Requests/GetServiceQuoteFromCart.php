<?php

namespace Transitops\Storefront\Http\Requests;

use Transitops\Http\Requests\TransitopsRequest;
use Transitops\Storefront\Rules\IsValidLocation;
use Illuminate\Support\Str;

class GetServiceQuoteFromCart extends TransitopsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return session('storefront_key');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // valid origin is only required if store_ key
        return [
            'origin'      => $this->isStoreKey() ? ['required',  new IsValidLocation()] : [],
            'destination' => ['required', new IsValidLocation()],
            'cart'        => 'required',
        ];
    }

    private function isStoreKey()
    {
        return Str::startsWith(session('storefront_key'), 'store_');
    }
}
