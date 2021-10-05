<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PreguntaRespuestaUpdateRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            // 'encuesta_preguntas_id'     => 'required',
            // 'empresas_id'               => 'required',
            // 'encuestas_id'              => 'required',
            // 'peso'                      => 'required|integer'
        ];
    }

    public function messages(){
        return [
            // 'encuesta_pregunta_id.required'     => 'La pregunta es requerida',
            // 'empresas_id'                       => 'La empresa es requerida',
            // 'encuestas_id'                      => 'La encuesta es requerida',
            // 'peso.required'                     => 'El peso de la opción es requerido',
            // 'peso.integer'                      => 'Debe ser un dato numerico'
            
        ];
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
