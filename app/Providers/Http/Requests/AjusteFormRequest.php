<?php

namespace sisventas\Http\Requests;

use sisventas\Http\Requests\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
class AjusteFormRequest extends Request
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
           'concepto'=>'required',
           'responsable'=>'required|max:20',
           
           'idarticulo'=>'required',
           'cantidad'=>'required',
           'precio_compra'=>'required',
         
        ];
    }
}
