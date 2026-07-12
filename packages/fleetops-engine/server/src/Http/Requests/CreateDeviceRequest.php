<?php

namespace Transitops\FleetOps\Http\Requests;

use Transitops\FleetOps\Rules\ResolvablePoint;
use Transitops\Http\Requests\TransitopsRequest;
use Illuminate\Validation\Rule;

class CreateDeviceRequest extends TransitopsRequest
{
    public function authorize()
    {
        return request()->session()->has('api_credential') || request()->session()->has('is_sanctum_token');
    }

    public function rules()
    {
        return [
            'name'                  => [Rule::requiredIf($this->isMethod('POST')), 'string'],
            'type'                  => ['nullable', 'string'],
            'device_id'             => ['nullable', 'string'],
            'internal_id'           => ['nullable', 'string'],
            'imei'                  => ['nullable', 'string'],
            'imsi'                  => ['nullable', 'string'],
            'firmware_version'      => ['nullable', 'string'],
            'provider'              => ['nullable', 'string'],
            'model'                 => ['nullable', 'string'],
            'manufacturer'          => ['nullable', 'string'],
            'serial_number'         => ['nullable', 'string'],
            'location'              => ['nullable'],
            'last_position'         => ['nullable', new ResolvablePoint()],
            'latitude'              => ['nullable', 'required_with:longitude'],
            'longitude'             => ['nullable', 'required_with:latitude'],
            'installation_date'     => ['nullable', 'date'],
            'last_maintenance_date' => ['nullable', 'date'],
            'last_online_at'        => ['nullable', 'date'],
            'online'                => ['nullable', 'boolean'],
            'status'                => ['nullable', 'string'],
            'data_frequency'        => ['nullable', 'integer'],
            'notes'                 => ['nullable', 'string'],
            'telematic'             => ['nullable', 'string'],
            'warranty'              => ['nullable', 'string'],
            'photo'                 => ['nullable', 'string'],
            'attachable_type'       => ['nullable', 'string'],
            'attachable'            => ['nullable', 'required_with:attachable_type', 'string'],
            'meta'                  => ['nullable', 'array'],
            'data'                  => ['nullable', 'array'],
            'options'               => ['nullable', 'array'],
        ];
    }
}
