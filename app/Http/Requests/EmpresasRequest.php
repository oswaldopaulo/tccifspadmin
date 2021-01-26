<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresasRequest extends FormRequest
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
            'nome'=>'required|max:50',
            'cpf'=>'required|max:15',
		    'telefone'=>'max:30',
            'celular'=>'max:30',
            'cep_end'=>'nullable|numeric|max:99999999999',
            'num_end'=>'max:11',
            'compl_num_end'=>'max:100',
            'email'=>'max:100',
            'token'=>'max:150|unique:empresas,token,' . $this->token . ',token' ,
            'des_end'=>'max:45',
            'bairro'=>'max:45',
            'des_cidade'=>'max:45',
            'des_uf'=>'max:2',
       
        ];
    }
    
    public function messages()
{
    return [
        'cpf.required'=>'CPF/CNPJ é obrigatório e somente numeros',
        'cpf.max'=>'CPF/CNPJ é não pode conter mais que 14 numeros',
    ];
}
}


