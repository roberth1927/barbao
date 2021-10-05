<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PreguntaStoreRequest extends FormRequest
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
            'pregunta'      => 'required|unique:encuesta_preguntas,pregunta',
            'tipo'          => 'required',
            'peso'          => 'required|integer'

        ];
    }

    public function messages(){
        return [
            'encuestas_id.required' => 'El nombre de la encuesta es requerido',
            'empresas_id.required'  => 'El nombre de la empresa es requerido',
            'pregunta.required'     => 'La pregunta es requerida',
            'pregunta.unique'       => 'La pregunta digitada ya existe',
            'peso.required'         => 'El tipo de pregunta es requerido',
            'peso.required'         => 'El peso de la pregunta es requerido',
            'peso.integer'          => 'Debe ser un dato numerico'
            
        ];
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
