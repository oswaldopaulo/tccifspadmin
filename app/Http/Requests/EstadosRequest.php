<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadosRequest extends FormRequest
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
            'nome_estado'=>"required",
            'uf_estado'=>"required|max:2|unique:estados,uf_estado," . $this->ignoreuf_estado . ',uf_estado',
            'codigo_estado'=>"required|max:2|unique:estados,codigo_estado," . $this->ignorecodigo_estado . ',codigo_estado'
            
        ];
    }
}
