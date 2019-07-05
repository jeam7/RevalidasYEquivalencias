<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
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
                      'min:5',
                      'max:50',
                      Rule::unique('subjects')->where(function ($query) {
                                return $query->where('career_id', $this->input('career_id'));
                              })->ignore($this->input('id'))
                    ],
            'credits' => 'required|integer|min:1'
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
            'name.required' => 'Por favor, ingrese el nombre de la asignatira',
            'name.min' => 'El nombre de la asignatura debe tener minimo 10 caracteres',
            'name.max' => 'El nombre de la asignatura debe tener maximo 50 caracteres',
            'name.unique' => 'El nombre de la materia ya se encuentra registrado para la carrera seleccionada',

            'credits.required' => 'Por favor, ingrese las unidades de credito',
            'credits.integer' => 'Las unidades de credito deben ser digitos',
            'credits.min' => 'El valor minimo para las unidades de credito es 1'
        ];
    }
}
