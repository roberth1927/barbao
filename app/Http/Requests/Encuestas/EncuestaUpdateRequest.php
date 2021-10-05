<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class EncuestaUpdateRequest extends FormRequest
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
            'nombre.required' => 'El nombre de la encuesta es requerido'
           
        ];
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
