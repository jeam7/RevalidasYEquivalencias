<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
                          'max:50'
                        ],
              'college_id' => 'required'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->input('faculty_id')) {
              $existSchool = DB::select('SELECT 1 FROM schools WHERE name = ? AND college_id = ?', [$this->input('name'), $this->input('college_id')]);
            }else {
              $existSchool = DB::select('SELECT 1 FROM schools WHERE name = ? AND college_id = ? AND faculty_id = ?',
                                        [$this->input('name'), $this->input('college_id'), $this->input('faculty_id')]);
            }

            if ($existSchool) {
              $validator->errors()->add('name', 'El nombre de esta Escuela ya se encuentra registrado para esta Universidad/Facultad');
            }
        });
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
          'name.required' => 'Por favor, ingrese el nombre de la Escuela',
          'name.min' => 'El nombre de la Escuela debe tener mínimo 5 caracteres',
          'name.max' => 'El nombre de la Escuela debe tener máximo 50 caracteres',
          'college_id.required' => 'Por favor, ingrese la Universidad a la que pertenece la Escuela'
      ];
    }
}
