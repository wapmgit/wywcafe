<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use response;
use Illuminate\Support\Collection;
use Auth;
use DB;
use sisventas\Fexterna;

class FexternaController extends Controller
{
    public function __construct()
    {
     
    }
 public function index(Request $request)
    {
        if ($request)
        {
			$rol=DB::table('roles')-> select('crearfe','editarfe','anularfe')->where('iduser','=',$request->user()->id)->first();
			   $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
            $ventas=DB::table('ventasexternas as v')
			 -> join ('clientes as p','v.cliente','=','p.id_cliente')
            -> where ('p.nombre','LIKE','%'.$query.'%')
            -> orderBy('v.idventa','desc')
            ->paginate(20);
     
     return view ('ventas.fexterna.index',["rol"=>$rol,"ventas"=>$ventas,"searchText"=>$query,"empresa"=>$empresa]);
        }
    } 
	public function create(){
		        $personas=DB::table('clientes')
				->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')
				->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.diascre','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.id_vendedor as nombrev','clientes.licencia')-> where('clientes.status','=','A')->groupby('clientes.id_cliente')->get();
		        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
      return view("ventas.fexterna.create",["empresa"=>$empresa,"personas"=>$personas]);
    }
	public function store(Request $request){
		//	dd($request);
		$user=Auth::user()->name;
			try{
		DB::beginTransaction();
				$fac=new Fexterna;
				$fac->rif=$request->get('rif');
				$fac->cliente=$request->get('cliente');
				$fac->fecha=$request->get('fecha');
				$fac->serie=$request->get('serie');
				$fac->tipo=$request->get('tipo');
				$fac->factura=$request->get('documento');
				$fac->control=$request->get('control');
				$fac->totalventa=$request->get('tventa');
				$fac->base=$request->get('base');
				$fac->exento=$request->get('exe');
				$fac->iva=$request->get('iva');
				$mytime=Carbon::now('America/Caracas');
				$fac->fechareg=$mytime->toDateTimeString();
				$fac->usuario=$user;
				$fac-> save();
					DB::commit();
		}
		catch(\Exception $e)
		{
			DB::rollback();
		} 
		return Redirect::to('ventas/fexterna');
	}
	    public function edit($id)
    {
		//dd($id);
			   $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			        $personas=DB::table('clientes')
				->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')
				->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.diascre','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.id_vendedor as nombrev','clientes.licencia')-> where('clientes.status','=','A')->groupby('clientes.id_cliente')->get();
        return view("ventas.fexterna.edit",["empresa"=>$empresa,"personas"=>$personas,"factura"=>Fexterna::findOrFail($id)]);
    }
	    public function update(Request $request,$id)
    {
			//dd($request);
			$user=Auth::user()->name;
			$fac=Fexterna::findOrFail($id);
				$fac->rif=$request->get('rif');
				$fac->cliente=$request->get('cliente');
				$fac->fecha=$request->get('fecha');
				$fac->serie=$request->get('serie');
				$fac->tipo=$request->get('tipo');
				$fac->factura=$request->get('documento');
				$fac->control=$request->get('control');
				$fac->totalventa=$request->get('tventa');
				$fac->base=$request->get('base');
				$fac->exento=$request->get('exe');
				$fac->iva=$request->get('iva');
				$mytime=Carbon::now('America/Caracas');
				$fac->fechareg=$mytime->toDateTimeString();
				$fac->usuario=$user;
				$fac-> save();
        return Redirect::to('ventas/fexterna');
    }
	public function show($id){
    $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $venta=DB::table('ventasexternas as v')
	 -> join ('clientes as p','v.cliente','=','p.id_cliente')
            ->where ('v.idventa','=',$id)
            -> first();

            return view("ventas.fexterna.show",["venta"=>$venta,"empresa"=>$empresa]);
}
public function destroy($id){
			$ingreso=Fexterna::findOrFail($id);
			 $ingreso->estatus=1;
			 $ingreso->update();			 	
	return Redirect::to('ventas/fexterna');
}
}
