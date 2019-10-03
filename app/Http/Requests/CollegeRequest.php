<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollegeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required',
                        'min:10',
                        'max:100',
                        Rule::unique('colleges')->ignore($this->input('id'))
                      ],
            'address' => 'required',
            'abbreviation' => 'required|min:2'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Por favor, ingrese el nombre de la Universidad',
            'name.min' => 'El nombre de la Universidad debe tener mínimo 10 caracteres',
            'name.max' => 'El nombre de la Universidad debe tener máximo 100 caracteres',
            'name.unique' => 'Esta Universidad ya se encuentra registrada',
            'address.required' => 'Por favor, ingrese la dirección de la Universidad',
            'abbreviation.required' => 'Por favor, ingrese la abreviación de la Universidad',
            'abbreviation.min' => 'La abreviación de la Universidad debe tener mínimo 2 caracteres'
        ];
    }
}
