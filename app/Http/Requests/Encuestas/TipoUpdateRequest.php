<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TipoUpdateRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string'
          
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'El nombre del tipo de encuesta es obligatorio'
          
           
        ];
    }
    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
