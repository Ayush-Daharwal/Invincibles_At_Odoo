<?php

namespace Transitops\RegistryBridge\Http\Requests;

use Transitops\Http\Requests\TransitopsRequest;

class RegistryExtensionActionRequest extends TransitopsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return session('is_admin') === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:registry_extensions,uuid',
        ];
    }
}
