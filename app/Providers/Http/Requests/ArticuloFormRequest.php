<?php

namespace sisventas\Http\Requests;

use sisventas\Http\Requests\Request;

class ArticuloFormRequest extends Request
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
            'idcategoria'=>'required',
            'codigo'=>'required|max:50',
            'nombre'=>'required|max:100',  
            'descripcion'=>'max:150',
            'imagen'=>'mimes:jpeg,bmp,png',
            'utilidad'=>'required|numeric',
            'precio1'=>'required|numeric',
            'impuesto'=>'required|numeric',
            'precio'=>'numeric',
            'costo'=>'numeric',
            
        ];
    }
}
