<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FacultyRequest extends FormRequest
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
                        Rule::unique('faculties')->where(function ($query) {
                                  return $query->where('college_id', $this->input('college_id'));
                                })
                      ],
            'college_id' => 'required'
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
            'name.required' => 'Por favor, ingrese el nombre de la facultad',
            'name.min' => 'El nombre de la facultad debe tener minimo 5 caracteres',
            'name.max' => 'El nombre de la facultad debe tener maximo 50 caracteres',
            'name.unique' => 'El nombre de esta facultad ya se encuentra registrado para la universidad seleccionada',

            'college_id.required' => 'Por favor, ingrese la universidad a la que pertenece la facultad'
        ];
    }
}
