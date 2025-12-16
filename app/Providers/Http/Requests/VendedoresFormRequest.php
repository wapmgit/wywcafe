<?php

namespace sisventas\Http\Requests;

use sisventas\Http\Requests\Request;

class VendedoresFormRequest extends Request
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
        
            'nombre'=>'required|max:100',
            'cedula'=>'required|max:10',

        ];
    }
}