<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class EmpresaStoreRequest extends FormRequest{ 
    public function authorize()
    {
        return true;
    }

    public function rules(){

        $this->sanitize();
        
        return [
            'nombre' => 'required|string|unique:empresas',
            'activa' => 'required',
            'email' => 'required|string|email'
        ];
    }

    public function messages(){
        return [
            'nombre.required' => 'El nombre de la empresa es obligatorio',
            'nombre.unique' => 'Ya existe una empresa con el nombre digitado',
            'activa.required' => 'El estado de la empresa es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Debe ingresar un email valido'
        ];
    }

    public function sanitize(){
        $input = $this->all();
        $input['nombre'] = filter_var($input['nombre'], FILTER_SANITIZE_STRING);
        $this->replace($input);
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
