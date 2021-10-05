<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class EncuestaStoreRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

  
    public function rules()
    {
        return [
            'empresas_id'       => 'required',
            'encuesta_tipos_id' => 'required',
            'nombre'            => 'required|unique:encuestas,nombre'
           
        ];
    }

    public function messages(){
        return [
            'empresas_id.required'          => 'El nombre de la empresas es requerido encuesta requerido',
            'encuesta_tipos_id.required'    => 'El tipo de encuesta requerido',
            'nombre.required'               => 'El nombre de la encuesta es requerido',
            'nombre.unique'                 => 'Ya existe una encuesta con el nombre digitado'
          
        ];
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }

}
