<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKPILegacyRequest extends FormRequest
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
            'email'=> 'required|email|unique:kpis,email',
            'year' => 'required|numeric|digits:4',
            'month' => 'required|numeric|between:1,12',
            'value' => 'required|numeric',
            'type' => 'required|string',
            'subtype' => 'required|string'
        ];
    }
}
