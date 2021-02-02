<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $this->ignoreemail . ',email',
            'password' => 'confirmed',
            'uf' => 'required|max:2',
	        'telefone'=> 'max:15',
            'cep'=> 'max:99999999|numeric',
            'rua'=> 'max:100',
            'numero'=> 'max:10',
            'bairro'=> 'max:50',
            'cidade'=> 'max:50',
            'cpf'=> 'max:11',

        ];
    }
}
