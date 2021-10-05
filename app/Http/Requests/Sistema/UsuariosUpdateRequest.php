<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosUpdateRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $this->sanitize();
        return [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'id_empresa' => 'required',
            'rol_id' => 'required',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Los nombres y apellidos del usuario es requerido',
            'email.required' => 'El email del usuario es requerido',
            'id_empresa.required' => 'La empresa es obligatoria',
            'rol_id.required' => 'El rol de usuario es obligatorio',
        ];
    }

    public function sanitize(){
        $input = $this->all();
        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $input['email'] = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
        $this->replace($input);
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
