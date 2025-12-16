<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Pacientes;
use sisventas\Vendedores;
use sisventas\Notasadm;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\PacientesFormRequest;
use DB;
use Carbon\Carbon;
use Auth;

class PacientesController extends Controller
{
	    
	public function __construct()
	{
$this->middleware('auth');
	}

	public function index(Request $request)
	{
		if ($request)
		{

			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$query=trim($request->get('searchText'));
			$pacientes=DB::table('clientes')->where('clientes.nombre','LIKE','%'.$query.'%')
			->join('vendedores as ven','ven.id_vendedor','=','clientes.vendedor')
			->select('clientes.id_cliente','clientes.nombre','clientes.telefono','clientes.cedula','clientes.direccion','ven.nombre as vendedor')
			->where('clientes.status','=','A')
			->orderBy('clientes.id_cliente','desc')
			->paginate(20);
			return view('pacientes.paciente.index',["pacientes"=>$pacientes,"empresa"=>$empresa,"searchText"=>$query]);
		}
	}
	public function create()
	{
		$vendedor=DB::table('vendedores')->get();
		$municipios=DB::table('municipios')->get();
		return view("pacientes.paciente.create",["vendedores"=>$vendedor,"municipios"=>$municipios]);
	}
		    public function show($id)
    {
		//dd($id);
			$pacientes=DB::table('clientes')
			->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')
			->select('clientes.nombre','clientes.telefono','clientes.cedula','clientes.id_cliente','clientes.direccion','vendedores.nombre as vendedor')
			->where('clientes.id_cliente','=',$id)
			->first();
			$ventas=DB::table('venta')
			->join('detalle_venta as det','det.idventa','=','venta.idventa')
			->select('venta.tipo_comprobante','venta.num_comprobante','venta.serie_comprobante','venta.total_venta','venta.total_pagar','venta.fecha_hora','venta.comision','venta.descuento','venta.saldo','venta.devolu','venta.estado','venta.idventa')
				->where('venta.idcliente','=',$id)
				->orderBy('venta.idventa','desc')
				->groupBy('venta.idventa')
				->get();
				//recibos
		  $pagos=DB::table('recibos as re')
				  ->join('venta as v','v.idventa','=','re.idventa')
				  ->join('clientes as cli','cli.id_cliente','=','v.idcliente')
         -> select('re.monto','re.recibido','re.idbanco','re.idpago','v.tipo_comprobante','v.num_comprobante','re.fecha')
		 -> where('v.idcliente','=',$id)
            ->get(); 
			$notas=DB::table('notasadm')->where('notasadm.idcliente','=',$id)->get();
        return view("pacientes.paciente.show",["cliente"=>$pacientes,"ventas"=>$ventas,"notas"=>$notas,"pagos"=>$pagos]);
    }
	       public function obtmunicipio (Request $request){
            if($request->ajax()){
		if($request->get('pidmunicipio')== ""){ $id=$request->get('municipio'); }else{ $id=$request->get('pidmunicipio');}
      				
        $sectores=DB::table('parroquias')->select('id_parroquia as idsector','parroquia as nombre')->where('idmunicipio','=',$id)
        -> get();
         return response()->json($sectores);
     }     
      }
    public function store (PacientesFormRequest $request)
    {
		//dd($request);
        $paciente=new Pacientes;
        $paciente->nombre=$request->get('nombre');
        $paciente->cedula=$request->get('ccedula');
        $paciente->telefono=$request->get('telefono');
        $paciente->status='A';
        $paciente->direccion=$request->get('direccion');
        $paciente->licencia=$request->get('licencia');
        $paciente->diascre=$request->get('diascre');
        $paciente->contacto=$request->get('contacto');
        $paciente->tipo_cliente=$request->get('tipo_cliente');
        $paciente->tipo_precio=$request->get('precio');
		$paciente->idmunicipio=$request->get('municipio');
		$paciente->idsector=$request->get('idparro');
		$paciente->vendedor=$request->get('idvendedor');
		$paciente->ruta=$request->get('ruta');
		 $mytime=Carbon::now('America/Caracas');
		$paciente->creado=$mytime->toDateTimeString();
        $paciente->save();
        return Redirect::to('pacientes/paciente');

    }
	
