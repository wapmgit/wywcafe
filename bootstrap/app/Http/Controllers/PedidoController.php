<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Venta;
use sisventas\Articulo;
use sisventas\Kardex;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\ventaFormRequest;
use DB;
use sisventas\Pacientes;
use sisventas\DetalleVenta;
use sisventas\Detallepedido;
use Carbon\Carbon;
use response;
use Illuminate\Support\Collection;
use Auth;
class PedidoController extends Controller
{
	  public function __construct()
    {
     
    }
     public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $ventas=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('vendedores as ven','ven.id_vendedor','=','v.idvendedor')
            -> select ('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','ven.nombre as vendedor','v.devolu','v.estado','v.total_venta')		
            -> where ('ven.nombre','LIKE','%'.$query.'%')
			-> where ('v.tipo_comprobante','=',"PED")
			-> where ('v.devolu','=',0)
            -> orderBy('v.idventa','desc')
            -> groupBy('v.idventa')
            ->paginate(10);
    //dd($ventas);
     return view ('pedido.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
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
        ->groupby('articulo','art.idarticulo')
        -> get();
		//dd($articulos);
     if ($contador==""){$contador=0;}
      return view("pedido.venta.create",["personas"=>$personas,"articulos"=>$articulos,"monedas"=>$monedas,"contador"=>$contador,"empresa"=>$empresa,"vendedores"=>$vendedor]);
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
        $idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $descuento = $request -> get('descuento');
        $precio_venta = $request -> get('precio_venta');
        $costoarticulo = $request -> get('costoarticulo');

        $cont = 0;
            while($cont < count($idarticulo)){
            $detalle=new Detallepedido();
            $detalle->idventa=$venta->idventa;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->costoarticulo=$costoarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->descuento=$descuento[$cont];
            $detalle->precio_venta=$precio_venta[$cont];
			 $detalle->fecha_emi=$mytime->toDateTimeString();	
            $detalle->save();
                      //actualizo stock   
            $cont=$cont+1;
            }
	DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}

