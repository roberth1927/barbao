<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PreguntaUpdateRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'encuestas_id'  => 'required',
            'empresas_id'   => 'required',
            //'pregunta'      => 'required|encuesta_preguntas,pregunta',
            'tipo'          => 'required',
            'peso'          => 'required|integer'
        ];
    }

    public function messages(){
        return [
            'encuestas_id.required' => 'La encuesta es requerida',
            'empresas_id.required' => 'La empresa es requerida',
            'pregunta.required' => 'La pregunta es requerida',
            'tipo.required' => 'El tipo de pregunta es requerido',
            'peso.required' => 'El peso de la pregunta es requerido',
            'peso.integer' => 'Debe ser un dato numerico'
            
        ];
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
