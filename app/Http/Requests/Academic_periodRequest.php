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
            'faculty_id.required' => 'Por favor, ingrese la facultad del periodo academico',
            'name.required' => 'Por favor, ingrese el nombre del periodo academico',
            'name.min' => 'El nombre del periodo academico debe contener minimo 5 caracteres',
            'name.max' => 'El nombre del periodo academico debe contener maximo 7 caracteres',

            'dean.required' => 'Por favor, ingrese el nombre del decano para el periodo academico',
            'dean.min' => 'El nombre del decano debe contener minimo 10 caracteres',
            'dean.max' => 'El nombre del decano debe contener maximo 100 caracteres',

            'rep_sub_equi_one.required' => 'Por favor, ingrese el nombre del primer representante de la subcomision de equivalencias',
            'rep_sub_equi_one.min' => 'El nombre del primer representante de la subcomision de equivalencias debe contener minimo 10 caracteres',
            'rep_sub_equi_one.max' => 'El nombre del primer representante de la subcomision de equivalencias debe contener maximo 100 caracteres',

            'rep_sub_equi_two.required' => 'Por favor, ingrese el nombre del segundo representante de la subcomision de equivalencias',
            'rep_sub_equi_two.min' => 'El nombre del segundo representante de la subcomision de equivalencias debe contener minimo 10 caracteres',
            'rep_sub_equi_two.max' => 'El nombre del segundo representante de la subcomision de equivalencias debe contener maximo 100 caracteres',

            'rep_sub_equi_three.required' => 'Por favor, ingrese el nombre del tercero representante de la subcomision de equivalencias',
            'rep_sub_equi_three.min' => 'El nombre del tercero representante de la subcomision de equivalencias debe contener minimo 10 caracteres',
            'rep_sub_equi_three.max' => 'El nombre del tercero representante de la subcomision de equivalencias debe contener maximo 100 caracteres',

            'rep_comi_equi_one.required' => 'Por favor, ingrese el nombre del primer representante de la comision de equivalencias',
            'rep_comi_equi_one.min' => 'El nombre del primer representante de la comision de equivalencias debe contener minimo 10 caracteres',
            'rep_comi_equi_one.max' => 'El nombre del primer representante de la comision de equivalencias debe contener maximo 100 caracteres',

            'rep_comi_equi_two.required' => 'Por favor, ingrese el nombre del segundo representante de la comision de equivalencias',
            'rep_comi_equi_two.min' => 'El nombre del segundo representante de la comision de equivalencias debe contener minimo 10 caracteres',
            'rep_comi_equi_two.max' => 'El nombre del segundo representante de la comision de equivalencias debe contener maximo 100 caracteres',

            'rep_comi_equi_three.required' => 'Por favor, ingrese el nombre del tercero representante de la comision de equivalencias',
            'rep_comi_equi_three.min' => 'El nombre del tercero representante de la comision de equivalencias debe contener minimo 10 caracteres',
            'rep_comi_equi_three.max' => 'El nombre del tercero representante de la comision de equivalencias debe contener maximo 100 caracteres'
        ];
    }
}
