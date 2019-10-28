<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MyRequestRequest extends FormRequest
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
            'career_origin_id' => 'required',
            'career_destination_id' => 'required'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $existRequest = DB::select('SELECT rhs.request_status_id as id
                                        FROM users u
                                        JOIN requests r ON (r.user_id = u.id)
                                        JOIN request_has_status rhs ON (rhs.request_id = r.id)
                                        WHERE r.career_origin_id = ? AND r.career_destination_id = ? AND u.id = ? AND r.deleted_at IS NULL
                                        ORDER BY rhs.id DESC LIMIT 1',
                                        [$this->input('career_origin_id'), $this->input('career_destination_id'),  backpack_user()->id]);
            $existRequest = ($existRequest) ? $existRequest[0]->id : NULL ;

            if ($existRequest != 8 && $existRequest) {
                $validator->errors()->add('user_id', 'Ya se encuentra una Solicitud en proceso con el solicitante y las Carreras ingresadas');
            }
            if ($this->input('career_origin_id') === $this->input('career_destination_id')) {
              $validator->errors()->add('career_origin_id', 'Las Carreras de procedencia y destino deben ser diferentes');
              $validator->errors()->add('career_destination_id', 'Las Carreras de procedencia y destino deben ser diferentes');
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
            'career_origin_id' => 'Por favor, ingrese la carrera - facultad - universidad de procedencia',
            'career_destination' => 'Por favor, ingrese la carrera - facultad - universidad donde desea cursar'
        ];
    }
}
