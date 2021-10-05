<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TipoStoreRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'nombre' => 'required|unique:encuesta_tipos,nombre'         
            
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'El nombre del tipo de encuesta es obligatorio',
            'nombre.unique' => 'Ya existe un tipo de encuesta con el nombre digitado'
           
        ];
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }


}