	public function edit($historia)
	{
		$vendedor=DB::table('vendedores')->get();
		$municipios=DB::table('municipios')->get();
		 $datos=DB::table('clientes as c')
			-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->select('v.nombre as vendedor')
			-> where('c.id_cliente','=',$historia)
            ->first();
			$paciente=DB::table('clientes as c')
			-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->join('municipios as m','m.id_municipio','=','c.idmunicipio')
			->join('parroquias as p','p.id_parroquia','=','c.idsector')
			->select('c.*','m.id_municipio','p.id_parroquia','v.id_vendedor')
			-> where('c.id_cliente','=',$historia)
			->first();
			//dd($paciente);
		return view("pacientes.paciente.edit",["municipios"=>$municipios,"paciente"=>$paciente,"vendedores"=>$vendedor,"datos"=>$datos]);
	}
	public function update(PacientesFormRequest $request, $historia)
	{
      $paciente=Pacientes::findOrFail($historia);
        $paciente->nombre=$request->get('nombre');
        $paciente->cedula=$request->get('ccedula');
        $paciente->telefono=$request->get('telefono');
    	$paciente->direccion=$request->get('direccion');
		$paciente->licencia=$request->get('licencia');
		$paciente->diascre=$request->get('diascre');
		$paciente->contacto=$request->get('contacto');
    	$paciente->tipo_cliente=$request->get('tipo_cliente');
        $paciente->tipo_precio=$request->get('precio');
		$paciente->idmunicipio=$request->get('municipio');
		$paciente->idsector=$request->get('idparro');
		 $paciente->vendedor=$request->get('idvendedor');
		 $paciente->ruta=$request->get('ruta');
        $paciente->update();
        return Redirect::to('pacientes/paciente');
	}
	public function destroy()
	{
        $paciente=Pacientes::findOrFail($id_cliente);
        $paciente->status='I';
        $paciente->update();
        return Redirect::to('pacientes/paciente');
	}
            public function validar (Request $request){
            if($request->ajax()){
        $pacientes=DB::table('clientes')->where('cedula','=',$request->get('ccedula'))->get();
         // dd($municipios);
         return response()->json($pacientes);
     }
      
      }
             public function notasadm (Request $request){
        $paciente=new Notasadm;
        $paciente->tipo=$request->get('tipo');
        $paciente->idcliente=$request->get('idcliente');
        $paciente->descripcion=$request->get('descripcion');
        $paciente->referencia=$request->get('referencia');
        $paciente->monto=$request->get('monto');
		$mytime=Carbon::now('America/Caracas');
		$paciente->fecha=$mytime->toDateTimeString();
        $paciente->pendiente=$request->get('monto');
		$paciente->usuario=Auth::user()->name;
        $paciente->save();
        return Redirect::to('pacientes/paciente/'.$request->get('idcliente'));
     }
	 	          public function detalleventa (Request $request){
            if($request->ajax()){
				if ($request->get('tipo')== "FAC"){
        $detal=DB::table('recibos as r')
		->select('r.idrecibo','r.tiporecibo','r.idbanco','r.monto','r.recibido','r.referencia','r.fecha')
  //  ->join('monedas as m','m.idmoneda','=','r.idpago')
    ->where('r.idventa','=',$request->get('comprobante'))
				-> get(); }
				if ($request->get('tipo')== "N/D"){
        $detal=DB::table('recibos as r')
		->select('r.idrecibo','r.tiporecibo','r.idbanco','r.monto','r.recibido','r.referencia','r.fecha')
  //  ->join('monedas as m','m.idmoneda','=','r.idpago')
    ->where('r.idnota','=',$request->get('comprobante'))
				-> get(); }
         return response()->json($detal);
     }
      }
	 	          public function detallenc (Request $request){
            if($request->ajax()){
        $detal=DB::table('relacionnc as r')
		->join('mov_notas as m','m.id_mov','=','r.idmov')
		->select('m.tipodoc','m.iddoc','m.monto','m.user','m.fecha')
		->where('r.idnota','=',$request->get('comprobante'))
				-> get();
         return response()->json($detal); 
		 }
     }
       public function reporte(Request $request)
    {
        $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
			
            $cventas=DB::table('venta as v')            
             ->join ('clientes as c', 'c.id_cliente','=','v.idcliente')     
            -> select(DB::raw('count(v.idventa) as nventas'),DB::raw('avg(v.total_venta) as vpromedio'),DB::raw('sum(v.total_venta) as vendido'),DB::raw('sum(v.saldo) as pendiente'),'c.nombre')
            ->whereBetween('v.fecha_emi', [$query, $query2])
            ->groupby('v.idcliente')
			->OrderBy('nventas','desc')
            ->get();
			//dd($cventas);
		//	dd($cventas[0]->nombre);
			  $cventasm=DB::table('venta as v')            
             ->join ('clientes as c', 'c.id_cliente','=','v.idcliente')     
            -> select(DB::raw('count(v.idventa) as nventas'),DB::raw('avg(v.total_venta) as vpromedio'),DB::raw('sum(v.total_venta) as vendido'),DB::raw('sum(v.saldo) as pendiente'),'c.nombre')
            ->whereBetween('v.fecha_emi', [$query, $query2])
            ->groupby('v.idcliente')
			->OrderBy('vendido','desc')
            ->get();
			$clientes=DB::table('clientes')->get();
			$nclientes=count($clientes);			
			//dd($nclientes);
			$clientes2=DB::table('clientes')->whereBetween('creado', [$query, $query2])->get();
			$newclientes=count($clientes2);
			$vclientes=DB::table('clientes as cli')->join('venta as v','v.idcliente','=','cli.id_cliente')
			-> select(DB::raw('count(v.idventa) as nventas'),DB::raw('sum(v.total_venta) as vendido'),DB::raw('sum(v.saldo) as pendiente'),'cli.nombre')
			->whereBetween('cli.creado', [$query, $query2])
			->groupby('v.idcliente')
			->get();
			//dd($vclientes);
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.clientes.index',["clientes2"=>$clientes2,"vclientes"=>$vclientes,"newclientes"=>$newclientes,"nclientes"=>$nclientes,"datos"=>$cventas,"datosm"=>$cventasm,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
    }   
}
