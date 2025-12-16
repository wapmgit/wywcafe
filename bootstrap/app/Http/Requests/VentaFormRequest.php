<?php

namespace sisventas\Http\Requests;

use sisventas\Http\Requests\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
class VentaFormRequest extends Request
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
            'id_cliente'=>'required',
           'tipo_comprobante'=>'required|max:20',
           'serie_comprobante'=>'max:10',
           'num_comprobante'=>'required',
           'idarticulo'=>'required',
           'cantidad'=>'required',
           'precio_venta'=>'required',
           'total_venta'=>'required'
        ];
    }
}
