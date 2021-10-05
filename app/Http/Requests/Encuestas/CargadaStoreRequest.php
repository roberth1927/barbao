<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CargadaStoreRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
           
            'encuesta_id'        => 'required',
            'empresas_id'        => 'required',
            'cliente_id'         => 'required',
            'orden_id'           => 'required',
            'empresas'           => 'required',
            'tipo_estado'        => 'required',
            'respuestas'          => 'required',
            'fecha_respuesta'    => 'required',
            'dispositivo'        => 'required',
            'ip'                 => 'required',
            'user'               => 'required'
            
        ];
    }

    public function messages(){
        return [
            
            'encuesta_id.required'      => 'La encuesta es requerida',
            'empresas_id.required'      => 'La empresa es requerida',
            'cliente_id.required'       => 'El cliente es requerido',
            'orden_id.required'         => 'La orden es requerida',
            'empresas.required'         => 'La empresa es requerida',
            'tipo_estado.required'      => 'El tipo de estado es requerido',
            'respuestas.required'        => 'La respuesta es requerida',
            'fecha_respuesta.required'  => 'La fecha es requerida',
            'dispositivo.required'      => 'El dispositivo es requerido',
            'ip.required'               => 'La IP es requerida',
            'user.required'             => 'El usuario requerido'
        ];
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
