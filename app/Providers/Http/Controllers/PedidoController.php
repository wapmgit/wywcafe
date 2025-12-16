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
            -> select ('v.idventa','v.fecha_hora','p.nombre','v.pweb','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','ven.nombre as vendedor','v.devolu','v.estado','v.total_venta')		
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
			$articulo=Articulo::findOrFail($idarticulo[$cont]);
            $detalle->precio_venta=$precio_venta[$cont];
            $detalle->preciof=$articulo->precio2;
			 $detalle->fecha_emi=$mytime->toDateTimeString();	
            $detalle->save();
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
	
	     $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2')
        -> where('art.estado','=','Activo')
        ->groupby('articulo','art.idarticulo')
        -> get();
    $user=Auth::user()->name;
    $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $venta=DB::table('venta as v')
    -> join ('clientes as p','v.idcliente','=','p.id_cliente')
    -> select ('v.idventa','v.fecha_hora','p.nombre','p.cedula','p.direccion','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
    ->where ('v.idventa','=',$id)
    -> first();
    $detalles=DB::table('detalle_pedido as dv')
    -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
	->join('categoria as cat','cat.idcategoria','=','a.idcategoria')
    -> select('a.nombre as articulo','dv.cantidad','dv.descuento','dv.iddetalle_venta','a.idarticulo','dv.preciof','dv.precio_venta','a.costo','a.stock')
    -> where ('dv.idventa','=',$id)
	->orderby('cat.idcategoria','ASC')
    ->get();
    return view("pedido.venta.show",["articulos"=>$articulos,"venta"=>$venta,"empresa"=>$empresa,"detalles"=>$detalles]);
}
function facturar(Request $request){
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
            $kar=new Kardex;
    $kar->fecha=$mytime->toDateTimeString();
    $kar->documento="VENT-".$idventa;
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
        $actventa=Venta::findOrFail($idventa);
        $actventa->tipo_comprobante="FAC";
        $actventa->serie_comprobante=$serie;
        $actventa->fecha_emi=$fecha_emi;
        $actventa->fecha_hora=$mytime->toDateTimeString();
        $actventa->update();
		$cli=Pacientes::findOrFail($actventa->idcliente);
        $cli->ultventa=$mytime->toDateTimeString();
        $cli->update();
        return Redirect::to('/pedido/pedido');
}
	public function devolucion(Request $request){
	//dd($request);
		   try{
	DB::beginTransaction();
	$user=Auth::user()->name;
    $detalleventa=Detallepedido::findOrFail($request->iddetalle);
	$aux= $detalleventa->cantidad*$detalleventa->precio_venta;
	$aux2=$request -> get('cantidad')*$request -> get('precio');	
	$costo=$detalleventa->costoarticulo;
	$aux3=($detalleventa->preciof-$detalleventa->precio_venta)*$detalleventa->cantidad;
	$aux4=($request -> get('preciof') - $request -> get('precio'))*$request -> get('cantidad');

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
	$detalleventa->preciof=$request -> get('preciof');
	$detalleventa->update();
	
	$gadm=DB::table('detalle_pedido')->select('iddetalle_venta')
	->where('idventa','=',$request -> get('idventa'))
	->where('idarticulo','=',999999)
	->first();
	if(($gadm)<>NULL){	
    $actadm=Detallepedido::findOrFail($gadm->iddetalle_venta);
	$actadm->precio_venta=($actadm->precio_venta-$aux3)+$aux4;
	$actadm->update();
	}else{$aux3=0;}
	$venta2=Venta::findOrFail($request -> get('idventa'));
		$venta2->saldo=($venta->total_venta-$aux3)+$aux4;
		$venta2->total_venta=($venta->total_venta-$aux3)+$aux4;
		$venta2->montocomision=((($venta->total_venta-$aux3)+$aux4)*($venta->comision/100));
		$venta2->update();

 DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}
return Redirect::to('pedido/pedido');
}
	public function devolucionfac(Request $request){
	
	    try{
	DB::beginTransaction();
	$user=Auth::user()->name;
    $detalleventa=DetalleVenta::findOrFail($request->iddetalle);
	$idar=$detalleventa->idarticulo;
	$aux= $detalleventa->cantidad*$detalleventa->precio_venta;
	$nc=($detalleventa->cantidad-$request -> get('cantidad'));
	$aux2=$request -> get('cantidad')*$request -> get('precio');	
	$costo=$detalleventa->costoarticulo;
	
		$venta=Venta::findOrFail($request -> get('idventa'));
			$abono=$venta->total_venta-$venta->saldo;
			if($venta->total_venta>0){
		  	 $descuento=$venta->descuento;
			 $venta->total_venta=(($venta->total_venta-($aux+$descuento))+$aux2);
			$venta->total_pagar=0;	 
			 $venta->saldo=($venta->total_venta-$abono);
			$venta->montocomision=($venta->total_venta*($venta->comision/100));		
			
			$venta->update();	
			}
			$detalleventa->cantidad=$request -> get('cantidad');
			$detalleventa->precio_venta=$request -> get('precio');
			$detalleventa->update();
	
		$kar=new Kardex;
		$mytime=Carbon::now('America/Caracas');
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="DEVP-".$request -> get('idventa');
		$kar->idarticulo=$idar;
		$kar->cantidad=$nc;
		$kar->costo=$costo;
		$kar->tipo=1; 
		$kar->user=$user;
	
		 $kar->save();
	
 DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
} 
return Redirect::to('ventas/venta');
}

