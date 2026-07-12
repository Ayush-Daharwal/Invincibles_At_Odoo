<?php

namespace Transitops\FleetOps\Http\Requests;

use Transitops\FleetOps\Rules\ResolvablePoint;
use Transitops\Http\Requests\TransitopsRequest;
use Illuminate\Validation\Rule;

class CreateVehicleRequest extends TransitopsRequest
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
            'status'    => [
                'nullable',
                Rule::in([
                    'active',
                    'available',
                    'in_use',
                    'maintenance',
                    'out_of_service',
                    'reserved',
                    'retired',
                    'staging',
                    'on_route',
                    'idle',
                    'cleaning',
                    'awaiting_parts',
                    'inspection_due',
                    'inspection_failed',
                    'accident',
                    'compliance_hold',
                    'stolen',
                    'operational',
                    'decommissioned',
                ]),
            ],
            'vendor'    => 'nullable|exists:vendors,public_id',
            'driver'    => 'nullable|exists:drivers,public_id',
            'location'  => ['nullable', new ResolvablePoint()],
            'latitude'  => ['nullable', 'required_with:longitude'],
            'longitude' => ['nullable', 'required_with:latitude'],
        ];
    }
}
