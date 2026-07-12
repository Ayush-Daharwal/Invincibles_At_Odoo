<?php

namespace Transitops\RegistryBridge\Http\Requests;

use Transitops\Http\Requests\TransitopsRequest;

class InstallExtensionRequest extends TransitopsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return session('company');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'extension' => ['required', 'exists:registry_extensions,public_id'],
        ];
    }
}
