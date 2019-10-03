<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CareerRequest extends FormRequest
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
                        Rule::unique('careers')->where(function ($query) {
                                  return $query->where('school_id', $this->input('school_id'));
                                })->ignore($this->input('id'))
                      ],
            'school_id' => 'required'
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
          'name.required' => 'Por favor, ingrese el nombre de la Carrera',
          'name.min' => 'El nombre de la Carrera debe tener mínimo 5 caracteres',
          'name.max' => 'El nombre de la Carrera debe tener máximo 50 caracteres',
          'name.unique' => 'El nombre de esta Carrera ya se encuentra registrado para la Escuela seleccionada',
          'school_id.required' => 'Por favor, ingrese la Escuela a la que pertenece la Carrera'
      ];
    }
}
