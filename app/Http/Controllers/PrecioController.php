<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\IngresoFormRequest;
use DB;
use sisventas\Articulo;
use sisventas\ingreso;
use sisventas\Proovedor;
use sisventas\Movbanco;
use sisventas\Kardex;
use sisventas\comprobante;
use sisventas\devolucionCompras;
use sisventas\detalledevolucionCompras;
use sisventas\DetalleIngreso;
use Auth;
use Carbon\Carbon;
use response;
use Illuminate\Support\Collection;

class PrecioController extends Controller
{
    public function _construct(){

    }
	    public function store(Request $request){
	//dd($request);
	$user=Auth::user()->name;
	//try{
  // DB::beginTransaction(); 		
      $ingreso=ingreso::findOrFail($request->get('id'));
    $ingreso->tipo_comprobante="FAC";
    $ingreso->serie_comprobante=$request->get('serie_comprobante');
    $ingreso->num_comprobante=$request->get('num_comprobante');
    $ingreso->emision=$request->get('emision');
    $ingreso->total=$request->get('tcompra');
    $ingreso->saldo=$request->get('tcompra');
    $ingreso->base=$request->get('tbase');
    $ingreso->miva=$request->get('tiva');
    $ingreso->exento=$request->get('texe');
    $ingreso-> update();

// carga detalles de compra
        $detalle = $request -> get('detalle');
        $precio_compra = $request -> get('precio');
        $sub = $request -> get('subt');
        
        $impuesto=0; $utilidad=0; $costo=0; $util2=0;
        $cont = 0; $cont2 = 0;
            while($cont < count($detalle)){
			$det=DetalleIngreso::findOrFail($detalle[$cont]);
            $det->precio_compra=$precio_compra[$cont];
            $det->precio_tasa= $ingreso->tasa*$precio_compra[$cont];
            $det->subtotal=$sub[$cont];
            $det->update();			       
			$cont=$cont+1;
                    }
                            
        /*       DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
} */
return Redirect::to('compras/ingreso');
}

}
