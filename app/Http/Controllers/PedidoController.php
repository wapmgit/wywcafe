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
use sisventas\Existencia;
use sisventas\DetalleVenta;
use sisventas\Detallepedido;
use Carbon\Carbon;
use response;
use Illuminate\Support\Collection;
use Auth;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class PedidoController extends Controller
{
	  public function __construct()
    {
     function truncar($numero, $digitos)
{
    $truncar = 10**$digitos;
    return intval($numero * $truncar) / $truncar;
}
    }
     public function index(Request $request)
    {
        if ($request)
        {
			$ide=Auth::user()->idempresa;
			$rol=DB::table('roles')-> select('crearpedido','anularpedido','importarpedido')->where('iduser','=',$request->user()->id)->first();
            $query=trim($request->get('searchText'));
            $ventas=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('vendedores as ven','ven.id_vendedor','=','v.idvendedor')
            -> select ('v.idventa','v.fecha_hora','p.nombre','v.pweb','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','ven.nombre as vendedor','v.devolu','v.estado','v.total_venta')		
			-> where ('p.nombre','LIKE','%'.$query.'%')
			-> where('v.idempresa','=',$ide)
			-> where ('v.tipo_comprobante','=',"PED")
			-> where ('v.devolu','=',0)
            -> orderBy('v.idventa','desc')
            -> groupBy('v.idventa')
            ->paginate(25);
    //dd($ventas);
     return view ('pedido.venta.index',["rol"=>$rol,"ventas"=>$ventas,"searchText"=>$query]);
        }
    } 
    public function create(Request $request){
		$ide=Auth::user()->idempresa;
		$rutas=DB::table('rutas')-> where('idempresa','=',$ide)->get();
		$monedas=DB::table('monedas')-> where('idempresa','=',$ide)->get();
		$vendedor=DB::table('vendedores')-> where('idempresa','=',$ide)->where('estatus','=',1)->get();
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
        $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')
		->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.diascre','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.id_vendedor as nombrev')
		-> where('clientes.idempresa','=',$ide)
		-> where('clientes.status','=','A')
		->groupby('clientes.id_cliente')->get();
         $contador=DB::table('venta')->select('idventa')-> where('idempresa','=',$ide)->limit('1')->orderby('idventa','desc')->get();
      //dd($contador);
       $articulos =DB::table('articulo as art')->join('categoria','categoria.idcategoria','=','art.idcategoria')
          -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2','art.iva','categoria.licor')
        -> where('art.idempresa','=',$ide)
		-> where('art.estado','=','Activo')
        ->groupby('articulo','art.idarticulo')
        -> get();
		//dd($articulos);
     if ($contador==""){$contador=0;}
      return view("pedido.venta.create",["rutas"=>$rutas,"personas"=>$personas,"articulos"=>$articulos,"monedas"=>$monedas,"contador"=>$contador,"empresa"=>$empresa,"vendedores"=>$vendedor]);
    }
	    public function store(ventaFormRequest $request){
	$ide=Auth::user()->idempresa;
		$user=Auth::user()->name;
   try{
   DB::beginTransaction();
   $contador=DB::table('venta')->select('idventa')-> where('idempresa','=',$ide)->limit('1')->orderby('idventa','desc')->first();
   if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}

//registra la venta
    $venta=new Venta;
	$idcliente=explode("_",$request->get('id_cliente'));
    $venta->idempresa=$ide;
    $venta->idcliente=$idcliente[0];
    $venta->tipo_comprobante=$request->get('tipo_comprobante');
    $venta->serie_comprobante=$request->get('serie_comprobante');
    $venta->num_comprobante=($numero+1);
    $venta->total_venta=$request->get('total_venta');
    $venta->total_iva=$request->get('total_iva');
    $venta->mivaf=$request->get('total_ivaf');
    $venta->texe=$request->get('totalexe');
    $venta->mcosto=$request->get('totalc');
    $mytime=Carbon::now('America/Caracas');
    $venta->fecha_hora=$mytime->toDateTimeString();
	$venta->fecha_emi=$request->get('fecha_emi');
	$venta->fechahora=$mytime->toDateTimeString();
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
            $detalle->idempresa=$ide;
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
public function show(Request $request, $id){
	$ide=Auth::user()->idempresa;
	$rol=DB::table('roles')-> select('editpedido','crearventa')->where('iduser','=',$request->user()->id)->first();
	     $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2')
        -> where('art.idempresa','=',$ide)
		-> where('art.estado','=','Activo')
        ->groupby('articulo','art.idarticulo')
        -> get();
    $user=Auth::user()->name;
    $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
    $venta=DB::table('venta as v')
    -> join ('clientes as p','v.idcliente','=','p.id_cliente')
    -> select ('v.idventa','v.idcliente','v.comision','v.fecha_hora','p.nombre','p.cedula','p.direccion','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
    ->where ('v.idventa','=',$id)
    -> first();
    $detalles=DB::table('detalle_pedido as dv')
    -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
	->join('categoria as cat','cat.idcategoria','=','a.idcategoria')
    -> select('a.nombre as articulo','dv.cantidad','dv.descuento','a.comi','a.pcomision','dv.iddetalle_venta','a.idarticulo','dv.preciof','dv.precio_venta','cat.licor','dv.costoarticulo as costo','a.stock','a.iva','dv.costoarticulo')
    -> where ('dv.idventa','=',$id)
	->orderby('cat.idcategoria','ASC')
    ->get();
//dd($detalles);
			$cxc=DB::table('notasadm as n')
			->join('clientes as c','c.id_cliente','=','n.idcliente')
			->select(DB::raw('sum(n.pendiente) as monto'))
			->where('n.idcliente','=',$venta->idcliente)
			->where('n.tipo','=',2)
			->where('n.pendiente','>',0)
			->groupby('n.idcliente')
			->first();
		//	dd($cxc);
		$corteHoy = date("Y-m-d");
		$credito=DB::table('venta')
		->select(DB::raw('DATEDIFF(date_format( curdate( ) , "%y%m%d" ), fecha_emi) as dias'),'diascre')
		->where('tipo_comprobante','=',"FAC")->where('devolu','=',0)->where('saldo','>',0)
		->where('idcliente','=',$venta->idcliente)
		->orderby('fecha_emi','asc')
		->limit(1)
		->first();
		//dd($credito);
    return view("pedido.venta.show",["rol"=>$rol,"credito"=>$credito,"cxc"=>$cxc,"articulos"=>$articulos,"venta"=>$venta,"empresa"=>$empresa,"detalles"=>$detalles]);
}
function facturar(Request $request){
	$ide=Auth::user()->idempresa;
		   try{
	DB::beginTransaction();
	  $tasa=DB::table('empresa')->select('tc','modop')-> where('idempresa','=',$ide)->first();
	
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
        $detalle->idempresa=$ide;
        $detalle->idventa=$idventa;
        $detalle->idarticulo=$idarticulo[$cont];
        $detalle->costoarticulo=$costoarticulo[$cont];
        $detalle->cantidad=$cantidad[$cont];
        $detalle->descuento=$descuento[$cont];
        $detalle->precio_venta=$precio_venta[$cont];
         $detalle->fecha=$mytime->toDateTimeString();	
         $detalle->fecha_emi=$fecha_emi;	
		 $detalle->fechahora=$mytime->toDateTimeString();
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
        $actventa->tasa=$tasa->tc;
        $actventa->mcosto=$request -> get('cto');
        $actventa->mivaf=$request -> get('ivaf');
        $actventa->total_iva=$request -> get('iva');
        $actventa->texe=$request -> get('exe');
        $actventa->licor=$request -> get('licor');
        $actventa->serie_comprobante=$serie;
		$actventa->montocomision=$request->get('mcomi');	
        $actventa->fecha_emi=$fecha_emi;
        $actventa->fecha_hora=$mytime->toDateTimeString();
		$actventa->fechahora=$mytime->toDateTimeString();
        $actventa->update();
		//dd($actventa);
		$cli=Pacientes::findOrFail($actventa->idcliente);
        $cli->ultventa=$mytime->toDateTimeString();
        $cli->update();
		 DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}
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
	$aux3=($detalleventa->preciof-$detalleventa->precio_venta)*$detalleventa->cantidad; //gasto ADM act
	$aux4=($request -> get('preciof') - $request -> get('precio'))*$request -> get('cantidad'); //gasto adm new

		$venta=Venta::findOrFail($request -> get('idventa'));
			if($venta->total_venta>0){
		  	 $descuento=$venta->descuento;
			 $venta->total_venta=(($venta->total_venta-($aux+$descuento))+$aux2);
			$venta->total_pagar=0;	 
			 $venta->saldo=$venta->total_venta;
			$venta->montocomision=($venta->total_venta*($venta->comision/100));
			$venta->update();	
			}
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
		$venta2=Venta::findOrFail($request -> get('idventa'));
		$venta2->saldo=($venta->total_venta-$aux3)+$aux4;
		$venta2->total_venta=($venta->total_venta-$aux3)+$aux4;
		$venta2->montocomision=((($venta->total_venta-$aux3)+$aux4)*($venta->comision/100));
		$venta2->update();
	}else{$aux3=0; }

//dd($venta2);
 DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}
return Redirect::to('pedido/pedido/'.$detalleventa->idventa);
}
	public function devolucionfac(Request $request){
			$ide=Auth::user()->idempresa;
//dd($request);
	$modo=DB::table('empresa')->select('modop')-> where('idempresa','=',$ide)->first();
	$dep=DB::table('venta')
	->join('depvendedor','depvendedor.idvendedor','=','venta.idvendedor')->select('depvendedor.id_deposito')
            ->where('venta.idventa','=',$request->get('idventa'))		
            ->first();
	//    try{
//	DB::beginTransaction();
	$user=Auth::user()->name;
    $detalleventa=DetalleVenta::findOrFail($request->iddetalle);
		$idar=$detalleventa->idarticulo;
		$vdolar=$request -> get('tasa');
		$costo=$detalleventa->costoarticulo;
		$costofacant=$costo*$detalleventa->cantidad;
		$costofnuevo=$costo*$request -> get('cantidad');
		
		$aux= $detalleventa->cantidad*$detalleventa->precio_venta;
		$aux2=$request -> get('cantidad')*$request -> get('precio');
	
		$nc=($detalleventa->cantidad-$request -> get('cantidad'));
	
		if($nc>0){$doc="DEV:P-".$request -> get('idventa'); $tipo=1; }
		
		else{ $doc="VENT-".$request -> get('idventa'); $tipo=2; $nc=($nc*-1);}
			//de la comision	
		$artcomi=Articulo::findOrFail($idar);
			if($artcomi->comi==1){
				if($modo->modop==0){
					$comiant=$aux*($request -> get('pcomi')/100);
					$cominew=$aux2*($request -> get('pcomi')/100);
					$nmcomision=($request -> get('mcomi')-$comiant)+$cominew; }
						else{
							$comiant=$aux*($artcomi->pcomision/100);
							$cominew=$aux2*($artcomi->pcomision/100);
							$nmcomision=($request -> get('mcomi')-$comiant)+$cominew;
						}
			}else{
					$nmcomision=$request -> get('mcomi');
			}	
			//->de la comision
			//gastoadmnistrativo
			$gadman=$detalleventa->cantidad*($artcomi->precio2-$detalleventa->precio_venta);
			$gadm2=$request -> get('cantidad')*($artcomi->precio2-$request -> get('precio'));	
				
			$gadm=DB::table('detalle_venta')->select('iddetalle_venta')
			->where('idventa','=',$request -> get('idventa'))
			->where('idarticulo','=',999999)
			->first();	
			//dd($gadm);	
			if(($gadm)<>NULL){	
			$actadm=DetalleVenta::findOrFail($gadm->iddetalle_venta);
			$actadm->precio_venta=($actadm->precio_venta-$gadman)+$gadm2;
			$actadm->update();
				$venta2=Venta::findOrFail($request -> get('idventa'));
				$venta2->saldo=($venta2->saldo-$gadman)+$gadm2;
				$venta2->total_venta=($venta2->total_venta-$gadman)+$gadm2;
				$venta2->update();
			}
			if($artcomi->iva>0){ 
					$subivant=truncar((($detalleventa->precio_venta)/(($artcomi->iva/100)+1)), 2);
					$subivant=($detalleventa->cantidad*truncar(($subivant*$vdolar),2));
					//
					//dd($subivant);
					$subivanew=truncar((($request -> get('precio'))/(($artcomi->iva/100)+1)), 2);
					$subivanew=($request -> get('cantidad')*truncar(($subivanew*$vdolar),2));
					//dd($subivanew);
					$ctofl=truncar(($costo*1.01),2);
					$subivaf=truncar((($ctofl)/(($artcomi->iva/100)+1)), 2);
					$subivaf=($detalleventa->cantidad*truncar(($subivaf*$vdolar),2));
				//	dd($subivaf);
					$subivafnew=truncar((($ctofl)/(($artcomi->iva/100)+1)), 2);
					$subivafnew=($request -> get('cantidad')*truncar(($subivafnew*$vdolar),2));
				$subexeant=0;
				$subexenew=0;
			}else{
				$subivant=$subivanew=$subivaf=$subivafnew=0;
					$subexeant=truncar($detalleventa->cantidad*(($detalleventa->precio_venta*$vdolar)),2);
					$subexenew=truncar($request -> get('cantidad')*(($request -> get('precio')*$vdolar)),2);
					//dd($subexeant." <->".$subexenew);
			}
			//del gasto adm
		$venta=Venta::findOrFail($request -> get('idventa'));
			$abono=$venta->total_venta-$venta->saldo;
				if($venta->total_venta>0){
					$venta->mcosto=(($venta->mcosto-$costofacant)+$costofnuevo);
					$venta->mivaf=(($venta->mivaf-$subivaf)+$subivafnew);
					$venta->total_iva=(($venta->total_iva-$subivant)+$subivanew);
					$venta->texe=(($venta->texe-$subexeant)+$subexenew);
					$descuento=$venta->descuento;
					$venta->total_venta=(($venta->total_venta-($aux+$descuento))+$aux2);
					$venta->total_pagar=0;	 
					$venta->saldo=($venta->total_venta-$abono);
					$venta->montocomision=$nmcomision;		
					$venta->update();	
				}
	$detalleventa->cantidad=$request -> get('cantidad');
	$detalleventa->precio_venta=$request -> get('precio');
	$detalleventa->update();
	$deposito=DB::table('existencia')->select('id')
            ->where('idempresa','=',$ide)
            ->where('id_almacen','=',$dep->id_deposito)		
            ->where('idarticulo','=',$idar)		
            ->first();
					
		$articulo=Articulo::findOrFail($idar);
		$stock=$articulo->stock;
		if($tipo == 1){
		$articulo->stock=($articulo->stock+$nc);
			$exis=Existencia::findOrFail($deposito->id);
					$exis->existencia=($exis->existencia+$nc);
					$exis->update();
					}else{
		$articulo->stock=($articulo->stock-$nc);
		$exis=Existencia::findOrFail($deposito->id);
					$exis->existencia=($exis->existencia-$nc);
					$exis->update();
					}
		$articulo->update();
		
			$kar=new Kardex;
			$mytime=Carbon::now('America/Caracas');
			$kar->fecha=$mytime->toDateTimeString();
			$kar->documento=$doc;
			$kar->idarticulo=$idar;
			$kar->cantidad=$nc;
			$kar->exis_ant=$stock;
			$kar->costo=$costo;
			$kar->tipo=$tipo; 
			$kar->user=$user;
			 $kar->save();
	
/* DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}*/
return Redirect::to('reportes/devolucion/'.$request -> get('idventa'));
}
public function agregargastoadm(Request $request){
//dd($request);
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
		$venta->saldo=($venta->total_venta);
		$venta->montocomision=($venta->total_venta*($venta->comision/100));
		$venta->update();
			   //dd($request);
			 return Redirect::to('pedido/pedido/'.$request->get('idped'));
}
public function destruir(Request $request){
      // dd($request);
			 $venta=Venta::findOrFail($request->get('venta'));
			 $venta->devolu=1;	
			 $venta->saldo=0;	
			 $venta->montocomision=0;	
             $venta->update();
			 return Redirect::to('pedido/pedido');
}
public function reporte(Request $request){
	$ide=Auth::user()->idempresa;
if ($request->get('idvendedor'))
        {			
	$query=trim($request->get('idvendedor'));
	$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
	$vendedor=DB::table('vendedores')-> where('idempresa','=',$ide)->where('estatus','=',1)->get();
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
	$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
	$vendedor=DB::table('vendedores')-> where('idempresa','=',$ide)->where('estatus','=',1)->get();
	$detalles=DB::table('detalle_pedido as dv')
	->join('venta as ve','ve.idventa','=','dv.idventa')
    -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
	->join('categoria as cat','cat.idcategoria','=','a.idcategoria')
    -> select(DB::raw('sum(dv.cantidad) as cantidad'),'a.nombre as articulo','a.stock','dv.iddetalle_venta','a.idarticulo')
	->where('ve.tipo_comprobante','=',"PED")
	-> where('ve.idempresa','=',$ide)
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
		$ide=Auth::user()->idempresa;
		$kar=new Detallepedido;
		$mytime=Carbon::now('America/Caracas');
		$kar->fecha=$mytime->toDateTimeString();
		$kar->idempresa=$ide;
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
		$venta->saldo=($venta->total_venta);
		$venta->montocomision=($venta->total_venta*($venta->comision/100));
		$venta->update();
  return Redirect::to('pedido/pedido/'.$request -> get('idventa'));
}
	public function descargados(Request $request)
    {
		   try {
			   $rol=DB::table('roles')-> select('importarpedido')->where('iduser','=',$request->user()->id)->first();
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$client = new Client();	
		$response = $client->request('POST', 'http://creciven.com/api/pedidos-descargados?empresa=200&limite=50');		
		$datos= $response->getBody();
		$datos2=  json_decode($datos,false);          		 
		$datos3=$datos2->data;
		//	dd($datos3);

			foreach($datos3 as $art){	
				$cliente=DB::table('clientes')->select('nombre','id_cliente')-> where('id_cliente','=',$art->cliente_id)->first();							
				$arraynombre[]		= $cliente->nombre;
			}
		} catch (Exception $e) {
			$link="pedido/descargados";
			     return view ('reportes.mensajes.sinconexion',["link"=>$link]);		
		}
		//dd($datos3);
return view ('pedido/descargados/index',["rol"=>$rol,"empresa"=>$empresa,"datos3"=>$datos3,"nombresc"=>$arraynombre]);

	}
	public function bajar($id)
	 {
		$user=Auth::user()->name;
      //  try {
		$client = new Client();	
		$response = $client->request('POST', 'http://pedidos.nks-sistemas.net/api/descargar-pedido?id='.$id);		
		$datos= $response->getBody();
		$datos2=  json_decode($datos,false);          		 
		$datos3=$datos2->data;
		//dd($datos2);
		$longitud = count($datos3);	
		$array = array();
			foreach($datos3 as $t){
			$arraycliente[] 	= $t->cliente_id;
			$arrayvend[] 		= $t->vendedor;
			$arraymonto[] 		= $t->total_pedido;
			$arraydiascre[] 	= $t->dias_credito;
			$arraycomi[] 		= $t->comision;
			$arrayarticulos[] 	= $t->articulos;	
			}
			

			for ($i=0;$i<$longitud;$i++){
				$venta=new Venta;
				$venta->idcliente=$arraycliente[$i];
				$venta->tipo_comprobante="PED";
				$venta->serie_comprobante="NE00";
					$contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->first();
					$numero=$contador->idventa;
				$venta->num_comprobante=($numero+1);
				$venta->total_venta=$arraymonto[$i];
				$mytime=Carbon::now('America/Caracas');
				$venta->fecha_hora=$mytime->toDateTimeString();
				$venta->fecha_emi=$mytime->toDateTimeString();
				$venta->impuesto='16';
				$venta->saldo=$arraymonto[$i];
				$venta->estado='Credito';	
				$venta->devolu='0';
				$venta->idvendedor=$arrayvend[$i];
				$venta->diascre=$arraydiascre[$i];
				$venta->comision=$arraycomi[$i];
				$venta->montocomision=(($arraymonto[$i])*($arraycomi[$i]/100));
				$venta->user=$user;
				$venta->pweb=1;
				$venta-> save();
				//del registro de articulo del pedido
				//$longart = count($arrayarticulos);
				
				$arr=json_decode( $arrayarticulos[$i],TRUE);  
				$longart=count($arr);
		//dd($arr);

							for ($j=0;$j<$longart;$j++){
						            $detalle=new Detallepedido();
									$detalle->idventa=$venta->idventa;
									$detalle->idarticulo=$arr[$j]['idarticulo']; 		
									$detalle->costoarticulo=(float)$arr[$j]['costo'];
									$detalle->cantidad=$arr[$j]['cantidad'];
									$detalle->descuento=0;
									$detalle->precio_venta=$arr[$j]['precio'];
									$detalle->preciof=(float)$arr[$j]['precio2'];
									//$acumgadm=($acumgadm+($arr[$j]['precio2']-$arr[$j]['precio']));
									$detalle->fecha_emi=$mytime->toDateTimeString();	
									$detalle->save();
							}   						
			}

			  return Redirect::to('pedido/pedido');
	}
	public function sector(Request $request)
	{	
		$ide=Auth::user()->idempresa;
		$municipios=DB::table('municipios')->get();
		$sectores=DB::table('parroquias')->get();
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();

      if ($request->get('filtro'))
        {
			if($request->get('filtro')=="municipios"){
			//	
			$clientes=DB::table('clientes as c')
	 		-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->join('municipios as m','m.id_municipio','=','c.idmunicipio')
			->leftjoin('venta as ve','ve.idcliente','=','c.id_cliente')
			->select('ve.idventa','c.nombre','c.cedula','c.telefono','c.direccion','m.municipio as nsector','v.id_vendedor','ve.saldo as saldoc','ve.tipo_comprobante','ve.serie_comprobante','ve.num_comprobante')
			->where('c.idmunicipio','=',$request->get('idm'))
			->where('c.idempresa','=',$ide)
			->where('ve.tipo_comprobante','=',"PED")
			->where('ve.devolu','=',0)
			->groupby('ve.idventa')
			->get();	
			$filtro=1;	
			//dd($clientes);
			}		
			if($request->get('filtro')=="parroquias"){
			$clientes=DB::table('clientes as c')
	 		-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->join('parroquias as p','p.id_parroquia','=','c.idsector')
			->leftjoin('venta as ve','ve.idcliente','=','c.id_cliente')
			->select('c.nombre','c.cedula','c.telefono','c.direccion','p.parroquia as nsector','v.id_vendedor','ve.saldo as saldoc','ve.tipo_comprobante','ve.serie_comprobante','ve.num_comprobante')
			->where('c.idsector','=',$request->get('ids'))
			->where('c.idempresa','=',$ide)
			->where('ve.tipo_comprobante','=',"PED")
			->where('ve.devolu','=',0)
			->groupby('ve.idventa')
			->get();	
			$filtro=2;	
		//	dd($clientes);
			}
		}else{
			
			$filtro=0;			
			$clientes=DB::table('clientes as c')
	 		-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->join('municipios as m','m.id_municipio','=','c.idmunicipio')
			->join('parroquias as p','p.id_parroquia','=','c.idsector')
			->leftjoin('venta as ve','ve.idcliente','=','c.id_cliente')
			->select(DB::raw('CONCAT(m.municipio," ",p.parroquia) as nsector'),'c.*','v.id_vendedor',DB::raw('sum(ve.saldo) as saldoc'),'ve.tipo_comprobante','ve.serie_comprobante','ve.num_comprobante')
			->where('ve.tipo_comprobante','=',"PED")
			->where('c.idempresa','=',$ide)
			->where('ve.devolu','=',0)
			->groupby('c.id_cliente')
			->get();
		}
		
	return view('reportes.pedidosectores.index',["filtro"=>$filtro,"municipios"=>$municipios,"sectores"=>$sectores,"clientes"=>$clientes,"empresa"=>$empresa]);
	}

}
