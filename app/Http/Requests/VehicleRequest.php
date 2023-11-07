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
            'version_id' => ['required'],
            'location_id' => ['required'],
            'title' => ['required'],
            'color' => ['nullable'],
            'year' => ['required'],
            'kilometers' => ['required'],
            'fuel_id' => ['required'],
            'currency_id' => ['nullable'],
            'price' => ['required'],
            'motor' => ['nullable'],
            'doors' => ['required'],
            'steering' => ['nullable'],
            'traction' => ['nullable'],
            'condition' => ['required'],
            'description' => ['nullable'],
            'status' => ['in:activo,inactivo'],
            'images.*' => ['nullable', 'image'],
        ];

    }

}
