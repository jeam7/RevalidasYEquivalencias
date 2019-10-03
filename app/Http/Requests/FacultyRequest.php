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
                                  return $query->where('college_id', $this->input('college_id'))
                                                ->where('deleted_at', NULL);
                                })->ignore($this->input('id'))
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
            'name.required' => 'Por favor, ingrese el nombre de la Facultad',
            'name.min' => 'El nombre de la Facultad debe tener mínimo 5 caracteres',
            'name.max' => 'El nombre de la Facultad debe tener máximo 50 caracteres',
            'name.unique' => 'El nombre de esta Facultad ya se encuentra registrado para la Universidad seleccionada',
            'college_id.required' => 'Por favor, ingrese la Universidad a la que pertenece la Facultad'
        ];
    }
}
