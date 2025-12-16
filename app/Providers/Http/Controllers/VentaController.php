<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Recibo;
use sisventas\Venta;
use sisventas\Articulo;
use sisventas\Kardex;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\ventaFormRequest;
use DB;
use sisventas\Pacientes;
use sisventas\Movbanco;
use sisventas\DetalleVenta;
use Carbon\Carbon;
use response;
use Illuminate\Support\Collection;
use Auth;

class VentaController extends Controller
{
    public function __construct()
    {
     
    }
 public function index(Request $request)
    {
        if ($request)
        {
			   $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
            $ventas=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
            -> join ('detalle_venta as dv','v.idventa','=','dv.idventa')
            -> select ('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.devolu','v.estado','v.total_venta','v.user','ve.nombre as vendedor')
            -> where ('p.nombre','LIKE','%'.$query.'%')
            -> orwhere ('v.serie_comprobante','LIKE','%'.$query.'%')
            -> orderBy('v.idventa','desc')
            -> groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
                ->paginate(20);
     
     return view ('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query,"empresa"=>$empresa]);
        }
    } 
    public function create(){
		$monedas=DB::table('monedas')->get();
		$vendedor=DB::table('vendedores')->get();
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.diascre','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.id_vendedor as nombrev')-> where('clientes.status','=','A')->groupby('clientes.id_cliente')->get();
         $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->get();
      //dd($contador);
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2')
        -> where('art.estado','=','Activo')
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo')
        -> get();
		//dd($articulos);
     if ($contador==""){$contador=0;}
      return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos,"monedas"=>$monedas,"contador"=>$contador,"empresa"=>$empresa,"vendedores"=>$vendedor]);
    }
    public function store(ventaFormRequest $request){
		//dd($request);
		$user=Auth::user()->name;
   try{
   DB::beginTransaction();
   $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->first();
   if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}

//registra la venta
    $venta=new Venta;
	$idcliente=explode("_",$request->get('id_cliente'));
    $venta->idcliente=$idcliente[0];
    $venta->tipo_comprobante=$request->get('tipo_comprobante');
    $venta->serie_comprobante=$request->get('serie_comprobante');
    $venta->num_comprobante=($numero+1);
    $venta->total_venta=$request->get('total_venta');
    $mytime=Carbon::now('America/Caracas');
    $venta->fecha_hora=$mytime->toDateTimeString();
	$venta->fecha_emi=$request->get('fecha_emi');
    $venta->impuesto='16';
	if(empty($request->get('tdeuda'))){   $venta->saldo=$request->get('total_venta');}
	else { $venta->saldo=$request->get('tdeuda');}
    if ($venta->saldo > 0){
    $venta->estado='Credito';} else { $venta->estado='Contado';}
    $venta->devolu='0';
	 $venta->idvendedor=$request->get('nvendedor');
    $venta->diascre=$request->get('diascre');
    $venta->comision=$request->get('comision');
	$venta->montocomision=($request->get('total_venta')*($request->get('comision')/100));
	$venta->user=$user;
   $venta-> save();

    // inserta el recibo
          $idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $tref=$request->get('tref');		 
           $contp=0;
		   if($request->get('totala')>0){
              while($contp < count($idpago)){
				$recibo=new Recibo;
				$recibo->idventa=$venta->idventa;
				if($request->get('tdeuda')>0){
				$recibo->tiporecibo='A'; }else{$recibo->tiporecibo='P'; }
				$recibo->monto=$request->get('total_venta');
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idpago=$pago[0];
				$recibo->idnota=0;
				$recibo->idbanco=$idbanco[$contp];
				$recibo->recibido=$denomina[$contp];			
				$recibo->monto=$tmonto[$contp]; 
				$recibo->referencia=$tref[$contp];
				$recibo->tasap=$request->get('peso');
				$recibo->tasab=$request->get('tc');
				$recibo->aux=$request->get('tdeuda');
				$recibo->fecha=$mytime->toDateTimeString();		
				$recibo->usuario=$user;					
				$recibo->save();
		$mov=new Movbanco;
        $mov->idcaja=$pago[0];
		$mov->iddocumento=$recibo->idrecibo;
        $mov->tipo_mov="N/C";
		$mov->tipodoc="VENT";
        $mov->numero=$pago[0]."-".$request->get('serie_comprobante');
        $mov->concepto="Ingreso Ventas";
		$mov->tipo_per="C";
        $mov->idbeneficiario=$idcliente[0];
		$mov->identificacion=$idcliente[5];
        $mov->nombre=$idcliente[6];
        $mov->monto=$denomina[$contp]; 
		$mov->tasadolar=0;
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$mytime->toDateTimeString();
        $mov->user=Auth::user()->name;
        $mov->save();
				 $contp=$contp+1;
			  }  
		   }
		    
        $idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $descuento = $request -> get('descuento');
        $precio_venta = $request -> get('precio_venta');
        $costoarticulo = $request -> get('costoarticulo');

        $cont = 0;
            while($cont < count($idarticulo)){
            $detalle=new DetalleVenta();
            $detalle->idventa=$venta->idventa;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->costoarticulo=$costoarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->descuento=$descuento[$cont];
            $detalle->precio_venta=$precio_venta[$cont];
			 $detalle->fecha_emi=$mytime->toDateTimeString();	
            $detalle->save();
				$kar=new Kardex;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="VENT-".($numero+1);
		$kar->idarticulo=$idarticulo[$cont];
		$kar->cantidad=$cantidad[$cont];
		$kar->costo=$costoarticulo[$cont];
		$kar->tipo=2; 
		$kar->user=$user;
		 $kar->save();  
                      //actualizo stock   
        $articulo=Articulo::findOrFail($idarticulo[$cont]);
        $articulo->stock=$articulo->stock-$cantidad[$cont];
        $articulo->update();
            $cont=$cont+1;
            }
			
		$cli=Pacientes::findOrFail($idcliente[0]);
        $cli->ultventa=$mytime->toDateTimeString();
        $cli->update();
	DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}

  return Redirect::to('ventas/recibo/'.$venta->idventa);
}
public function show($id){

			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> select ('v.idventa','v.fecha_emi','p.nombre','p.cedula','p.licencia','p.telefono','p.ruta','p.direccion','p.contacto','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
            ->where ('v.idventa','=',$id)
            -> first();
            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.cantidad','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$id)
            -> where ('dv.cantidad','>',0)
            ->get();
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$id)
            ->get();
			$recibonc=DB::table('mov_notas as mov')-> where ('mov.iddoc','=',$id)-> where ('mov.tipodoc','=',"FAC")
            ->get();

            return view("ventas.venta.show",["venta"=>$venta,"recibos"=>$recibo,"recibonc"=>$recibonc,"empresa"=>$empresa,"detalles"=>$detalles]);
}
public function ver($id){
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> select ('v.idventa','v.fecha_emi','p.nombre','p.cedula','p.direccion','p.licencia','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
            ->where ('v.idventa','=',$id)
			   -> where ('dv.cantidad','>',0)
            -> first();
            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.cantidad','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$id)
            ->get();
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$id)
            ->get();
			$recibonc=DB::table('mov_notas as mov')-> where ('mov.iddoc','=',$id)-> where ('mov.tipodoc','=',"FAC")
            ->get();

            return view("ventas.venta.recibo",["venta"=>$venta,"recibos"=>$recibo,"recibonc"=>$recibonc,"empresa"=>$empresa,"detalles"=>$detalles]);
}
 public function edit($idcliente){
	     $monedas=DB::table('monedas')->get();
	     $vendedor=DB::table('vendedores')->get();
	     $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
         $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.nombre','clientes.cedula','clientes.diascre','clientes.tipo_cliente','vendedores.comision','vendedores.nombre as nombrev')
         -> where('status','=','A')
		 ->groupby('clientes.id_cliente')
         -> where ('id_cliente','=',$idcliente)
         ->get();
         $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->get();
      //dd($contador);
        $articulos =DB::table('articulo as art')
         -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2')
         -> where('art.estado','=','Activo')
         -> where ('art.stock','>','0')
         ->groupby('articulo','art.idarticulo','art.stock')
         -> get();
     return view("ventas.venta.create",["personas"=>$personas,"monedas"=>$monedas,"articulos"=>$articulos,"contador"=>$contador,"empresa"=>$empresa,"vendedores"=>$vendedor]);
 }

