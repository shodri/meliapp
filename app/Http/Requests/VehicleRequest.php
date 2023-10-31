<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [            
            'brand_id' => ['required'],
            'model_id' => ['required'],
            'location_id' => ['required'],
            'title' => ['required'],
            'color' => ['nullable'],
            'version_id' => ['nullable'],
            'patent' => ['required'],
            'year' => ['required'],
            'kilometers' => ['required'],
            'fuel_id' => ['required'],
            'currency_id' => ['nullable'],
            'price' => ['required'],
            'status' => ['in:activo,inactivo'],
            'images.*' => ['nullable', 'image'],
        ];

    }

}