  return Redirect::to('pedido/pedido');
}
public function show($id){
    $user=Auth::user()->name;
    $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $venta=DB::table('venta as v')
    -> join ('clientes as p','v.idcliente','=','p.id_cliente')
    -> select ('v.idventa','v.fecha_hora','p.nombre','p.cedula','p.direccion','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
    ->where ('v.idventa','=',$id)
    -> first();
    $detalles=DB::table('detalle_pedido as dv')
    -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
    -> select('a.nombre as articulo','dv.cantidad','dv.descuento','dv.iddetalle_venta','a.idarticulo','dv.precio_venta','a.costo','a.stock')
    -> where ('dv.idventa','=',$id)
    ->get();
    return view("pedido.venta.show",["venta"=>$venta,"empresa"=>$empresa,"detalles"=>$detalles]);
}
function facturar(Request $request){
	try{
    DB::beginTransaction(); 
    $user=Auth::user()->name;
    $idarticulo = $request -> get('idarticulo');
    $cantidad = $request -> get('cantidad');
    $precio_venta = $request -> get('precio');
    $costoarticulo = $request -> get('costo');
    $descuento = $request -> get('descuento');
    $idventa = $request->get('idventa');
	 $fecha_emi = $request->get('fecha_emi');
	 $serie = $request->get('serie_comprobante');
	 
    $mytime=Carbon::now('America/Caracas');
    $cont = 0;
        while($cont < count($idarticulo)){
        $detalle=new DetalleVenta();
        $detalle->idventa=$idventa;
        $detalle->idarticulo=$idarticulo[$cont];
        $detalle->costoarticulo=$costoarticulo[$cont];
        $detalle->cantidad=$cantidad[$cont];
        $detalle->descuento=$descuento[$cont];
        $detalle->precio_venta=$precio_venta[$cont];
         $detalle->fecha=$mytime->toDateTimeString();	
         $detalle->fecha_emi=$fecha_emi;	
        $detalle->save();             
		
		//actualizo stock   
    $articulo=Articulo::findOrFail($idarticulo[$cont]);
    $articulo->stock=$articulo->stock-$cantidad[$cont];
    $articulo->update();
       
    $kar=new Kardex;
    $kar->fecha=$mytime->toDateTimeString();
    $kar->documento="VENT-".$idventa;
    $kar->idarticulo=$idarticulo[$cont];
    $kar->cantidad=$cantidad[$cont];
	$kar->exis_ant=$articulo->stock;
    $kar->costo=$costoarticulo[$cont];
    $kar->tipo=2; 
    $kar->user=$user;
    $kar->save(); 
	
		$cont=$cont+1;
        }
        $actventa=Venta::findOrFail($idventa);
        $actventa->tipo_comprobante="FAC";
        $actventa->serie_comprobante=$serie;
        $actventa->fecha_emi=$fecha_emi;
        $actventa->fecha_hora=$mytime->toDateTimeString();
        $actventa->update();

	DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
} 
        return Redirect::to('/pedido/pedido');
}
	public function devolucion(Request $request){
	
		   try{
	DB::beginTransaction();
	$user=Auth::user()->name;
    $detalleventa=Detallepedido::findOrFail($request->iddetalle);
	$aux= $detalleventa->cantidad*$detalleventa->precio_venta;
	$aux2=$request -> get('cantidad')*$request -> get('precio');	
	$costo=$detalleventa->costoarticulo;

		$venta=Venta::findOrFail($request -> get('idventa'));
			if($venta->total_venta>0){
		  	 $descuento=($venta->descuento);
			 $venta->total_venta=(($venta->total_venta-($aux+$descuento))+$aux2);
			$venta->total_pagar=0;	 
			 $venta->saldo=(($venta->total_venta-($aux+$descuento))+$aux2);
			$venta->montocomision=($venta->total_venta*($venta->comision/100));
			$venta->update();	}
	$detalleventa->cantidad=$request -> get('cantidad');
	$detalleventa->precio_venta=$request -> get('precio');
	$detalleventa->update();

 DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}
return Redirect::to('pedido/pedido');
}
	public function devolucionfac(Request $request){
		dd($request);
//	try{
	//DB::beginTransaction();
	$user=Auth::user()->name;
    $detalleventa=DetalleVenta::findOrFail($request->iddetalle);
	$aux= $detalleventa->cantidad*$detalleventa->precio_venta;
	$aux2=$request -> get('cantidad')*$request -> get('precio');	
	$costo=$detalleventa->costoarticulo;
	
		$venta=Venta::findOrFail($request -> get('idventa'));
			if($venta->total_venta>0){
		  	 $descuento=($venta->descuento);
			 $venta->total_venta=(($venta->total_venta-($aux+$descuento))+$aux2);
			$venta->total_pagar=0;	 
			 $venta->saldo=(($venta->total_venta-($aux+$descuento))+$aux2);
			$venta->montocomision=($venta->total_venta*($venta->comision/100));
			$venta->update();	}
	$detalleventa->cantidad=$request -> get('cantidad');
	$detalleventa->precio_venta=$request -> get('precio');
	$detalleventa->update();
/*	
 DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
} */
return Redirect::to('ventas/venta');
}
public function destruir(Request $request){
      // dd($request);
			 $venta=Venta::findOrFail($request->get('venta'));
			 $venta->devolu=1;	
			 $venta->montocomision=0;	
             $venta->update();
			 return Redirect::to('pedido/pedido');
}
public function reporte(Request $request){
if ($request->get('idvendedor'))
        {
			
	$query=trim($request->get('idvendedor'));
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
	$vendedor=DB::table('vendedores')->get();
	$detalles=DB::table('detalle_pedido as dv')
	->join('venta as ve','ve.idventa','=','dv.idventa')
	->join('clientes as cl','ve.idcliente','=','cl.id_cliente')
    -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
    -> select(DB::raw('sum(dv.cantidad) as cantidad'),'cl.vendedor','a.nombre as articulo','a.stock','dv.iddetalle_venta','a.idarticulo')
	->where('ve.tipo_comprobante','=',"PED")
	->where('cl.vendedor','=',$query)
	->where('ve.devolu','=',0)
	->groupby('dv.idarticulo')
    ->get();
	$ven=DB::table('vendedores')-> where('id_vendedor','=',$query)->first();
	$query=$ven->nombre;
	$valida=1;
		}else{
		$query=trim($request->get('idvendedor'));
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
	$vendedor=DB::table('vendedores')->get();
	$detalles=DB::table('detalle_pedido as dv')
	->join('venta as ve','ve.idventa','=','dv.idventa')
    -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
    -> select(DB::raw('sum(dv.cantidad) as cantidad'),'a.nombre as articulo','a.stock','dv.iddetalle_venta','a.idarticulo')
	->where('ve.tipo_comprobante','=',"PED")
	->where('ve.devolu','=',0)
	->groupby('dv.idarticulo')
    ->get();		
	$query="Todos Vendedores";
	$valida=0;
		}
	     return view ('pedido/reporte/index',["valida"=>$valida,"vendedor"=>$vendedor,"ventas"=>$detalles,"searchText"=>$query,"empresa"=>$empresa]);
}
public function ajuste($id){
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
  	$var=explode("_",$id);

	$detalles=DB::table('detalle_pedido as dv')
	->join('venta as ve','ve.idventa','=','dv.idventa')
	->join('clientes as cl','ve.idcliente','=','cl.id_cliente')
    -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
    -> select('ve.idventa','cl.nombre','a.nombre as articulo','dv.cantidad','cl.vendedor','dv.iddetalle_venta','dv.idarticulo')
	->where('ve.tipo_comprobante','=',"PED")
	->where('cl.vendedor','=',$var[1])
	->where('ve.devolu','=',0)
	->where('dv.idarticulo','=',$var[0])
    ->get();	
	//dd($detalles);
 return view ('pedido/reporte/ajuste',["detalles"=>$detalles,"empresa"=>$empresa]);
}
	public function devolucionpedido(Request $request){
	//	dd($request);
		
        try{
	DB::beginTransaction();
	$user=Auth::user()->name;
    $detalleventa=Detallepedido::findOrFail($request->iddetalle);
	$aux= $detalleventa->cantidad*$detalleventa->precio_venta;
	$aux2=$request->cantidad*$detalleventa->precio_venta;
	$costo=$detalleventa->costoarticulo;
		$venta=Venta::findOrFail($request->idventa);
			if($venta->total_venta>0){
		  	  $descuento=($venta->descuento);
			  $venta->total_venta=($venta->total_venta-($aux2+$descuento));
			  $venta->total_pagar=0;	  
	  }else{
	  $venta->total_venta=($venta->total_venta-($aux2));
	  $venta->total_pagar=($venta->total_pagar-($aux2));}
	  $venta->saldo=($venta->saldo-($aux2));
	  $venta->montocomision=($venta->total_venta*($venta->comision/100));
	  $venta->update();	
	$detalleventa->cantidad=($detalleventa->cantidad-$request->cantidad);
	$detalleventa->update();
 DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}
  return Redirect::to('pedido/reporte/reporte?idvendedor='.$request->get('vendedor'));
}
}
