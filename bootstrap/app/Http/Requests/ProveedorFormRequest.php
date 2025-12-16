<?php

namespace sisventas\Http\Requests;

use sisventas\Http\Requests\Request;

class ProveedorFormRequest extends Request
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
       'nombre'=>'required|max:80',
       'rif'=>'required|max:15',
        'direccion'=>'max:80',
        'telefono'=>'max:15',
        ];
    }

    
}
