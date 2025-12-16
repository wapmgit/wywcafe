<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Vendedores;
use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests\CategoriaFormRequest;
use sisventas\Http\Requests\VendedoresFormRequest;
use sisventas\Pacientes;
use DB;
use Auth;

class VendedoresController extends Controller
{
    public function __construct()
    {
     
    }
    public function index(Request $request)
    {
	 $nivel=Auth::user()->nivel;
	 if ($nivel=="A")
	 {
			 $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$query=trim($request->get('searchText'));
			$vendedores=DB::table('vendedores')->where('nombre','LIKE','%'.$query.'%')
				->orderBy('id_vendedor','desc')
				->paginate(10);
    //dd($vendedores);
      return view("vendedor.vendedor.index",["vendedores"=>$vendedores,"searchText"=>$query,"empresa"=>$empresa]);
	 
    }
	}
	public function create()
	{
		return view("vendedor.vendedor.create");
	}
	public function edit($historia)
	{
		return view("vendedor.vendedor.edit",["vendedores"=>Vendedores::findOrFail($historia)]);
	}
	public function update(VendedoresFormRequest $request, $historia)
	{
      $paciente=Vendedores::findOrFail($historia);
        $paciente->nombre=$request->get('nombre');
        $paciente->cedula=$request->get('cedula');
        $paciente->telefono=$request->get('telefono');
    	$paciente->direccion=$request->get('direccion');
    	$paciente->comision=$request->get('comision');
        $paciente->update();
        return Redirect::to('vendedor/vendedor');
	}
	
	public function store (VendedoresFormRequest $request)
    {
        $paciente=new vendedores;
        $paciente->nombre=$request->get('nombre');
        $paciente->cedula=$request->get('cedula');
        $paciente->telefono=$request->get('telefono');
        $paciente->direccion=$request->get('direccion');
        $paciente->comision=$request->get('comision');
        $paciente->save();
        return Redirect::to('vendedor/vendedor');

    }
	public function show($id)
    {
			$clientes=DB::table('clientes')->where('vendedor','=',$id)
				->get();
			$ventas=DB::table('venta as v')
				->select(DB::raw('max(v.fecha_emi) as lastfact'),DB::raw('SUM(v.saldo) as pendiente'),DB::raw('SUM(v.total_venta) as facturado'),'idcliente')
				->where('idvendedor','=',$id)
				->orderby('fecha_emi','ASC')
				->groupby('v.idcliente')
				->get();
			$maventas=DB::table('venta as v')
				->join('clientes as c','c.id_cliente','=','v.idcliente')
				->select(DB::raw('SUM(v.saldo) as pendiente'),DB::raw('SUM(v.total_venta) as facturado'),'c.nombre')
				->where('idvendedor','=',$id)
				->orderby('facturado','DESC')
				->groupby('v.idcliente')
				->take(10)
				->get();
			$meventas=DB::table('venta as v')
				->join('clientes as c','c.id_cliente','=','v.idcliente')
				->select(DB::raw('SUM(v.saldo) as pendiente'),DB::raw('SUM(v.total_venta) as facturado'),'c.nombre')
				->where('idvendedor','=',$id)
				->orderby('facturado','ASC')
				->groupby('v.idcliente')
				->take(10)
				->get();
				
        return view("vendedor.vendedor.show",["vendedores"=>Vendedores::findOrFail($id),"clientes"=>$clientes,"ventas"=>$ventas,"maventas"=>$maventas,"meventas"=>$meventas]);
    }
	public function porcobrar()
	{
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$pacientes=DB::table('venta as v')
			->join('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
			->select(DB::raw('SUM(v.saldo) as acumulado'),'ve.nombre as vendedor','ve.cedula','ve.telefono','v.idvendedor')
			->where('v.saldo','>',0)
			->where('v.devolu','=',0)
			->where('v.tipo_comprobante','=','FAC')
			->groupby('v.idvendedor')
			->paginate(10);
			//dd($pacientes);
			$notasnd=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'),'not.tipo','c.vendedor')
			->where('not.tipo','=',1)
			->where('not.pendiente','>',0)		
			->groupby('c.vendedor')
			->get();
			
//dd($notasnd);
			return view('vendedor.cobrar.index',["notas"=>$notasnd,"vendedores"=>$pacientes,"empresa"=>$empresa]);
		
	}
		public function clientes($id)
	{
		//dd($id);
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$resumen=DB::table('detalle_venta as dv')
			->join('venta as v','v.idventa','=','dv.idventa')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			->select(DB::raw('SUM(dv.cantidad) as unidades'),DB::raw('month(dv.fecha_emi) as mes'),'c.id_cliente')
			->groupby('v.idcliente','mes')
			->where('v.idvendedor','=',$id)
			->where('dv.fecha_emi','like','%2023%')
			->get();
			$clientes=DB::table('clientes')->where('vendedor','=',$id)
				->get();
			//dd($resumen);
			return view('vendedor.vendedor.analisisclientes',["resumen"=>$resumen,"clientes"=>$clientes,"vendedores"=>Vendedores::findOrFail($id),"empresa"=>$empresa]);
		
	}
}
