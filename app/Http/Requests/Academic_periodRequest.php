<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class Academic_periodRequest extends FormRequest
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
          'faculty_id' => 'required',
           'name' => 'required|min:5|max:7',
           'dean' => 'required|min:10|max:100',
           'rep_sub_equi_one' => 'required|min:10|max:100',
           'rep_sub_equi_two' => 'required|min:10|max:100',
           'rep_sub_equi_three' => 'required|min:10|max:100',
           'rep_comi_equi_one' => 'required|min:10|max:100',
           'rep_comi_equi_two' => 'required|min:10|max:100',
           'rep_comi_equi_three' => 'required|min:10|max:100'
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
            'faculty_id.required' => 'Por favor, ingrese la Facultad del Período Académico',
            'name.required' => 'Por favor, ingrese el nombre del Período Académico',
            'name.min' => 'El nombre del Período Académico debe contener mínimo 5 caracteres',
            'name.max' => 'El nombre del Período Académico debe contener máximo 7 caracteres',

            'dean.required' => 'Por favor, ingrese el nombre del Decano para el Período Académico',
            'dean.min' => 'El nombre del Decano debe contener mínimo 10 caracteres',
            'dean.max' => 'El nombre del Decano debe contener máximo 100 caracteres',

            'rep_sub_equi_one.required' => 'Por favor, ingrese el nombre del primer representante de la Subcomisión de Equivalencias',
            'rep_sub_equi_one.min' => 'El nombre del primer representante de la Subcomisión de Equivalencias debe contener mínimo 10 caracteres',
            'rep_sub_equi_one.max' => 'El nombre del primer representante de la Subcomisión de Equivalencias debe contener máximo 100 caracteres',

            'rep_sub_equi_two.required' => 'Por favor, ingrese el nombre del segundo representante de la Subcomisión de Equivalencias',
            'rep_sub_equi_two.min' => 'El nombre del segundo representante de la Subcomisión de Equivalencias debe contener mínimo 10 caracteres',
            'rep_sub_equi_two.max' => 'El nombre del segundo representante de la Subcomisión de Equivalencias debe contener máximo 100 caracteres',

            'rep_sub_equi_three.required' => 'Por favor, ingrese el nombre del tercero representante de la Subcomisión de Equivalencias',
            'rep_sub_equi_three.min' => 'El nombre del tercero representante de la Subcomisión de Equivalencias debe contener mínimo 10 caracteres',
            'rep_sub_equi_three.max' => 'El nombre del tercero representante de la Subcomisión de Equivalencias debe contener máximo 100 caracteres',

            'rep_comi_equi_one.required' => 'Por favor, ingrese el nombre del primer representante de la Comisión de Equivalencias',
            'rep_comi_equi_one.min' => 'El nombre del primer representante de la Comisión de Equivalencias debe contener mínimo 10 caracteres',
            'rep_comi_equi_one.max' => 'El nombre del primer representante de la Comisión de Equivalencias debe contener máximo 100 caracteres',

            'rep_comi_equi_two.required' => 'Por favor, ingrese el nombre del segundo representante de la Comisión de Equivalencias',
            'rep_comi_equi_two.min' => 'El nombre del segundo representante de la Comisión de Equivalencias debe contener mínimo 10 caracteres',
            'rep_comi_equi_two.max' => 'El nombre del segundo representante de la Comisión de Equivalencias debe contener máximo 100 caracteres',

            'rep_comi_equi_three.required' => 'Por favor, ingrese el nombre del tercero representante de la Comisión de Equivalencias',
            'rep_comi_equi_three.min' => 'El nombre del tercero representante de la Comisión de Equivalencias debe contener mínimo 10 caracteres',
            'rep_comi_equi_three.max' => 'El nombre del tercero representante de la Comisión de Equivalencias debe contener máximo 100 caracteres'
        ];
    }
}
