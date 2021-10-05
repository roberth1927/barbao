<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;

class RolesUpdateRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $this->sanitize();
        
        return [
            // 'name' => 'required|string|unique:roles,name,' . $this->name
            'name' => 'required|string',

        ];
    }

    public function messages(){
        return [
            'name.required' => 'El nombre del rol es obligatorio',
            'name.unique' => 'Ya se encuentra un rol con el nombre digitado'
        ];
    }

    public function sanitize(){
        $input = $this->all();
        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $this->replace($input);
    }

    protected function failedValidation($validator){
        $this->validator = $validator;
    }
}
