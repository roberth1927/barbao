<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;

class PermisosStoreRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $this->sanitize();
        
        return [
            'id_empresa' => 'required',
            'rol_id' => 'required',
            'modulo' => 'required|string',
            'sub_modulo' => 'required|string',
            'permisos' => 'required',
        ];
    }

    public function messages(){
        return [
            'id_empresa.required' => 'La empresa es obligatoria',
            'rol_id.required' => 'El rol es obligatorio',
            'modulo.required' => 'El módulo es obligatorio',
            'sub_modulo.required' => 'El sub módulo es obligatorio',
            'permisos.required' => 'Los permisos son obligatorios',
        ];
    }

    public function sanitize(){
        $input = $this->all();
        $input['modulo'] = filter_var($input['modulo'], FILTER_SANITIZE_STRING);
        $input['sub_modulo'] = filter_var($input['sub_modulo'], FILTER_SANITIZE_STRING);
        $this->replace($input);
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
