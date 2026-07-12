<?php

namespace Transitops\FleetOps\Http\Requests;

use Transitops\Http\Requests\TransitopsRequest;

class BulkDispatchRequest extends TransitopsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->session()->has('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids' => ['required', 'array'],
        ];
    }

    /**
     * Get the validation rules error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'ids.required' => 'Please provide a resource ID.',
            'ids.array'    => 'Please provide multiple resource ID\'s.',
        ];
    }
}
