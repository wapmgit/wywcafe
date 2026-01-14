<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Pacientes;
use sisventas\Vendedores;
use sisventas\Notasadm;
use sisventas\Venta;
use sisventas\DetalleVenta;
use sisventas\Movbanco;
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
		$ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		if ($request)
		{
			$rol=DB::table('roles')-> select('newcliente','editcliente','edocta','crearventa','web','actcliente')->where('iduser','=',$request->user()->id)->first();
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$query=trim($request->get('searchText'));
			$pacientes=DB::table('clientes')->where('clientes.nombre','LIKE','%'.$query.'%')
			->join('vendedores as ven','ven.id_vendedor','=','clientes.vendedor')
			->select('clientes.id_cliente','clientes.status','clientes.nombre','clientes.telefono','clientes.cedula','clientes.direccion','ven.nombre as vendedor')
			->where('clientes.idempresa','=',$ide)
			->orderBy('clientes.id_cliente','desc')
			->paginate(50);
			return view('pacientes.paciente.index',["rol"=>$rol,"pacientes"=>$pacientes,"empresa"=>$empresa,"searchText"=>$query]);
		}
	}
	public function create(Request $request)
	{
		$ide=Auth::user()->idempresa;
		$vendedor=DB::table('vendedores')-> where('idempresa','=',$ide)->where('estatus','=',1)->get();
		$municipios=DB::table('municipios')->get();
		$categoria=DB::table('categoriaclientes')->get();
		$rutas=DB::table('rutas')->where('idempresa','=',$ide)->get();
		return view("pacientes.paciente.create",["rutas"=>$rutas,"vendedores"=>$vendedor,"municipios"=>$municipios,"categoria"=>$categoria]);
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
			->select('venta.mret','venta.tipo_comprobante','venta.num_comprobante','venta.serie_comprobante','venta.total_venta','venta.total_pagar','venta.fecha_hora','venta.comision','venta.descuento','venta.saldo','venta.devolu','venta.estado','venta.idventa')
				->where('venta.idcliente','=',$id)
				->orderBy('venta.idventa','desc')
				->groupBy('venta.idventa')
				->get();
				//recibos
		  $pagos=DB::table('recibos as re')
				  ->join('venta as v','v.idventa','=','re.idventa')
				  ->join('clientes as cli','cli.id_cliente','=','v.idcliente')
         -> select('v.idventa','re.idrecibo','re.monto','re.recibido','re.idbanco','re.idpago','v.tipo_comprobante','v.num_comprobante','re.fecha')
		 -> where('v.idcliente','=',$id)
            ->get(); 
			$notas=DB::table('notasadm')->where('notasadm.idcliente','=',$id)->get();
				$retencion=DB::table('retencionventas')->where('idcliente','=',$id)->get();
				 $monedas=DB::table('monedas')->get();
        return view("pacientes.paciente.show",["cliente"=>$pacientes,"ventas"=>$ventas,"notas"=>$notas,"pagos"=>$pagos,"retencion"=>$retencion,"monedas"=>$monedas]);
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
		$ide=Auth::user()->idempresa;
        $paciente=new Pacientes;
        $paciente->idempresa=$ide;
        $paciente->nombre=$request->get('nombre');
        $paciente->cedula=$request->get('ccedula');
		$paciente->codpais=$request->get('codpais');
        $paciente->telefono=$request->get('telefono');
        $paciente->status='A';
        $paciente->direccion=$request->get('direccion');
        $paciente->licencia=$request->get('licencia');
		 $paciente->categoria=$request->get('categoria');
        $paciente->diascre=$request->get('diascre');
		 $paciente->recargo=$request->get('recargo');
        $paciente->contacto=$request->get('contacto');
        $paciente->tipo_cliente=$request->get('tipo_cliente');
		if($request->get('agente')==1){
		$paciente->retencion=$request->get('retencion');
		}
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
	
	public function edit(Request $request, $historia)
	{
		$ide=Auth::user()->idempresa;
		$vendedor=DB::table('vendedores')->where('estatus','=',1)->where('idempresa','=',$ide)->get();
		$municipios=DB::table('municipios')->get();
		$rutas=DB::table('rutas')->where('idempresa','=',$ide)->get();
		$parroquias=DB::table('parroquias')->get();
		$categoria=DB::table('categoriaclientes')->get();
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
		return view("pacientes.paciente.edit",["rutas"=>$rutas,"categoria"=>$categoria,"parroquias"=>$parroquias,"municipios"=>$municipios,"paciente"=>$paciente,"vendedores"=>$vendedor,"datos"=>$datos]);
	}
	public function update(PacientesFormRequest $request, $historia)
	{
      $paciente=Pacientes::findOrFail($historia);
        $paciente->nombre=$request->get('nombre');
        $paciente->cedula=$request->get('ccedula');
		$paciente->codpais=$request->get('codpais');
        $paciente->telefono=$request->get('telefono');
    	$paciente->direccion=$request->get('direccion');
		$paciente->licencia=$request->get('licencia');
		$paciente->categoria=$request->get('categoria');
		$paciente->diascre=$request->get('diascre');
		$paciente->recargo=$request->get('recargo');
		$paciente->contacto=$request->get('contacto');
    	$paciente->tipo_cliente=$request->get('tipo_cliente');
		if($request->get('agente')==1){
		$paciente->retencion=$request->get('retencion');
		}
        $paciente->tipo_precio=$request->get('precio');
		$paciente->idmunicipio=$request->get('municipio');
		$paciente->idsector=$request->get('idparro');
		 $paciente->vendedor=$request->get('idvendedor');
		 $paciente->ruta=$request->get('ruta');
        $paciente->update();
        return Redirect::to('pacientes/paciente');
	}
	public function destroy(Request $request)
	{
		//dd($request->tipo);
        $paciente=Pacientes::findOrFail($request->id);
		if($request->tipo==1){
        $paciente->status='A';}
		else{ $paciente->status='I';}
        $paciente->update();
        return Redirect::to('pacientes/paciente');
	}
            public function validar (Request $request){
				$ide=Auth::user()->idempresa;
            if($request->ajax()){
        $pacientes=DB::table('clientes')->where('clientes.idempresa','=',$ide)->where('cedula','=',$request->get('ccedula'))->get();
         // dd($municipios);
         return response()->json($pacientes);
     }
      
      }
	public function notasadm (Request $request){
		
		$ide=Auth::user()->idempresa;
		$contador=DB::table('notasadm')->select(DB::raw('count(idnota) as idventa'))-> where('idempresa','=',$ide)->limit('1')->orderby('idnota','desc')->first();
		if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}

        $paciente=new Notasadm;
        $paciente->idempresa=$ide;
        $paciente->numnota=$numero+1;
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
				if($request->get('nc')){		
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$client=DB::table('clientes')->where('clientes.idempresa','=',$ide)-> where('id_cliente','=',$request->get('idcliente'))->first();
				$moneda=explode("_",$request->get('pidpago'));
				$tipo=$moneda[0];
				$banco=$moneda[1];
				if($tipo>0){ $ingreso=$request->get('montoban');}else{$ingreso=$request->get('monto');}
			$mov=new Movbanco;
			$mov->idempresa=$ide;
			$mov->idcaja=$banco;
			$mov->tipo_mov="N/C";
			$mov->numero=$request->get('referencia');
			$mov->concepto=$request->get('descripcion');
			$mov->tipo_per=$tipo;
			$mov->idbeneficiario=$client->id_cliente;
			$mov->identificacion=$client->cedula;
			$mov->nombre=$client->nombre;
			$mov->monto=$ingreso;
			$mov->tasadolar=$empresa->tasa_banco;
			$mytime=Carbon::now('America/Caracas');
			$mov->fecha_mov=$mytime->toDateTimeString();
			$mov->user=Auth::user()->name;
			$mov->save();
		}
        return Redirect::to('pacientes/paciente/'.$request->get('idcliente'));
     }
		public function detalleventa (Request $request){
		$ide=Auth::user()->idempresa;
            if($request->ajax()){
				if ($request->get('tipo')== "FAC"){
        $detal=DB::table('recibos as r')
		->select('r.idrecibo','r.tiporecibo','r.idbanco','r.monto','r.recibido','r.referencia','r.fecha')
		->where('r.idempresa','=',$ide)
		->where('r.idventa','=',$request->get('comprobante'))
				-> get(); }
				if ($request->get('tipo')== "N/D"){
        $detal=DB::table('recibos as r')
		->select('r.idrecibo','r.tiporecibo','r.idbanco','r.monto','r.recibido','r.referencia','r.fecha')
		->where('r.idempresa','=',$ide)
		->where('r.idnota','=',$request->get('comprobante'))
				-> get(); }
         return response()->json($detal);
     }
      }
	public function detallenc (Request $request){
		$ide=Auth::user()->idempresa;
            if($request->ajax()){
        $detal=DB::table('relacionnc as r')
		->join('mov_notas as m','m.id_mov','=','r.idmov')
		->select('m.tipodoc','m.iddoc','m.monto','m.user','m.fecha')
		->where('r.idempresa','=',$ide)
		->where('r.idnota','=',$request->get('comprobante'))
				-> get();
         return response()->json($detal); 
		 }
     }
       public function reporte(Request $request)
    {
		$ide=Auth::user()->idempresa;
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
			->where('v.idempresa','=',$ide)           
		   ->whereBetween('v.fecha_emi', [$query, $query2])
            ->groupby('v.idcliente')
			->OrderBy('nventas','desc')
            ->get();
			//dd($cventas);
		//	dd($cventas[0]->nombre);
			  $cventasm=DB::table('venta as v')            
             ->join ('clientes as c', 'c.id_cliente','=','v.idcliente')     
            -> select(DB::raw('count(v.idventa) as nventas'),DB::raw('avg(v.total_venta) as vpromedio'),DB::raw('sum(v.total_venta) as vendido'),DB::raw('sum(v.saldo) as pendiente'),'c.nombre')
            	->where('v.idempresa','=',$ide)
			->whereBetween('v.fecha_emi', [$query, $query2])
            ->groupby('v.idcliente')
			->OrderBy('vendido','desc')
            ->get();
			$clientes=DB::table('clientes')	->where('idempresa','=',$ide)->get();
			$nclientes=count($clientes);			
			//dd($nclientes);
			$clientes2=DB::table('clientes')->where('idempresa','=',$ide)->whereBetween('creado', [$query, $query2])->get();
			$newclientes=count($clientes2);
			$vclientes=DB::table('clientes as cli')->join('venta as v','v.idcliente','=','cli.id_cliente')
			-> select(DB::raw('count(v.idventa) as nventas'),DB::raw('sum(v.total_venta) as vendido'),DB::raw('sum(v.saldo) as pendiente'),'cli.nombre')
			->where('cli.idempresa','=',$ide)
			->whereBetween('cli.creado', [$query, $query2])
			->groupby('v.idcliente')
			->get();
			//dd($vclientes);
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.clientes.index',["clientes2"=>$clientes2,"vclientes"=>$vclientes,"newclientes"=>$newclientes,"nclientes"=>$nclientes,"datos"=>$cventas,"datosm"=>$cventasm,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
    }   
		public function detanota (Request $request, $var){
			
		
			 $ide=Auth::user()->idempresa;
		  $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
        $nota=DB::table('notasadm as no')
		->join('clientes as cl','cl.id_cliente','=','no.idcliente')
		->where('no.idempresa','=',$ide)
		->where('no.idnota','=',$var)
		->first();	
		$tipo=$nota->tipo;
		if($tipo==1){
			$pagos=DB::table('recibos as re')
			-> where ('re.idnota','=',$nota->idnota)
            ->get();
				$pndconnc=DB::table('mov_notas')
			->where('tipodoc','=',"N/D")
			->where('iddoc','=',$nota->idnota)
			->get();
		}else{
			$pagos=DB::table('relacionnc as re')
			->join('mov_notas as mn','mn.id_mov','=','re.idmov')
			->where('re.idnota','=',$nota->idnota)
			->get();
					$pndconnc=DB::table('mov_notas')
			->where('tipodoc','=',"N/C")
			->where('iddoc','=',$nota->idnota)
			->get();
		}
	
		return view('pacientes.paciente.detallenota',["datond"=>$pndconnc,"tipo"=>$tipo,"pagos"=>$pagos,"nota"=>$nota,"empresa"=>$empresa]);
      }
    public function notac (Request $request){
				$idcliente=explode("_",$request->get('id_cliente'));
				$aux=$idcliente[0];
            if($request->ajax()){
			$q2=DB::table('notasadm as n')
			->join('clientes as c','c.id_cliente','=','n.idcliente')
			->select(DB::raw('sum(n.pendiente) as saldo'))
			->where('n.idcliente','=',$aux)
			->where('n.tipo','=',2)
			->where('n.pendiente','>',0)
			->groupby('n.idcliente')
			->get();
			 $datov=DB::table('venta as v')
        ->select(DB::raw('SUM(v.saldo) as monto' ),'v.idcliente')
        ->where('v.idcliente','=',$aux)
        ->where('v.tipo_comprobante','=',"FAC")
         ->groupby('v.idcliente')
        -> get();
				$corteHoy = date("Y-m-d");
		$credito=DB::table('venta')
		->select(DB::raw('DATEDIFF(date_format( curdate( ) , "%y%m%d" ), fecha_emi) as dias'),'diascre')
		->where('tipo_comprobante','=',"FAC")->where('devolu','=',0)->where('saldo','>',0)
		->where('idcliente','=',$aux)
		->orderby('fecha_emi','asc')
		->limit(1)
		->get();
         return response()->json([$q2,$datov,$credito]); 
		 }
     }
	 	public function retencion ($id){
		//dd($id);
			$ret=DB::table('retencionventas as ret')
			->join('ventaf as v','v.pedido','=','ret.idfactura')
			->join('clientes as cli','cli.id_cliente','=','v.idcliente')
			->join('formalibre as fl','fl.idventa','=','v.idventa')
			->where('ret.idret','=',$id)
			->first();
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
return view('pacientes.paciente.retencion',["ret"=>$ret,"empresa"=>$empresa]);
     }
	 	 	public function anularnota ($id){
	
		$not=Notasadm::findOrFail($id);
        $not->pendiente=0;
        $not->descripcion=$not->descripcion." Anulado";
		$not->update();
		
    return Redirect::to('pacientes/paciente/'.$not->idcliente);
     }
	 	public function listaclientes (Request $request){
			$ide=Auth::user()->idempresa;
			$cat=trim($request->get('categoria'));
             $vend=trim($request->get('vendedor'));
             $ruta=trim($request->get('ruta'));
			 $catclientes=DB::table('categoriaclientes')->get();
			 $vendedores=DB::table('vendedores')->where('idempresa','=',$ide)->where('estatus','=',1)->get();
			 $rutas=DB::table('rutas')->where('idempresa','=',$ide)->get();
			 $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
				
			if($ruta==0){ $condi=">";$que=0;} else { $condi="=";$que=$ruta;}
		$data=DB::table('clientes as cli')
			->join('categoriaclientes as cat','cat.idcategoria','=','cli.categoria')
			->join('vendedores as vnd','vnd.id_vendedor','=','cli.vendedor')
			->where('cli.idempresa','=',$ide)
			->where('cli.status','=',"A")
			->select('cli.*','vnd.nombre as vendedor','cat.nombrecategoria')
			->get();
		if(($cat==0) and($vend<>0)){
			$data=DB::table('clientes as cli')
			->join('categoriaclientes as cat','cat.idcategoria','=','cli.categoria')
			->join('vendedores as vnd','vnd.id_vendedor','=','cli.vendedor')
			->where('cli.idempresa','=',$ide)
			->where('cli.vendedor','=',$vend)
			->where('cli.ruta',$condi,$que)
			->where('cli.status','=',"A")
			->select('cli.*','vnd.nombre as vendedor','cat.nombrecategoria')
			->get();
		}
		if(($cat<>0) and($vend==0)){
			$data=DB::table('clientes as cli')
			->join('categoriaclientes as cat','cat.idcategoria','=','cli.categoria')
			->join('vendedores as vnd','vnd.id_vendedor','=','cli.vendedor')
			->where('cli.idempresa','=',$ide)
			->where('cli.categoria','=',$cat)
			->where('cli.ruta',$condi,$que)
			->where('cli.status','=',"A")
			->select('cli.*','vnd.nombre as vendedor','cat.nombrecategoria')
			->get();
		}
		if(($cat>0) and($vend>0)){
			$data=DB::table('clientes as cli')
			->join('categoriaclientes as cat','cat.idcategoria','=','cli.categoria')
			->join('vendedores as vnd','vnd.id_vendedor','=','cli.vendedor')
			->where('cli.idempresa','=',$ide)
			->where('cli.vendedor','=',$vend)
			->where('cli.categoria','=',$cat)
			->where('cli.ruta',$condi,$que)
			->where('cli.status','=',"A")
			->select('cli.*','vnd.nombre as vendedor','cat.nombrecategoria')
			->get();
		}
	return view('reportes.listaclientes.index',["rutas"=>$rutas,"vendedores"=>$vendedores,"catclientes"=>$catclientes,"data"=>$data,"empresa"=>$empresa,"searchText"=>$cat,"searchText2"=>$vend]);
     }
	 	 	 	public function actfecha (Request $request){
	//dd($request);
		$not=Venta::findOrFail($request->get('ventafecha'));
        $not->fecha_emi=$request->get('fechadespacho');
		$not->update();
		$detalles=DB::table('detalle_venta as da')
            -> where ('da.idventa','=',$request->get('ventafecha'))
            ->get();
		$longitud = count($detalles);
		$array = array();
			foreach($detalles as $t){
			$arraycod[] = $t->iddetalle_venta;
			$arrayid[] = $t->idventa;
			}
	for ($i=0;$i<$longitud;$i++){
	   $det=DetalleVenta::findOrFail($arraycod[$i]);
        $det->fecha_emi=$request->get('fechadespacho');
		$det->update();
	}
		
    return Redirect::to('pacientes/paciente/'.$not->idcliente);
     }
}
