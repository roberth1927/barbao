<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CargadaUpdateRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [   
            'encuestas_id'        => 'required',
            'empresas_id'        => 'required',
            'cliente_id'         => 'required',
            'orden_id'           => 'required',
            'empresas'           => 'required',
            //'tipo_estado'        => 'required',
            'respuesta'          => 'required',
            'fecha_respuesta'    => '',
            // 'dispositivo'        => 'required',
            // 'ip'                 => 'required',
            // 'user'               => 'required',
            'id_ws'              => 'required',
            'token'              => 'required'
            
            
        ];
    }

    public function messages(){
        return [
            'encuestas_id.required'      => 'La encuesta es requerida',
            'empresas_id.required'      => 'La empresa es requerida',
            'cliente_id.required'       => 'El cliente es requerido',
            'orden_id.required'         => 'La orden es requerida',
            'empresas.required'         => 'La empresa es requerida',
            'tipo_estado.required'      => 'El tipo de estado es requerido',
            'respuesta.required'        => 'La respuesta es requerida',
            'fecha_respuesta.required'  => 'La fecha es requerida',
            'dispositivo.required'      => 'El dispositivo es requerido',
            'ip.required'               => 'La IP es requerida',
            'user.required'             => 'El usuario requerido',
            'id_ws.required'            => 'id_ws',
            'token.required'            => 'token'
        ];
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
