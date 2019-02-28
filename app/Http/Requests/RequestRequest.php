<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class RequestRequest extends FormRequest
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
            'user_id' => 'required',
            'career_origin_id' => 'required',
            'career_destination_id' => 'required'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $existRequest = DB::select('SELECT r.id as id
                                        FROM users u
                                        JOIN requests r ON (r.user_id = u.id)
                                        JOIN request_has_status rhs ON (rhs.request_id = r.id)
                                        WHERE rhs.request_status_id != ? AND r.career_origin_id = ? AND r.career_destination_id = ? AND u.id = ?',
                                        [8, $this->input('career_origin_id'), $this->input('career_destination_id'),  $this->input('user_id')]);
            $existRequest = ($existRequest) ? $existRequest[0]->id : NULL ;
            if ($existRequest != $this->input('id')) {
                $validator->errors()->add('user_id', 'Ya se encuentra una solicitud en proceso con el solicitante y las carreras ingresadas');
            }
            if ($this->input('career_origin_id') === $this->input('career_destination_id')) {
              $validator->errors()->add('career_origin_id', 'La carrera - facultad - universidad de procedencia y donde desea cursar deben ser diferentes');
              $validator->errors()->add('career_destination_id', 'La carrera - facultad - universidad de procedencia y donde desea cursar deben ser diferentes');
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
            'user_id.required' => 'Por favor, ingrese la cedula del solicitante',
            'career_origin_id' => 'Por favor, ingrese la carrera - facultad - universidad de procedencia',
            'career_destination' => 'Por favor, ingrese la carrera - facultad - universidad donde desea cursar'
        ];
    }
}