public function agregargastoadm(Request $request){
			$mytime=Carbon::now('America/Caracas');
	        $detalle=new Detallepedido();
			$detalle->idventa=$request->get('idped');
			$detalle->idarticulo=999999; 		
			$detalle->costoarticulo=0;
			$detalle->cantidad=1;
			$detalle->descuento=0;
			$detalle->precio_venta=$request->get('tadm');
			$detalle->preciof=0;
			$detalle->fecha_emi=$mytime->toDateTimeString();	
			$detalle->save();
				
		$venta=Venta::findOrFail($request->idped);
		$venta->total_venta=($venta->total_venta+$request->get('tadm'));
		$venta->saldo=($venta->total_venta+$request->get('tadm'));
		$venta->montocomision=($venta->total_venta*($venta->comision/100));
		$venta->update();
			   //dd($request);
			 return Redirect::to('pedido/pedido/'.$request->get('idped'));
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
	->join('categoria as cat','cat.idcategoria','=','a.idcategoria')
    -> select(DB::raw('sum(dv.cantidad) as cantidad'),'cl.vendedor','a.nombre as articulo','a.stock','dv.iddetalle_venta','a.idarticulo')
	->where('ve.tipo_comprobante','=',"PED")
	->where('cl.vendedor','=',$query)
	->where('ve.devolu','=',0)
	->where('cat.servicio','=',0)
	->where('a.estado','=',"Activo")
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
	->join('categoria as cat','cat.idcategoria','=','a.idcategoria')
    -> select(DB::raw('sum(dv.cantidad) as cantidad'),'a.nombre as articulo','a.stock','dv.iddetalle_venta','a.idarticulo')
	->where('ve.tipo_comprobante','=',"PED")
	->where('ve.devolu','=',0)
	->where('cat.servicio','=',0)
	->where('a.estado','=',"Activo")
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


public function addart(Request $request){	
		$kar=new Detallepedido;
		$mytime=Carbon::now('America/Caracas');
		$kar->fecha=$mytime->toDateTimeString();
		$kar->idventa=$request -> get('idventa');
		$kar->idarticulo=$request -> get('idarticulo');
		$kar->costoarticulo=$request -> get('pcostoarticulo');
		$kar->cantidad=$request -> get('pcantidad');
		$kar->precio_venta=$request -> get('pprecio_venta');
		$kar->preciof=$request -> get('pf');
		$kar->descuento=0;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->fecha_emi=$mytime->toDateTimeString();	
		$kar->save();
		$rg=($kar->cantidad*($kar->preciof-$kar->precio_venta));
		$nvv=(($kar->cantidad*$kar->precio_venta)+$rg);
		$gasto=DB::table('detalle_pedido')
		-> where('idventa','=',$request -> get('idventa'))
		-> where('idarticulo','=',999999)
		->first();		
		if(($gasto)<>NULL){	
		$dp=Detallepedido::findOrFail($gasto->iddetalle_venta);
		$dp->precio_venta=($dp->precio_venta+$rg);	
		$dp->update();
		}
	
		$venta=Venta::findOrFail($request->idventa);
		$venta->total_venta=($venta->total_venta+$nvv);
		$venta->saldo=($venta->total_venta+$nvv);
		$venta->montocomision=($venta->total_venta*($venta->comision/100));
		$venta->update();
  return Redirect::to('pedido/pedido/'.$request -> get('idventa'));
}
}
