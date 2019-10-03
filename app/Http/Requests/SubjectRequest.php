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
            'credits' => 'required|integer|min:1',
            'career_id' => 'required'
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
            'name.required' => 'Por favor, ingrese el nombre de la Asignatira',
            'name.min' => 'El nombre de la Asignatura debe tener mínimo 10 caracteres',
            'name.max' => 'El nombre de la Asignatura debe tener máximo 50 caracteres',
            'name.unique' => 'El nombre de la Asignatura ya se encuentra registrado para la Carrera seleccionada',
            'credits.required' => 'Por favor, ingrese las unidades de crédito',
            'credits.integer' => 'Las unidades de crédito deben ser dígitos',
            'credits.min' => 'El valor mínimo para las unidades de crédito es 1',

            'career_id.required' => 'Por favor, seleccione la Carrera de la Asignatura'
        ];
    }
}