public function destroy($id){

    $venta=Venta::findOrFail($id);
    $venta->estado='C';
    $venta->update();
    return Redirect::to('ventas/venta');
}
public function devolucion(){
   $id=2;
   // $id=$request->get('id');
//dd($id);
    $venta=Venta::findOrFail($id);
    $venta->impuesto='16';
    $venta->update();
  return Redirect::to('ventas/venta');
}
 public function almacena(Request $request)
    {
		
     if($request->ajax()){
	
		 $paciente=new Pacientes;
        $paciente->nombre=$request->get('cnombre');
        $paciente->cedula=$request->get('ccedula');
        $paciente->telefono=$request->get('ctelefono');
        $paciente->status='A';
	 if($request->get('cdireccion')==""){
		 $paciente->direccion="Sin especificfar";
		}else{
		$paciente->direccion=$request->get('cdireccion');}
        $paciente->tipo_cliente=$request->get('ctipo_cliente');
        $paciente->tipo_precio=$request->get('cprecio');
        $paciente->licencia=$request->get('licencia');
        $paciente->diascre=$request->get('diascre');
		 $paciente->vendedor=$request->get('idvendedor');
		 $paciente->ruta=$request->get('ruta');
		  $mytime=Carbon::now('America/Caracas');
		$paciente->creado=$mytime->toDateTimeString();
        $paciente->save();
	// dd($paciente);
 $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.nombre','clientes.diascre','clientes.cedula','clientes.tipo_cliente','vendedores.comision','vendedores.id_vendedor as nombrev')-> where('clientes.cedula','=',$request->get('ccedula'))->get();
           return response()->json($personas);
 }
    }
	 public function ventacaja(Request $request)
    {
        if ($request)
        {
			$corteHoy = date("Y-m-d");
			$user=Auth::user()->name;
			   $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
            $ventas=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('detalle_venta as dv','v.idventa','=','dv.idventa')
            -> select ('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.devolu','v.estado','v.total_venta')		
			->where('v.user','=',$user)
			 ->where('v.fecha_emi','like',$corteHoy)
            -> where ('p.nombre','LIKE','%'.$query.'%')
            -> orderBy('v.idventa','desc')
            -> groupBy('v.idventa')
                ->paginate(50);
     return view ('ventas.venta.ventacaja',["ventas"=>$ventas,"searchText"=>$query,"empresa"=>$empresa]);
        }
    } 
	 public function refrescar(Request $request)
    {
		if($request->ajax()){
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2')
        -> where('art.estado','=','Activo')
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo')
        -> get();
           return response()->json($articulos);
		}
    }
}
