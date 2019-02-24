<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolRequest extends FormRequest
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
                          Rule::unique('schools')->where(function ($query) {
                                    return $query->where('faculty_id', $this->input('faculty_id'));
                                  })
                        ],
              'faculty_id' => 'required'
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
          'name.required' => 'Por favor, ingrese el nombre de la escuela',
          'name.min' => 'El nombre de la escuela debe tener minimo 5 caracteres',
          'name.max' => 'El nombre de la escuela debe tener maximo 50 caracteres',
          'name.unique' => 'El nombre de esta escuela ya se encuentra registrado para la facultad seleccionada',

          'faculty_id.required' => 'Por favor, ingrese la facultad a la que pertenece la escuela'
      ];
    }
}
